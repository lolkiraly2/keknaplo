<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue'
import "leaflet/dist/leaflet.css";
import L from "leaflet";
import 'leaflet-gpx';

const props = defineProps({
  stamps: Object,
  hike: String
})

const map = ref(null);

onMounted(() => {
  InitMap();
  addGPXtoMap(props.hike);
  AddStampsToMap();
})

function InitMap() {
  map.value = L.map('map').setView([47.234, 18.600], 7);

  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> és közreműködői, Térképadatok: <a href="https://turistaterkepek.hu/">MTSZ térképportál</a>'
  }).addTo(map.value);
}

function addGPXtoMap(u) {
  let url = "../gpx/" + u + "_teljes.gpx";

  new L.GPX(url, {
    async: true,
    markers: {
      startIcon: '../gpx/empty.png',
      endIcon: '../gpx/empty.png',
    }
  }).on('loaded', (e) => {
    map.value.flyToBounds(e.target.getBounds());
  }).addTo(map.value);
}

function AddStampsToMap() {
  // let length = Object.keys(props.stamps).length;
  var icon = L.icon({
    iconUrl: '../ico/stamp.png',
    iconSize: [32, 32],
    iconAnchor: [16, 32],
  });

  Object.entries(props.stamps).forEach(([key, value]) => {
    new L.marker([value.szelesseg, value.hosszusag]).addTo(map.value).bindPopup("Pecsét helye:" + value.helyszin);
  });
  // console.log("szél " + props.stamps[0].szelesseg + " hossz " + props.stamps[0].hosszusag + "hossz " + length)
}
</script>

<style>
#map {
  height: 500px;
}
</style>

<template>

  <Head title="Pecsétek" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Térkép</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 relative z-0">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

          <div class="flex">
            <div class="basis-1/4">
              <p v-for="stamp in stamps">{{ stamp.nev }}</p>
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
