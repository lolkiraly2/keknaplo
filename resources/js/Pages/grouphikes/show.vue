<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import grouphikeNav from '@/Components/grouphikeNav.vue';
import { onMounted, computed } from 'vue';
import { Head, usePage, useForm } from '@inertiajs/vue3';
import "leaflet/dist/leaflet.css";
import * as L from "leaflet";
import 'leaflet-extra-markers';
import 'leaflet-extra-markers/dist/css/leaflet.extra-markers.min.css';
import '@raruto/leaflet-elevation/src/index.js';
import '@raruto/leaflet-elevation/src/index.css';
import 'leaflet-i18n';
import dayjs from 'dayjs'

const page = usePage();
const user = page.props.auth.user

const props = defineProps({
  gpx: String,
  organizer: String,
  grouphike: Object,
  participants: Array,
  isJoined: Boolean,
  comments: Object
})

const form = useForm({
  grouphike_id: props.grouphike.id,
  user_id: user.id
})

const messageform = useForm({
  grouphike_id: props.grouphike.id,
  comment: null,
  user_id: user.id,
})

let map;
let controlElevation;
let huLabels = {
  "Total Length: ": "Táv: ",
  "Max Elevation: ": "Legmagasabb pont: ",
  "Min Elevation: ": "Legalacsonyabb pont: ",
  "Avg Elevation: ": "Szint átlag: ",
  "Total Time: ": "Idő: ",
  "Total Ascent: ": "Emelkedés: ",
  "Total Descent: ": "Lejtés: ",
  "x: ": "Táv: ",
  "y: ": "Szint: "
};
onMounted(() => {
  InitMap();
})

function InitMap() {
  L.registerLocale('hu', huLabels);
  L.setLocale('hu');

  map = L.map('map', {
  }).setView([47.234, 18.600], 7);

  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> és közreműködői, Térképadatok: <a href="https://turistaterkepek.hu/">MTSZ Térinformatikai Portál</a>'
  }).addTo(map);

  L.tileLayer.wms('https://turistaterkepek.hu/server/services/Turistaut_nyilvantartas/nyilvantartaswms/MapServer/WMSServer', {
    layers: '00',
    format: 'image/png',
    transparent: true
  }).addTo(map);

  addGPXtoMap()
}

function addGPXtoMap() {

  controlElevation = L.control.elevation({
    srcFolder: 'http://unpkg.com/@raruto/leaflet-elevation/src/',
    theme: "lightblue-theme",

    // Chart container outside/inside map container
    detached: true,

    // if (detached), the elevation chart container
    elevationDiv: "#elevation-div",

    // if (!detached) initial state of chart profile control
    collapsed: true,

    // Toggle close icon visibility
    closeBtn: true,

    // Autoupdate map center on chart mouseover.
    followMarker: true,

    // Autoupdate map bounds on chart update.
    autofitBounds: true,

    // Altitude chart profile: true || "summary" || "disabled" || false
    altitude: true,

    // Display time info: true || "summary" || false
    time: true,

    // Display distance info: true || "summary" || false
    distance: true,

    // Summary track info style: "inline" || "multiline" || false
    summary: 'inline',

    // Download link: "link" || false || "modal"
    downloadLink: 'link',

    // Toggle chart ruler filter
    ruler: false,

    // Toggle chart legend filter
    legend: false,

    // Toggle "leaflet-almostover" integration
    almostOver: true,

    // Toggle "leaflet-distance-markers" integration
    distanceMarkers: false,

    // Toggle "leaflet-edgescale" integration
    edgeScale: false,

    // Toggle "leaflet-hotline" integration
    hotline: false,

    // Display track datetimes: true || false
    timestamps: false,

    preferCanvas: true,
  }).addTo(map)

  controlElevation.load(props.gpx);

}

const isOrganizer = computed(() => {
  return props.grouphike.user_id === user.id;
});

function downloadGPX() {
  const blob = new Blob([props.gpx], { type: "application/gpx+xml" });
  const link = document.createElement("a");
  link.href = URL.createObjectURL(blob);
  link.download = props.grouphike.name + ".gpx";
  document.body.appendChild(link);
  link.click();
  document.body.removeChild(link);
}
function submit() {
  messageform.post(route('grouphikecomments.store'), {
    onSuccess: () => {
      messageform.comment = null;
    }
  })
}
</script>

