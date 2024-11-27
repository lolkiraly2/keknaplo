<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';

const props = defineProps({
  stamp: Object,
  comments: Object
})
const page = usePage();
const user = page.props.auth.user

const today = new Date().toISOString().split('T')[0];

const form = useForm({
  eszleles_datum: null,
  allapot: null,
  leiras: null,
  username: null,
  stamp_name: null
})

form.username = user.name
form.stamp_name = props.stamp.mtsz_id
</script>

<style>
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
          <h1 class="text-center mt-3">Pecsét adatai</h1>
          <div class="flex md:flex-row flex-col-reverse">
            <div class="md:w-2/5 w-full" id="szakaszok">
              <div class="flex flex-col">
                <div class="px-3 my-3">
                  <a v-bind:href="stamp.lenyomat_url" target="_blank"><img v-bind:src="stamp.lenyomat_url"
                      alt="Pecsét lenyomat" class="rounded-lg w-full"></a>
                </div>

                <div class="px-3 my-3">
                  <a v-bind:href="stamp.kep1_url" target="_blank"><img v-bind:src="stamp.kep1_url"
                      alt="Első kép a pecsétről" class="rounded-lg"></a>
                </div>

                <div v-if="stamp.kep2_url != ''" class="px-3 my-3">
                  <a v-bind:href="stamp.kep2_url" target="_blank"><img v-bind:src="stamp.kep2_url"
                      alt="Második kép a pecsétről" class="rounded-lg"></a>
                </div>

                <div v-if="stamp.kep3_url != ''" class="px-3 my-3">
                  <a v-bind:href="stamp.kep3_url" target="_blank"><img v-bind:src="stamp.kep3_url"
                      alt="Harmadik kép a pecsétről" class="rounded-lg"></a>
                </div>
              </div>
            </div>

            <div class="md:w-3/5 w-full md:mx-10">
              <div class="grid grid-cols-2 mb-4">
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


              <fieldset class="h-[30rem] border overflow-y-scroll">
                <legend class="ml-2">Hozzászólások</legend>
                <div v-for="comment in comments" class=" border m-3 p-1">
                  <div class="flex justify-between px-3 mb-2">
                    <p>{{ comment.username }} </p>
                    <p>Érintés napja: {{ comment.eszleles_datum }}</p>
                    <p>Állapot: {{ comment.allapot }}</p>
                  </div>

                  <p class="ml-2">{{ comment.leiras }}</p>
                </div>
              </fieldset>

              <fieldset class="newcomment mt-10 border">
                <legend class="ml-2">Új hozzászólás</legend>
                <form @submit.prevent="form.post(route('stampcomments.store'))">
                  <div class="flex m-3 items-center">
                    <label for="datum" class="mr-2">Túra napja: </label>
                    <input type="date" placeholder="Saját pont neve" id="datum" v-model="form.eszleles_datum"
                      class="pl-5 m-1 inp" required v-bind:max="today">
                  </div>

                  <div class="flex items-center m-3">
                    <p class="mr-2">Pecsét állapot: </p>
                    <input type="radio" id="ok" v-model="form.allapot" class="" name="states" value="Rendben">
                    <label for="ok" class="mx-2" required>Hibátlan</label>

                    <input type="radio" id="damaged" v-model="form.allapot" class="" name="states" value="Sérült">
                    <label for="damaged" class="mx-2">Sérült</label>

                    <input type="radio" id="missing" v-model="form.allapot" class="" name="states" value="Hiányzik">
                    <label for="missing" class="mx-2">Hiányzik</label>
                  </div>

                  <div class="flex m-3 items-center">
                    <label for="leiras" class="mr-2">Szöveg:</label>
                    <textarea id="leiras" placeholder="Rövid leírás" v-model="form.leiras" class="inp w-3/4"></textarea>
                  </div>

                  <input type="submit" value="Küldés" id="save"
                    class="bg-blue-700 rounded-full hover:bg-blue-800 transition text-white px-5 py-2.5 m-3">

                </form>
              </fieldset>

            </div>

          </div>

        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>