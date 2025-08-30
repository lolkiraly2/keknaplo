<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { onMounted, nextTick, ref } from 'vue';
import { Link, } from '@inertiajs/vue3';
import Pagination from '@/Components/Pagination.vue';


const props = defineProps({
  stamps: [Object],
  hike: String
})

const hike = ref(props.hike) || 'OKK';

function IdToName($i) {
  switch ($i) {
    case '1':
      return "OKT";

    case '2':
      return 'DDK';

    case '3':
      return 'AK';
    case '4':
      return 'OKK';
  }
}

function reloadStamps(hike) {
  router.reload({
    only: ['stamps', 'hike'],
    data: { hike, page: 1 }, // <-- always set page to 1
    preserveState: true,
    replace: true,
  });
}
</script>

<style>
#map {
  height: 500px;
}
</style>

<template>

  <Head title="Pecsétek" />

  <AdminLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Pecsétek</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 relative z-0">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">


          <div class="my-6 px-5">
            <select name="hikes" class="inp" @change="reloadStamps($event.target.value)" v-model="hike">
              <option value="OKT">OKT</option>
              <option value="DDK">DDK</option>
              <option value="AK">AK</option>
              <option value="OKK">OKK</option>
            </select>

            <button class="diary p-1 ml-5">
                  <Link :href="route('stampsedit.create')">Új pecsét</Link>
                </button>
          </div>


          <div class="flex md:flex-row flex-col">
            <div class="w-[90%] mx-auto" id="pecsetek">

              <div class="flex flex-row break-all items-center border" v-for="stamp in stamps.data">
                <p class="w-[27%] p-1">{{ stamp.mtsz_id }}</p>
                <p class="w-[27%] p-1">{{ stamp.stage.name }}</p>
                <p class="w-[27%] p-1">{{ stamp.name }}</p>
                <button class="diary p-1">
                  <Link :href="route('stampsedit.edit', stamp.id)">Szerkesztés</Link>
                </button>
              </div>
              <Pagination class="mt-6" :links="stamps.links" :hike="hike" />

            </div>
          </div>

        </div>
      </div>
    </div>
  </AdminLayout>
</template>