<template>

  <Head>
    <title>{{ grouphike.name }}</title>
  </Head>

  <AuthenticatedLayout>
    <template #header>
      <grouphikeNav></grouphikeNav>
    </template>

    <div class="py-12">
      <div class="max-w-8xl mx-auto sm:px-6 lg:px-8 relative z-0" id="page">
        <div class="bg-white dark:bg-gray-800 dark:text-white overflow-hidden shadow-sm sm:rounded-lg">

          <div class="flex flex-col mt-3">

            <div class="flex md:flex-row flex-col-reverse">

              <div class="z-0 lg:w-6/10 md:w-3/5 w-full md:pr-3">
                <h1 class="text-center font-black text-2xl mb-3">{{ grouphike.name }}</h1>
                <div id="map"></div>

                <h2 class="text-center font-black text-2xl my-3 mb-5">Üzenfőfal</h2>
                <div class="px-5">
                  <div v-for="(comment, index) in comments" class="border-[3px] rounded-md m-3 p-1">
                    <div class="flex flex-col lg:justify-between px-3 mb-2">
                      <div class="flex flex-row">
                        <p>{{ comment.user.name }}</p>
                        <p class="mx-1">|</p>
                        <p >{{ dayjs(comment.created_at).format('YYYY.MM.DD HH:mm') }} </p>
                      </div>

                      <p class="ml-2">{{ comment.comment }}</p>
                    </div>
                  </div>
                </div>

                <form v-show="isOrganizer || isJoined" @submit.prevent="submit">
                  <div class="flex m-3 items-center justify-center">
                    <label for="leiras" class="mr-2"></label>
                    <textarea id="leiras" placeholder="Hozzászólás" v-model="messageform.comment"
                      class="inp w-3/4 dark:placeholder:text-white"></textarea>
                  </div>

                  <div class="flex m-3 items-center justify-center">
                    <input type="submit" value="Küldés" id="save"
                      class="bg-blue-700 rounded-full hover:bg-blue-800 transition text-white px-5 py-2.5 my-3 mx-auto">
                  </div>
                </form>
              </div>

              <div class="lg:w-4/10 md:w-2/5 w-full">
                <h1 class="text-center font-black text-2xl mb-3">Információk</h1>
                <div class="grid grid-cols-2 gap-6 px-[10%] items-center">
                  <p>Túra napja:</p>
                  <p>{{  dayjs(grouphike.date).format('YYYY.MM.DD')}}</p>
                  <p>Gyülekező: </p>
                  <p>{{ grouphike.gatheringtime }}</p>
                  <p>indulás:</p>
                  <p>{{ grouphike.starttime }}</p>
                  <p>Kiindulópont: </p>
                  <p>{{ grouphike.start_point_name }}</p>
                  <p>Végpont: </p>
                  <p>{{ grouphike.end_point_name }}</p>
                  <p>Helyszín: </p>
                  <p>{{ grouphike.location }}</p>
                  <p>Szervező: </p>
                  <p>{{ organizer }}</p>
                  <p>Maximum létszám:</p>
                  <p>{{ grouphike.maxparticipants }}</p>
                  <p>Eddig jelentkezettek száma:</p>
                  <p> {{ participants.length }}</p>
                  <p>Útvonal:</p>
                  <button class="mb-0 gpx" @click="downloadGPX">gpx letöltés</button>
                  <p class="col-span-2 text-center">Leírás: </p>
                  <p class="col-span-2">{{ grouphike.description }}</p>

                  <form @submit.prevent="form.post(route('grouphikes.join'))"
                    class="col-span-2 flex flex-row items-center" v-show="!isOrganizer && !isJoined && participants.length < grouphike.maxparticipants">
                    <input type="submit" value="Csatlakozás" id="delete" class="join">
                  </form>

                  <form @submit.prevent="form.post(route('grouphikes.cancel'))"
                    class="col-span-2 flex flex-row items-center" v-show="!isOrganizer && isJoined">
                    <input type="submit" value="Lejelentkezés" id="delete" class="join">
                  </form>

                </div>
                <!-- grid ends -->

                <div class="mx-[10%] p-5 my-5 border-2 border-solid rounded-lg">
                  <h2 class="text-center font-black text-xl">Résztvevők: </h2>
                  <p v-for="participant in participants">{{ participant }}</p>
                </div>
              </div>

            </div>

          </div>

        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>