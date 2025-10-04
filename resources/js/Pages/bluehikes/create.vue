<script setup>
import bluehikeNav from '@/Components/bluehikeNav.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router, useForm } from '@inertiajs/vue3';
import { onMounted, ref, useAttrs } from 'vue'
import "leaflet/dist/leaflet.css";
import L from "leaflet";
import 'leaflet-extra-markers';
import 'leaflet-extra-markers/dist/css/leaflet.extra-markers.min.css';
import '@raruto/leaflet-elevation/src/index.js';
import '@raruto/leaflet-elevation/src/index.css';
import 'leaflet-i18n';
import axios from 'axios';

let huLabels = {
    "Total Length: ": "Táv: ",
    "Max Elevation: ": "Legmagasabb pont: ",
    "Min Elevation: ": "Legalacsonyabb pont: ",
    "Avg Elevation: ": "Szint átlag: ",
    "Total Time: ": "Idő: ",
    "Total Ascent: ": "Emelkedés: ",
    "Total Descent: ": "Lejtés: ",
    "x: ": "Táv: ",
    "y: ": "Szint: "
};

const props = defineProps({
    stages: Object,
    startpoints: Object,
    customstartpoints: Object,
    endpoints: Object,
    customendpoints: Object,
    hike_id: Number,
})

let map;
let startpoint = null;
let endpoint = null;
let controlElevation;
let routeXML;
const today = new Date().toISOString().split('T')[0];
let attrs = useAttrs()
let startpointname = ref([])
let endpointname = ref([]);
const startcpoints = ref([]);
const endcpoints = ref([]);
const startvalue = ref(0);
const endvalue = ref(0);
const loading = ref(false);
const showForm = ref(false)
const isCustomStart = ref(false)
const isCustomEnd = ref(false)

const form = useForm({
    name: null,
    user_id: attrs.auth.user.id,
    hike_id: props.hike_id,
    isCustomStart: null,
    start_point: null,
    isCustomEnd: null,
    end_point: null,
    date: null,
    completed: 1,
    gpx: null,
    distance: null,
})

function InitMap() {
    L.registerLocale('hu', huLabels);
    L.setLocale('hu');

    map = L.map('map').setView([47.234, 18.600], 7);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> és közreműködői, Térképadatok: <a href="https://turistaterkepek.hu/">MTSZ Térinformatikai Portál</a>'
    }).addTo(map);

    L.tileLayer.wms('https://turistaterkepek.hu/server/services/Turistaut_nyilvantartas/nyilvantartaswms/MapServer/WMSServer', {
        layers: '00',
        format: 'image/png',
        transparent: true
    }).addTo(map);
}

onMounted(() => {
    InitMap();
})

function SetStartPoints() {
    if (isCustomStart.value) {
        startcpoints.value = props.customstartpoints;
        form.isCustomStart = 1;
    }

    else {
        startcpoints.value = props.startpoints;
        form.isCustomStart = 0;
    }

    startvalue.value = 0;
    if (startpoint != null)
        map.removeLayer(startpoint);
}

function ReloadStartPoints(startstage) {
    router.reload({
        only: ['startpoints', 'customstartpoints'],
        data: { startstage },
        preserveState: true,
        replace: true,
        onSuccess: () => {
            SetStartPoints();
        },
    });
}

function SetEndPoints() {
    if (isCustomEnd.value) {
        endcpoints.value = props.customendpoints;
        form.isCustomEnd = 1;
    }

    else {
        endcpoints.value = props.endpoints;
        form.isCustomEnd = 0;
    }

    endvalue.value = 0;
    if (endpoint != null)
        map.removeLayer(endpoint);
}

function ReloadEndPoints(endstage) {
    router.reload({
        only: [' endpoints', 'customendpoints'],
        data: { endstage },
        preserveState: true,
        replace: true,
        onSuccess: () => {
            SetEndPoints()
        },
    });
}

const AddStartPoint = (id) => {
    if (startpoint != null)
        map.removeLayer(startpoint);
    let point = startcpoints.value.find((item) => item.id == id)

    var blueMarker = L.ExtraMarkers.icon({
        icon: 'fa-number',
        markerColor: 'blue',
        shape: 'square',
        number: 'rajt'
    });

    startpoint = new L.marker([point.lat, point.lon], {
        icon: blueMarker
    }).addTo(map);

    form.start_point = id;
    startpointname.value = point.name;
};

const AddEndPoint = (id) => {
    if (endpoint != null)
        map.removeLayer(endpoint);
    let point = endcpoints.value.find((item) => item.id == id)

    var blueMarker = L.ExtraMarkers.icon({
        icon: 'fa-number',
        markerColor: 'blue',
        shape: 'square',
        number: 'cél'
    });

    endpoint = new L.marker([point.lat, point.lon], {
        icon: blueMarker
    }).addTo(map);
    form.end_point = id;
    endpointname.value = point.name;
};

