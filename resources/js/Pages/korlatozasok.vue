<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue'
import "leaflet/dist/leaflet.css";
import L from "leaflet";
import 'leaflet-gpx';
import '../../css/style.css'

onMounted(() => {
  InitMap();
})

function onEachFeature(feature, layer) {
  // does this feature have a property named popupContent?
  if (feature.properties && feature.properties.description) {
    let desc = "<strong>" + feature.properties.ceg + "</strong><br>" + feature.properties.description + '<br><a href =" ' + feature.properties.url + '" target="blank">link</a>';
    layer.bindPopup(desc);
  }
}

function InitMap() {
  map.value = L.map('map').setView([47.234, 18.600], 7);

  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
  }).addTo(map.value);

  L.tileLayer.wms('https://turistaterkepek.hu/server/services/Turistaut_nyilvantartas/nyilvantartaswms/MapServer/WMSServer', {
    layers: '00',
    format: 'image/png',
    transparent: true
  }).addTo(map.value);

  var style = {
    "color": "#ff7800",
    "weight": 5,
    "opacity": 0.65
  };

  let url = 'https://heyjoe.hu/erdolatogatasi_korlatozas_geojson.php';
  const response = fetch(url).then(response => response.json()).then(response => {
    L.geoJson(response, {
      style: style,
      onEachFeature: onEachFeature
    }).addTo(map.value);
  })
}
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
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">A korlátozás réteg a <a href="https://heyjoe.hu/"
          target="_blank" rel="noopener noreferrer">heyjoe.hu</a>-ról származik. További részletekről érdeklődjön az <a
          href="https://www.mtsz.org/turistautak-figyelmeztetesek" target="_blank">MTSZ</a> oldalán vagy a
        vadásztársaságok oldalán.</h2>
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
