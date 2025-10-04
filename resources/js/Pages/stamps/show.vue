<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, usePage, router } from '@inertiajs/vue3';

const props = defineProps({
  stamp: Object,
  comments: Object
})
const page = usePage();
const user = page.props.auth.user
let colors = []

const today = new Date().toISOString().split('T')[0];

const form = useForm({
  detection: null,
  state: null,
  comment: null,
  user_id: user.id,
  stamp_mtsz_id: props.stamp.mtsz_id
})

props.comments.forEach((comment) => {
  if (comment.state == 'Rendben') {
    colors.push('border-green-400')
  } else if (comment.state == 'Sérült') {
    colors.push('border-yellow-400')
  } else if (comment.state == 'Hiányzik') {
    colors.push('border-red-400')
  }
})

function submit() {
  form.post(route('stampcomments.store'), {
    onSuccess: () => {
      router.reload()
      colors = []
      props.comments.forEach((comment) => {
        if (comment.state == 'Rendben') {
          colors.push('border-green-400')
        } else if (comment.state == 'Sérült') {
          colors.push('border-yellow-400')
        } else if (comment.state == 'Hiányzik') {
          colors.push('border-red-400')
        }
      })
      form.reset()
    }
  })
}
</script>

<style>
h1 {
  font-size: xx-large;
  font-weight: bold;
}
</style>

<template>

  <Head title="Pecsétek" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">{{ stamp.mtsz_id }} - {{ stamp.name }}</h2>
    </template>

    <div class="py-12">
      <div class="xl:max-w-[80%] max-w-7xl mx-auto sm:px-6 lg:px-8 relative z-0">
        <div class="bg-white dark:bg-gray-800 dark:text-white overflow-hidden shadow-sm sm:rounded-lg">
          <h1 class="text-center mt-3">Pecsét adatai</h1>
          <div class="flex md:flex-row flex-col-reverse">
            <div class="md:w-2/5 w-full" id="szakaszok">
              <div class="flex flex-col">
                <div class="px-3 my-3">
                  <a v-bind:href="stamp.stamp_url" target="_blank"><img v-bind:src="stamp.stamp_url"
                      alt="Pecsét lenyomat" class="rounded-lg w-full"></a>
                </div>

                <div class="px-3 my-3">
                  <a v-bind:href="stamp.picture1_url" target="_blank"><img v-bind:src="stamp.picture1_url"
                      alt="Első kép a pecsétről" class="rounded-lg"></a>
                </div>

                <div v-if="stamp.picture2_url != ''" class="px-3 my-3">
                  <a v-bind:href="stamp.picture2_url" target="_blank"><img v-bind:src="stamp.picture2_url"
                      alt="Második kép a pecsétről" class="rounded-lg"></a>
                </div>

                <div v-if="stamp.picture3_url != ''" class="px-3 my-3">
                  <a v-bind:href="stamp.picture3_url" target="_blank"><img v-bind:src="stamp.picture3_url"
                      alt="Harmadik kép a pecsétről" class="rounded-lg"></a>
                </div>
              </div>
            </div>

            <div class="md:w-3/5 w-full md:mx-10">
              <div class="grid grid-cols-2 mb-4">
                <div class="pl-5 m-1">Pecsét azonosító:</div>
                <div class="pr-5 m-1">{{ stamp.mtsz_id }}</div>
                <div class="pl-5 m-1">Név:</div>
                <div class="pr-5 m-1">{{ stamp.name }}</div>
                <div class="pl-5 m-1">Helyszín:</div>
                <div class="pr-5 m-1">{{ stamp.location }}</div>
                <div class="pl-5 m-1">Helyszín leírás:</div>
                <div class="pr-5 m-1">{{ stamp.location_description }}</div>
                <div class="pl-5 m-1" v-if="stamp.address != 'nincs'">cím:</div>
                <div class="pr-5 m-1" v-if="stamp.address != 'nincs'">{{ stamp.address }}</div>
                <div class="pl-5 m-1">Elérhetőség:</div>
                <div class="pr-5 m-1">{{ stamp.availability }}</div>
                <div class="pl-5 m-1" v-if="stamp.availability != 'Folyamatos'">Nyitvatartás:</div>
                <div class="pr-5 m-1" v-if="stamp.availability != 'Folyamatos'">{{ stamp.opening_hours }}</div>
              </div>


              <fieldset class="h-[30rem] border-2 rounded-md overflow-y-scroll">
                <legend class="ml-2">Hozzászólások</legend>
                <div v-for="(comment, index) in comments" class="border-[3px] rounded-md m-3 p-1"
                  :class="colors[index]">
                  <div class="flex lg:flex-row flex-col lg:justify-between px-3 mb-2">
                    <p>{{ comment.user.name }} </p>
                    <p>Érintés napja: {{ comment.detection }}</p>
                    <p>Állapot: {{ comment.state }}</p>
                  </div>

                  <p class="ml-2">{{ comment.comment }}</p>
                </div>
              </fieldset>

              <fieldset class="newcomment mt-10 border-2 rounded-md mb-2">
                <legend class="ml-2">Új hozzászólás</legend>
                <ul>
                  <li v-for="(item, index) in form.errors" :key="index" class="text-red-500 text-sm px-3 mb-2">
                    {{ item }}
                  </li>
                </ul>
                
                <form @submit.prevent="submit">
                  <div class="flex m-3 items-center">
                    <label for="datum" class="mr-2">Túra napja: </label>
                    <input type="date" placeholder="Saját pont neve" id="datum" v-model="form.detection"
                      class="pl-5 m-1 inp" required v-bind:max="today">
                  </div>

                  <div class="flex items-center m-3">
                    <p class="mr-2">Pecsét állapot: </p>
                    <input type="radio" id="ok" v-model="form.state" class="" name="states" value="Rendben">
                    <label for="ok" class="mx-2" required>Rendben van</label>

                    <input type="radio" id="damaged" v-model="form.state" class="" name="states" value="Sérült">
                    <label for="damaged" class="mx-2">Sérült</label>

                    <input type="radio" id="missing" v-model="form.state" class="" name="states" value="Hiányzik">
                    <label for="missing" class="mx-2">Hiányzik</label>
                  </div>

                  <div class="flex m-3 items-center">
                    <label for="leiras" class="mr-2">Szöveg:</label>
                    <textarea id="leiras" placeholder="Hozzászólás" v-model="form.comment"
                      class="inp w-3/4"></textarea>
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