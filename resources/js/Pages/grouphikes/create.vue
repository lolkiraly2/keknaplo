<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import grouphikeNav from '@/Components/grouphikeNav.vue';
import { ref, onMounted } from 'vue'
import "leaflet/dist/leaflet.css";
import L from "leaflet";
import 'leaflet-gpx/gpx.js';

const page = usePage();
const user = page.props.auth.user
const props = defineProps({
    myroutes: Object
})

const today = new Date().toISOString().split('T')[0];

const form = useForm({
    name: null,
    start_point_name: null,
    end_point_name: null,
    location: null,
    date: null,
    gatheringtime: null,
    starttime: null,
    public: null,
    password: null,
    user_id: user.id,
    customroute_id: null,
    description: null
})

let map;

onMounted(() => {
    InitMap();
})

function InitMap() {
    map = L.map('map').setView([47.234, 18.600], 7);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> és közreműködői'
    }).addTo(map);

    L.tileLayer.wms('https://turistaterkepek.hu/server/services/Turistaut_nyilvantartas/nyilvantartaswms/MapServer/WMSServer', {
        layers: '00',
        format: 'image/png',
        transparent: true
    }).addTo(map);
}

</script>

<style>
#map {
    height: 500px;
}
</style>

<template>

    <Head title="Új csoportos túra" />

    <AuthenticatedLayout>
        <template #header>
            <grouphikeNav></grouphikeNav>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                    <div class="flex flex-col-reverse">
                        <div class="w-full md:pr-3 px-3">
                            <div id="map"></div>
                        </div>

                        <div class=" w-full">
                            <div class="flex flex-col justify-center">

                                <div class="mt-8">
                                    <h2 class="text-center font-black text-2xl mb-10">Új csoportos túra tervezés</h2>
                                    <form @submit.prevent="form.post(route('grouphikes.store'))"
                                        class="grid grid-cols-2 gap-6 px-[20%]">


                                        <label for="name">Túra neve: </label>
                                        <input type="text" id="name" v-model="form.name" class="inp" required>

                                        <label for="start_point_name">Kiindulópont neve: </label>
                                        <input type="text" v-model="form.start_point_name" id="start_point_name"
                                            class="inp" required>

                                        <label for="end_point_name">Végpont neve: </label>
                                        <input type="text" id="end_point_name" v-model="form.end_point_name" class="inp"
                                            required>

                                        <label for="location">Túra helyszíne: </label>
                                        <input type="text" id="location" v-model="form.location" class="inp" required>

                                        <label for="date">Túra időpontja: </label>
                                        <input type="date" id="date" v-model="form.date" class="inp" required
                                            v-bind:min="today">

                                        <label for="gatheringtime">Gyülekező: </label>
                                        <input type="time" id="gatheringtime" v-model="form.gatheringtime" class="inp"
                                            required>

                                        <label for="starttime">indulás: </label>
                                        <input type="time" id="starttime" v-model="form.starttime" class="inp" required>

                                        <label for="public">Nyílvános-e: </label>
                                        <select id="public" v-model="form.public" class="inp">
                                            <option value="1">Publikus</option>
                                            <option value="0">Privát</option>
                                        </select>

                                        <label v-if="form.public == 0" for="password">Jelszó: </label>
                                        <input type="text" id="password" v-model="form.password" v-if="form.public == 0"
                                            class="inp" required>

                                        <label for="route">Túra útvonala: </label>
                                        <select id="route" v-model="form.customroute_id" class="inp">
                                            <option v-for="croute in myroutes" v-bind:value="croute.id">
                                                {{ croute.name }}
                                            </option>
                                        </select>
                                        <label for="description">Rövid leírás: </label>
                                        <textarea id="description" v-model="form.description" class="inp"
                                            required></textarea>

                                        <input type="submit" value="Létrehozás" id="save" class="submit">

                                    </form>

                                    <div class="error px-[20%] text-red-600">
                                        <p v-for="(error,key) in form.errors" :key="key">{{ error }}</p>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