async function PlanRoute() {
    if (startpoint == null || endpoint == null) {
        alert("Válasszon ki egy kezdő és egy végpontot!");
        return;
    }

    let latLongArray = [];

    latLongArray.push([startpoint._latlng.lat, startpoint._latlng.lng]);
    latLongArray.push([endpoint._latlng.lat, endpoint._latlng.lng]);
    // console.table( latLongArray);
    loading.value = true;
    showForm.value = false;
    try {
        const response = await axios.post('/api/get-route', {
            points: latLongArray,
            mode: 1
        });

        if (response.data.error != '') {
            alert("Nem található útvonal a megadott pontok között!\nMinden pontnak Magyarország területén kell lennie!");
            loading.value = false;
            return;
        }

        loading.value = false;
        routeXML = response.data.route;
        addGPXtoMap(routeXML);
        showForm.value = true;
        form.gpx = routeXML;
        form.name = startpointname.value + " - " + endpointname.value;

    } catch (error) {
        console.error("Error fetching the route:", error);
    }
}

function addGPXtoMap(u) {

    if (controlElevation != null) {
        controlElevation.remove();
        controlElevation.clear();
    }

    controlElevation = L.control.elevation({
        srcFolder: 'http://unpkg.com/@raruto/leaflet-elevation/src/',
        theme: "lightblue-theme",
        detached: true,
        autohide: false,
        elevationDiv: "#elevation-div",
        collapsed: false,
        closeBtn: true,
        followMarker: true,
        autofitBounds: true,
        altitude: true,
        time: true,
        distance: true,
        summary: 'inline',
        downloadLink: 'link',
        ruler: false,
        legend: false,
        almostOver: true,
        distanceMarkers: false,
        edgeScale: false,
        hotline: false,
        timestamps: false,
        preferCanvas: true
    }).addTo(map)

    controlElevation.load(routeXML);

    controlElevation.on('eledata_loaded', function (e) {
        form.distance = (e.track_info.distance).toFixed(2);
    });
}
</script>

<template>

    <Head title="Új szakasz" />

    <AuthenticatedLayout>
        <template #header>
            <bluehikeNav />
        </template>

        <div class="py-12">
            <div class="w-5/6 mx-auto sm:px-6 lg:px-6">
                <div class="bg-white dark:bg-gray-800 dark:text-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="flex md:flex-row flex-col">
                        <div class="lg:w-1/4 md:w-2/5 w-full">

                            <div class="grid gap-3 px-5 mt-5">
                                <h3 class="text-center">Kiinduló pont</h3>

                                <div class="flex flex-row justify-center items-center mb-2">
                                    <input type="checkbox" class="mr-2" v-model="isCustomStart"
                                        @change="SetStartPoints()">
                                    <p>Saját pontot használok</p>
                                </div>

                                <select class="inp w-3/4 mx-auto" @change="ReloadStartPoints($event.target.value)">
                                    <option value="0" disabled selected>Válassz szakaszt!</option>
                                    <option v-for="stage in stages" v-bind:value="stage.id">
                                        {{ stage.name }}
                                    </option>
                                </select>

                                <select class="inp w-3/4 mx-auto" v-model="startvalue"
                                    @change="AddStartPoint($event.target.value)">
                                    <option value="0" disabled selected>Válassz pontot!</option>
                                    <option v-for="startpoint in startcpoints" v-bind:value="startpoint.id">
                                        <!-- {{ startpoint.mtsz_id }} ---> {{ startpoint.name }}
                                    </option>
                                </select>

                                <h3 class="text-center">Végpont</h3>

                                <div class="flex flex-row justify-center items-center mb-2">
                                    <input type="checkbox" class="mr-2" v-model="isCustomEnd" @change="SetEndPoints()">
                                    <p>Saját pontot használok</p>
                                </div>

                                <select class="inp w-3/4 mx-auto" @change="ReloadEndPoints($event.target.value)">
                                    <option value="0" disabled selected>Válassz szakaszt!</option>
                                    <option v-for="stage in stages" v-bind:value="stage.id">
                                        {{ stage.name }}
                                    </option>
                                </select>

                                <select class="inp w-3/4 mx-auto" v-model="endvalue"
                                    @change="AddEndPoint($event.target.value)">
                                    <option value="0" disabled selected>Válassz pontot!</option>
                                    <option v-for="endpoint in endcpoints" v-bind:value="endpoint.id">
                                        <!-- {{ endpoint.mtsz_id }} ---> {{ endpoint.name }}
                                    </option>
                                </select>

                                <button class="plannerbutton mx-auto w-3/4" @click="PlanRoute()">Tervezés</button>
                                <img v-show="loading" src="../../../../public/ico/loading.gif" alt="loading gif"
                                    height="200" width="100" class="mx-auto">

                                <ul>
                                    <li v-for="(item, index) in form.errors" :key="index"
                                        class="text-red-500 text-sm px-3 text-center">
                                        {{ item }}
                                    </li>
                                </ul>

                                <form v-show="showForm" @submit.prevent="form.post(route('bluehikes.store'))">
                                    <div class="grid gap-3 px-5 mt-1">
                                        <input type="text" placeholder="Szakasz neve" id="nev" v-model="form.name"
                                            class="inp w-3/4 mx-auto" required hidden>

                                        <select class="inp w-3/4 mx-auto" v-model="form.completed">
                                            <option value="0">Tervezett</option>
                                            <option value="1">Teljesített</option>
                                        </select>

                                        <input type="date" id="date" v-model="form.date" class="inp w-3/4 mx-auto"
                                            required v-bind:min="today">

                                        <input type="submit" value="Mentés" id="save" class="submit mx-auto">
                                    </div>

                                </form>

                            </div>

                        </div>

                        <div class="lg:w-3/4 md:w-3/5 w-full">
                            <div id="map"></div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>
