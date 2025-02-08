<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { onMounted, nextTick, ref } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import "leaflet/dist/leaflet.css";
import L from "leaflet";
import 'leaflet-gpx';
import 'leaflet-extra-markers';
import 'leaflet-extra-markers/dist/css/leaflet.extra-markers.min.css';

const props = defineProps({

})

let map;
const points = ref([]);
let markerGroup = L.layerGroup();
let marker;
let zgpx;

onMounted(() => {
  InitMap();
})

function InitMap() {
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

// Kitöröl egy pontot az n-edik pontot a points tömbből, és lefrissíti a markerGroupot
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

function RemoveAllPoints() {
  map.removeLayer(markerGroup);
  markerGroup = L.layerGroup()
  markerGroup.addTo(map);
  points.value = [];
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
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Túra tervező</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 relative z-0">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

          <div class="flex md:flex-row flex-col">
            <div class="md:w-1/4 flex flex-col flex-wrap content-center" id="menu">

              <table class="border-solid border-4 border-blue-500 rounded-full my-4">
                <tr>
                  <th colspan="2" class="text-xl">Pontok</th>
                </tr>
                <tr v-if="points.length != 0" v-for="(point, index) in points">
                  <td class="pl-6">{{ index + 1 }} pont.</td>
                  <td class="pr-4"><button @click="deleteRow(index)" class="text-red-600 text-lg font-black">x</button></td>

                </tr>
              </table>

              <button class="plannerbutton"
                @click="RemoveAllPoints()">Pontok törlése</button>

              <button
                class="plannerbutton">Tervezés</button>

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
