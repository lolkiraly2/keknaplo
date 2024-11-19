<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { onMounted, nextTick } from 'vue';
import { Link } from '@inertiajs/vue3';
import "leaflet/dist/leaflet.css";
import L from "leaflet";
import 'leaflet-gpx';
import 'leaflet.markercluster';

const props = defineProps({
  stamps: Object,
  hike: String,
  stages: Object
})

let map;

onMounted(() => {
  InitMap();
  addGPXtoMap(props.hike);

  nextTick(() => {
    AddStampsToMap();
  });
})

function InitMap() {
  map = L.map('map').setView([47.234, 18.600], 7);

  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> és közreműködői, Térképadatok: <a href="https://turistaterkepek.hu/">MTSZ Térinformatikai Portál</a>'
  }).addTo(map);
}

function addGPXtoMap(u) {
  let url = "../gpx/" + u + "_teljes.gpx";

  new L.GPX(url, {
    async: true,
    markers: {
      startIcon: '../gpx/empty.png',
      endIcon: '../gpx/empty.png',
    }
  }).on('loaded', function (e) {
    map.fitBounds(e.target.getBounds());
  }).addTo(map);
}

function AddStampsToMap() {
  // let length = Object.keys(props.stamps).length;
  var icon = L.icon({
    iconUrl: '../ico/stamp.png',
    iconSize: [20, 20],
    iconAnchor: [16, 32],
  });

  var markers = L.markerClusterGroup();
  let usedstamp = [];

  Object.entries(props.stamps).forEach(([key, value]) => {
    if (!usedstamp.includes(value.mtsz_id)) {
      let marker = L.marker([value.szelesseg, value.hosszusag], { icon: icon }).bindPopup("Pecsét helye:" + value.helyszin);
      markers.addLayer(marker);
      usedstamp.push(value.mtsz_id);
    }

  });
  // console.log("szél " + props.stamps[0].szelesseg + " hossz " + props.stamps[0].hosszusag + "hossz " + length)
  map.addLayer(markers);
}

function name($h) {
  switch ($h) {
    case 'OKT':
      return "Országos Kéktúra";

    case 'DDK':
      return 'Rockenbauer Pál Dél-dunántúli Kéktúra';

    case 'AK':
      return 'Alföldi Kéktúra';
  }
}

const hikename = name(props.hike);
</script>

<style>
@import 'https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.css';
@import 'https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.Default.css';

#map {
  height: 500px;
}
</style>

<template>

  <Head title="Pecsétek" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ hikename }} pecsétei szakaszonként</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 relative z-0">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

          <div class="flex">
            <div class="basis-1/4" id="szakaszok">
              <details v-for="stage in stages">

                <summary class="hover:text-sky-600">{{ stage.nev }}. szakasz</summary>
                <p v-for=" stamp in stamps">
                  <Link :href="route('stamps.show', stamp.mtsz_id)" class="hover:text-sky-600">
                  <span v-if="stamp.stage_id === stage.id">{{ stamp.mtsz_id }} - {{ stamp.nev }}</span>
                  </Link>
                </p>

              </details>

            </div>

            <div class="basis-3/4">
              <div id="map"></div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
