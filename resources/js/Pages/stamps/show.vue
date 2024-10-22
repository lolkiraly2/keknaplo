<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
  stamp: Object
})
</script>

<style>
@import 'https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.css';
@import 'https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.Default.css';

#map {
  height: 500px;
}

h1 {
  font-size: xx-large;
  font-weight: bold;
}
</style>

<template>

  <Head title="Pecsétek" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ stamp.mtsz_id }} - {{ stamp.nev }}</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 relative z-0">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

          <div class="flex">
            <div class="basis-2/5" id="szakaszok">
              <div class="flex flex-col">
                <div class="m-3">
                  <a v-bind:href="stamp.lenyomat_url" target="_blank"><img v-bind:src="stamp.lenyomat_url"
                      alt="Pecsét lenyomat" class="rounded-lg"></a>
                </div>

                <div class="m-3">
                  <a v-bind:href="stamp.kep1_url" target="_blank"><img v-bind:src="stamp.kep1_url"
                      alt="Első kép a pecsétről" class="rounded-lg"></a>
                </div>

                <div v-if="stamp.kep2_url != ''" class="m-3">
                  <a v-bind:href="stamp.kep2_url" target="_blank"><img v-bind:src="stamp.kep2_url"
                      alt="Második kép a pecsétről" class="rounded-lg"></a>
                </div>

                <div v-if="stamp.kep3_url != ''" class="m-3">
                  <a v-bind:href="stamp.kep3_url" target="_blank"><img v-bind:src="stamp.kep3_url"
                      alt="Harmadik kép a pecsétről" class="rounded-lg"></a>
                </div>
              </div>
            </div>

            <div class="basis-3/5 mx-10">
              <h1 class="text-center">Pecsét adatai</h1>
              <div class="grid grid-cols-2">
                <div class="pl-5 m-1">Pecsét azonosító:</div>
                <div class="pr-5 m-1">{{ stamp.mtsz_id }}</div>
                <div class="pl-5 m-1">Név:</div>
                <div class="pr-5 m-1">{{ stamp.nev }}</div>
                <div class="pl-5 m-1">Helyszín:</div>
                <div class="pr-5 m-1">{{ stamp.helyszin }}</div>
                <div class="pl-5 m-1">Helyszín leírás:</div>
                <div class="pr-5 m-1">{{ stamp.helyszin_leiras }}</div>
                <div class="pl-5 m-1" v-if="stamp.cim != 'nincs'">cím:</div>
                <div class="pr-5 m-1" v-if="stamp.cim != 'nincs'">{{ stamp.cim }}</div>
                <div class="pl-5 m-1">Elérhetőség:</div>
                <div class="pr-5 m-1">{{ stamp.elerhetoseg }}</div>
                <div class="pl-5 m-1" v-if="stamp.elerhetoseg != 'Folyamatos'">Nyitvatartás:</div>
                <div class="pr-5 m-1" v-if="stamp.elerhetoseg != 'Folyamatos'">{{ stamp.nyitvatartas }}</div>
              </div>
            </div>

          </div>

        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>