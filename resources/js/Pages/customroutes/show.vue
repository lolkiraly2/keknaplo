<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import CrouteNav from '@/Components/CrouteNav.vue';
import { Head } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';
import "leaflet/dist/leaflet.css";
import * as L from "leaflet";
import 'leaflet-extra-markers';
import 'leaflet-extra-markers/dist/css/leaflet.extra-markers.min.css';
import '@raruto/leaflet-elevation/src/index.js';
import '@raruto/leaflet-elevation/src/index.css';
import 'leaflet-i18n';

const props = defineProps({
  gpx: String,
  name: String
})

let map;
let routeXML;
let routeGPX;
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

function downloadGPX() {
  const blob = new Blob([props.gpx], { type: "application/gpx+xml" });
  const link = document.createElement("a");
  link.href = URL.createObjectURL(blob);
  link.download = props.name + ".gpx";
  document.body.appendChild(link);
  link.click();
  document.body.removeChild(link);
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

  <Head title="Túra megtekintő" />

  <AuthenticatedLayout>
    <template #header>
      <CrouteNav></CrouteNav>
    </template>

    <div class="py-12">
      <div class="max-w-8xl mx-auto sm:px-6 lg:px-8 relative z-0" id="page">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

          <div class="flex flex-col">
            <h2 class="text-center font-black text-xl my-2">{{ props.name }}</h2>
            <div id="map" class="w-full"></div>
            <button @click="downloadGPX" class="join mt-5">Útvonal letöltése</button>
          </div>

        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>