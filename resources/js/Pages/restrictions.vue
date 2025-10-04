<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { onMounted } from 'vue'
import "leaflet/dist/leaflet.css";
import L from "leaflet";
import { FeatureLayer } from "esri-leaflet";

onMounted(() => {
  InitMap();
})

let map;
function InitMap() {
  map = L.map('map').setView([47.234, 18.600], 7);

  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> és közreműködői, Térképadatok: <a href="https://turistaterkepek.hu/">MTSZ Térinformatikai Portál</a>'
  }).addTo(map);

  L.tileLayer.wms('https://turistaterkepek.hu/server/services/Turistaut_nyilvantartas/nyilvantartaswms/MapServer/WMSServer', {
    layers: '0',
    format: 'image/png',
    transparent: true
  }).addTo(map);

  const fr = new FeatureLayer({
    url: 'https://turistaterkepek.hu/server/rest/services/alapadatok/korlatozasok/MapServer/0',
    style: () => {
      return {
        color: 'orange',
        weight: 2,
        fillColor: 'orange',
        fillOpacity: 0.4
      };
    }
  }).addTo(map);

  fr.bindPopup(function (layer) {
    let kezdet = new Date(layer.feature.properties.ervenyesseg_kezdete).toISOString().split('T')[0];
    let vege = new Date(layer.feature.properties.ervenyesseg_vege).toISOString().split('T')[0];
    return L.Util.template(
      "<h3>{name}.</h3> <p>Erdészet: {erdeszet}.</p> <p>{description}.</p><p>Érvenyesség kezdete:" + 
        kezdet + "<br>Érvenyesség vége: " + vege + "</p> <p><a target='blank' href={hir_url}>link</a></p>",
      layer.feature.properties
    );
  });

}
</script>

<template>

  <Head title="Korlátozások" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">Erdőlátogatási korlátozások</h2>
    </template>

    <div class="py-12">
      <div class="xl:max-w-[80%] max-w-7xl mx-auto sm:px-6 lg:px-8 z-0 relative">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div id="map"></div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>