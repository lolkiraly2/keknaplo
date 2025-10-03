<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { nextTick, onMounted, ref } from 'vue'
import "leaflet/dist/leaflet.css";
import L from "leaflet";
import 'leaflet-gpx';

const props = defineProps({
  bluestages: Array,
  hikeUrls: Array,
  emptypicture: String,
  distancesum: Number,
  hike: String,
  totalDistance: Number,
})

const map = ref(null);
const progresspercent = Math.round(props.distancesum / props.totalDistance * 100);

onMounted(() => {
  InitMap();

  nextTick(() => {
    props.bluestages.forEach((stage) => {
      let stages = new L.GPX(stage, {
        async: true,
        markers: {
          startIcon: props.emptypicture,
          endIcon: props.emptypicture,
        },
        polyline_options: [{
          color: 'green',
          weight: 4.5,
        }],
      }).addTo(map.value);

    })
  })
})

function InitMap() {
  map.value = L.map('map').setView([47.234, 18.600], 7);

  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> és közreműködői, Térképadatok: <a href="https://turistaterkepek.hu/">MTSZ Térinformatikai Portál</a>'
  }).addTo(map.value);

  props.hikeUrls.forEach((hikeUrl) => {
    new L.GPX(hikeUrl, {
      markers: {
        startIcon: props.emptypicture,
        endIcon: props.emptypicture,
      },
    }).addTo(map.value);
  })

  //console.log(progresspercent);
}

</script>

<template>

  <Head title="Haladás" />

  <AuthenticatedLayout>
    <template #header>

      <div class="flex flex-col bg-white dark:bg-gray-800">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">Táv: {{ distancesum }} km/{{ totalDistance
        }} km ({{ progresspercent }}%)</h2>

        <div id="progressbar">
          <div class="h-full rounded-xl bg-white" :style="{ width: progresspercent + '%' }"></div>
        </div>
      </div>

    </template>

    <div class="py-12">
      <div class="xl:max-w-[80%] max-w-7xl mx-auto sm:px-6 lg:px-8 relative z-0">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div id="map"></div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
