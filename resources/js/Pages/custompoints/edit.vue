<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import Pointnav from '@/Components/pointnav.vue';
import { ref, onMounted } from 'vue'
import "leaflet/dist/leaflet.css";
import L from "leaflet";
import 'leaflet-gpx/gpx.js';

const page = usePage();
const user = page.props.auth.user
console.log(user.name)
const props = defineProps({
    oktstages: Array,
    ddkstages: Array,
    akstages: Array,
    cpoint: Object,
    stage: String
})

const kekturak = ref('OKT');
const szakasz = ref(null);
const szakaszok = ref(null);
const gpx = ref(null);
const marker = ref(null);
const map = ref(null);
const stagename = ref('');

const form = useForm({
    nev: props.cpoint.nev,
    stage_id: props.cpoint.stage_id,
    szelesseg: props.cpoint.szelesseg,
    hosszusag: props.cpoint.hosszusag,
    leiras: props.cpoint.leiras,
    user_id: props.cpoint.user_id

})
form.user_id = user.id

onMounted(() => {
    InitMap();
    console.log(user.id)
})

function InitMap() {
    map.value = L.map('map').setView([47.234, 18.600], 7);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> és közreműködői'
    }).addTo(map.value);

    if (props.stage[0] == 'D')
        kekturak.value = "DDK";
    if (props.stage[0] == 'A')
        kekturak.value = "AK";
    if (props.stage[0] == 'B')
        kekturak.value = "BFK";
    let url = "../../gpx/" + kekturak.value + "/" + props.stage + ".gpx";
    szakasz.value = props.cpoint.stage_id
    turavaltozas();
    addGPXtoMap(url)
    marker.value = new L.marker([props.cpoint.szelesseg, props.cpoint.hosszusag]).addTo(map.value);

    map.value.on('click', NewMarker);
}

function NewMarker(e) {
    if (marker.value) map.value.removeLayer(marker.value);
    var myIcon = L.icon({
        iconUrl: 'https://raw.githubusercontent.com/iconic/open-iconic/master/png/map-marker-8x.png',
        iconSize: [32, 32],
        iconAnchor: [16, 32],
    });
    marker.value = new L.marker([e.latlng.lat, e.latlng.lng]).addTo(map.value);
    // console.log("new marker")

    //console.log(this.marker)
    form.szelesseg = marker.value._latlng.lat
    form.hosszusag = marker.value._latlng.lng
}

function turavaltozas() {
    if (kekturak.value == "OKT")
        szakaszok.value = props.oktstages
    if (kekturak.value == "AK")
        szakaszok.value = props.akstages

    if (kekturak.value == "DDK")
        szakaszok.value = props.ddkstages
    //console.log(this.szakaszok)
}

function addGPXtoMap(u) {
    if (gpx.value != null)
        map.value.removeLayer(gpx.value);

    gpx.value = new L.GPX(u, {
        async: true,
        markers: {
            startIcon: '../../gpx/empty.png',
            endIcon: '../../gpx/empty.png',
        }
    }).on('loaded', (e) => {
        map.value.flyToBounds(e.target.getBounds());
        stagename.value = e.target.get_desc();
    }).addTo(map.value);

}

function szakaszvaltozas() {
    form.szelesseg = null;
    form.hosszusag = null;
    form.stage_id = szakasz.value;
    // form.stage_id = this.szakasz;
    if (marker.value) map.value.removeLayer(marker.value);
    let url = "../../gpx/";
    let sznev = "";

    //DDK szakasz lett választva
    if (kekturak.value == "DDK") {
        //console.log(this.ddkstages[0])
        for (let i = 0; i < props.ddkstages.length; i++)
            if (i + 1 == szakasz.value) {
                sznev = props.ddkstages[i].nev;
                break;
            }
        url += "DDK/" + sznev + ".gpx";
        addGPXtoMap(url);
    }

    //OKT szakasz lett választva
    if (kekturak.value == "OKT") {
        for (let i = 0; i < props.oktstages.length; i++)
            if (i + 12 == szakasz.value) {
                //console.log(this.oktstages[i].nev);
                sznev = props.oktstages[i].nev;
                break;
            }

        url += "OKT/" + sznev + ".gpx";
        addGPXtoMap(url);
    }

    //AK szakasz lett választva
    if (kekturak.value == "AK") {
        for (let i = 0; i < props.akstages.length; i++)
            if (i + 39 == szakasz.value) {
                //console.log(this.aktstages[i].nev);
                sznev = props.akstages[i].nev;
                break;
            }

        url += "AK/" + sznev + ".gpx";
        addGPXtoMap(url);
    }
}
</script>

<style>
#map {
    height: 35rem;
}

</style>

<template>

    <Head title="Saját pont" />

    <AuthenticatedLayout>
        <template #header>
            <Pointnav></Pointnav>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                    <div class="flex md:flex-row flex-col-reverse">
                        <div class="z-0 lg:w-3/4 md:w-3/5 w-full md:pr-3 px-3">
                            <div id="map"></div>
                        </div>

                        <div class="lg:w-1/4 md:w-2/5 w-full">
                            <div class="flex flex-col items-center">
                                <div>
                                    <select v-model="kekturak" @change="turavaltozas" class="mt-8 inp">
                                        <option value="AK">Alföldi Kéktúra</option>
                                        <option value="DDK">Dél-Dunántúli Kéktúra</option>
                                        <option value="OKT">Országos Kéktúra</option>
                                    </select>
                                </div>

                                <div>
                                    <select class="mt-2 inp" v-model="szakasz" @change="szakaszvaltozas">
                                        <option v-for="sz in szakaszok" v-bind:value="sz.id">
                                            {{ sz.nev }}
                                        </option>
                                    </select>
                                </div>

                                <div>
                                    <p>{{ stagename }}</p>
                                </div>

                                <div class="mt-8">
                                    <form @submit.prevent="form.put(route('custompoints.update', props.cpoint.id))"  class="flex flex-col items-center">

                                        <input type="text" placeholder="Saját pont neve" id="nev" v-model="form.nev"
                                            class="mb-5 inp" required>
                                        <input type="text" placeholder="szélesség" id="szel" v-model="form.szelesseg"
                                            class="mb-5 inp" disabled required>
                                        <input type="text" placeholder="hosszúság" id="hossz" v-model="form.hosszusag"
                                            class="mb-5 inp" disabled required>
                                        <textarea id="leiras" placeholder="Rövid leírás (opcionális)"
                                            v-model="form.leiras" class="mb-5 inp"></textarea>
                                        <input type="submit" value="Mentés" class="submit">
                                    </form>
                                </div>

                                <form @submit.prevent="form.delete(route('custompoints.destroy', props.cpoint.id))">
                                    <input type="submit" value="Törlés" id="delete" class="delete">
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
