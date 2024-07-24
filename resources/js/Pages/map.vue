<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import "leaflet/dist/leaflet.css";
import L from "leaflet";
import 'leaflet-gpx';
</script>

<script>
export default {
  name: "LeafletMap",
  data() {
    return {
      gpx: null,
      map: null
    };
  },
  mounted() {
    map.value = L.map("map").setView([46.927, 17.704], 8);
    L.tileLayer("http://{s}.tile.osm.org/{z}/{x}/{y}.png", {
      attribution:
        '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map.value);

    const url = 'gpx/rpddk_teljes.gpx'; // URL to your GPX file or the GPX itself
    this.gpx = new L.GPX(url, {
      async: true,
      markers: {
        startIcon: 'gpx/empty.png',
        endIcon: 'gpx/empty.png',
      }
    }).addTo(map.value);
  },
};
</script>

<style>
#map {
  height: 500px;
}
</style>

<template>

  <Head title="Térkép" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Térkép</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div id="map"></div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
