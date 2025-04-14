<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import CrouteNav from '@/Components/CrouteNav.vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { onMounted, ref, nextTick } from 'vue';
import "leaflet/dist/leaflet.css";
import * as L from "leaflet";
import 'leaflet-gpx';
import 'leaflet-extra-markers';
import 'leaflet-extra-markers/dist/css/leaflet.extra-markers.min.css';
import axios from 'axios';
import '@raruto/leaflet-elevation/src/index.js';
import '@raruto/leaflet-elevation/src/index.css';
import 'leaflet-i18n';

let map;
const points = ref([]);
let markerGroup = L.layerGroup();
let marker;
let routeXML;
let routeGPX;
const loading = ref(false);
const showForm = ref(false)
let controlElevation;

const page = usePage();
const user = page.props.auth.user
const form = useForm({
  name: null,
  user_id: user.id,
  gpx: null
})

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

  map.on('click', AddMarker);

  markerGroup.addTo(map);
}

function AddMarker(e) {
  var blueMarker = L.ExtraMarkers.icon({
    icon: 'fa-number',
    markerColor: 'blue',
    shape: 'square',
    number: points.value.length + 1
  });

  marker = new L.marker([e.latlng.lat, e.latlng.lng], {
    draggable: true,
    icon: blueMarker
  });

  points.value.push(marker);
  marker.addTo(markerGroup);
}

// delete poin from points array and recalculates the numbers of the markers
const deleteRow = (index) => {
  map.removeLayer(markerGroup);
  markerGroup = L.layerGroup()

  points.value.splice(index, 1);

  for (let i = 0; i < points.value.length; i++) {
    points.value[i].options.icon.options.number = i + 1;
    points.value[i].addTo(markerGroup);
  }

  markerGroup.addTo(map);
};

function RemoveMapElements() {
  map.removeLayer(markerGroup);
  markerGroup = L.layerGroup()
  markerGroup.addTo(map);
  points.value = [];
  if (routeGPX != null)
    map.removeLayer(routeGPX);
  routeGPX = null;
  controlElevation.remove();
  controlElevation.clear();
  showForm.value = false;
}

async function PlanRoute() {

  if (points.value.length < 2) {
    alert("Legalább két pontot adjon meg!");
  }
  else {
    showForm.value = false;
    let latLongArray = [];
    points.value.forEach((point) => {
      latLongArray.push([point._latlng.lat, point._latlng.lng]);
    });
    loading.value = true;
    try {
      const response = await axios.post('/api/get-route', {
        points: latLongArray,
        mode: 0
      });

      loading.value = false;
      routeXML = response.data.route;
      addGPXtoMap(routeXML);
      showForm.value = true;
      form.gpx = routeXML;

    } catch (error) {
      console.error("Error fetching the route:", error);
    }
  }

}

function addGPXtoMap(u) {
  if (routeGPX != null)
    map.removeLayer(routeGPX);

  if (controlElevation != null) {
    controlElevation.remove();
    controlElevation.clear();
  }

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

  controlElevation.load(routeXML);

  //console.log(document.querySelector("#page"))
  setTimeout(function () {
    document.querySelector("#page").scrollIntoView({
      behavior: "smooth",
      block: "end",
    });
  }, 100);

}
</script>

<style>
.leaflet-grab {
  cursor: auto;
}

#map {
  height: 500px;
}
</style>

<template>

  <Head title="Túra tervező" />

  <AuthenticatedLayout>
    <template #header>
      <CrouteNav></CrouteNav>
    </template>

    <div class="py-12">
      <div class="max-w-8xl mx-auto sm:px-6 lg:px-8 relative z-0" id="page">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

          <div class="flex md:flex-row flex-col">
            <div class="md:w-1/4 flex flex-col flex-wrap content-center" id="menu">

              <table class="border-solid border-4 border-blue-500 rounded-full my-4">
                <tr>
                  <th colspan="2" class="text-xl">Pontok</th>
                </tr>
                <tr v-if="points.length != 0" v-for="(point, index) in points">
                  <td class="pl-6">{{ index + 1 }} pont.</td>
                  <td class="pr-4"><button @click="deleteRow(index)" class="text-red-600 text-lg font-black">x</button>
                  </td>

                </tr>
              </table>

              <button class="plannerbutton" @click="RemoveMapElements()">Útvonal törlése</button>

              <button class="plannerbutton" @click="PlanRoute()">Tervezés</button>
              <img v-show="loading" src="../../../../public/ico/Walking.gif" alt="" height="200" width="50">

              <form v-show="showForm" @submit.prevent="form.post(route('customroutes.store'))">
                <input type="text" placeholder="Túra neve" id="nev" v-model="form.name" class="mb-5 inp" required><br>
                <input type="submit" value="Mentés" id="save" class="submit">
              </form>
              <ul class="w-1/2">
                <li v-for="(item, index) in form.errors" :key="index" class="text-red-500 text-sm px-3 mb-2">
                  {{ item }}
                </li>
              </ul>
            </div>

            <div class="md:w-3/4 w-full">
              <div id="map"></div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>