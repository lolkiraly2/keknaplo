<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

</script>

<script>
import "leaflet/dist/leaflet.css";
import L from "leaflet";
import 'leaflet-gpx/gpx.js';

export default {
    name: "LeafletMap",
    setup() {

    },
    data() {
        return {
            kekturak: '0',
            szakasz: 0,
            szakaszok: [],
            gpx: null,
            marker: null,
            map: null
        };
    },
    mounted() {
        this.InitMap();
    },

    props: {
        oktstages: Array,
        ddkstages: Array,
        akstages: Array,
    },

    methods: {
        InitMap() {
            this.map = L.map('map').setView([47.234, 18.600], 7);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(this.map);
            this.map.on('click', this.NewMarker);
        },

        NewMarker(e) {
            if (this.marker) this.map.removeLayer(this.marker);
            var myIcon = L.icon({
                iconUrl: 'https://raw.githubusercontent.com/iconic/open-iconic/master/png/map-marker-8x.png',
                iconSize: [32, 32],
                iconAnchor: [16, 32],
            });
            this.marker = new L.marker([e.latlng.lat, e.latlng.lng]).addTo(this.map);
            console.log("new marker")

            //console.log(this.marker)
            document.querySelector("#szel").value = this.marker._latlng.lat
            document.querySelector("#hossz").value = this.marker._latlng.lng

        },

        turavaltozas() {
            if (this.kekturak == "OKT")
                this.szakaszok = this.oktstages

            if (this.kekturak == "AK")
                this.szakaszok = this.akstages

            if (this.kekturak == "DDK")
                this.szakaszok = this.ddkstages
            //console.log(this.szakaszok)
        },

        szakaszvaltozas() {
            if (this.marker) this.map.removeLayer(this.marker);
            document.querySelector("#szel").value = ''
            document.querySelector("#hossz").value = ''
            let url = "gpx/";
            let sznev = "";

            //DDK szakasz lett választva
            if (this.kekturak == "DDK") {
                //console.log(this.ddkstages[0])
                for (let i = 0; i < this.ddkstages.length; i++)
                    if (i + 1 == this.szakasz) {
                        sznev = this.ddkstages[i].nev;
                        break;
                    }

                url += "RPDDK/" + sznev + ".gpx";
                if (this.gpx == null)
                    this.gpx = new L.GPX(url, {
                        async: true,
                        markers: {
                            startIcon: 'gpx/empty.png',
                            endIcon: 'gpx/empty.png',
                        }
                    }).on('loaded', (e) => {
                        this.map.flyToBounds(e.target.getBounds());
                        document.querySelector("#stagename").innerHTML = e.target.get_desc();
                    }).addTo(this.map);

                else {
                    this.map.removeLayer(this.gpx);
                    this.gpx = new L.GPX(url, {
                        async: true,
                        markers: {
                            startIcon: 'gpx/empty.png',
                            endIcon: 'gpx/empty.png',
                        }
                    }).on('loaded', (e) => {
                        this.map.flyToBounds(e.target.getBounds());
                        document.querySelector("#stagename").innerHTML = e.target.get_desc();
                    }).addTo(this.map);
                }
            }

            //OKT szakasz lett választva
            if (this.kekturak == "OKT") {
                for (let i = 0; i < this.oktstages.length; i++)
                    if (i + 12 == this.szakasz) {
                        //console.log(this.oktstages[i].nev);
                        sznev = this.oktstages[i].nev;
                        break;
                    }

                url += "OKT/" + sznev + ".gpx";
                if (this.gpx == null)
                    this.gpx = new L.GPX(url, {
                        async: true,
                        markers: {
                            startIcon: 'gpx/empty.png',
                            endIcon: 'gpx/empty.png',
                        }
                    }).on('loaded', (e) => {
                        this.map.flyToBounds(e.target.getBounds());
                        document.querySelector("#stagename").innerHTML = e.target.get_desc();
                    }).addTo(this.map);

                else {
                    this.map.removeLayer(this.gpx);
                    this.gpx = new L.GPX(url, {
                        async: true,
                        markers: {
                            startIcon: 'gpx/empty.png',
                            endIcon: 'gpx/empty.png',
                        }
                    }).on('loaded', (e) => {
                        this.map.flyToBounds(e.target.getBounds());
                        document.querySelector("#stagename").innerHTML = e.target.get_desc();
                    }).addTo(this.map);
                }
            }

            //AK szakasz lett választva
            if (this.kekturak == "AK") {
                for (let i = 0; i < this.akstages.length; i++)
                    if (i + 39 == this.szakasz) {
                        //console.log(this.aktstages[i].nev);
                        sznev = this.akstages[i].nev;
                        break;
                    }

                url += "AK/" + sznev + ".gpx";
                if (this.gpx == null)
                    this.gpx = new L.GPX(url, {
                        async: true,
                        markers: {
                            startIcon: 'gpx/empty.png',
                            endIcon: 'gpx/empty.png',
                        }
                    }).on('loaded', (e) => {
                        this.map.flyToBounds(e.target.getBounds());
                        document.querySelector("#stagename").innerHTML = e.target.get_desc();
                    }).addTo(this.map);
                else {
                    this.map.removeLayer(this.gpx);
                    this.gpx = new L.GPX(url, {
                        async: true,
                        markers: {
                            startIcon: 'gpx/empty.png',
                            endIcon: 'gpx/empty.png',
                        }
                    }).on('loaded', (e) => {
                        this.map.flyToBounds(e.target.getBounds());
                        document.querySelector("#stagename").innerHTML = e.target.get_desc();
                    }).addTo(this.map);
                }
            }
        }
    },

}

</script>

<style>
#map {
    height: 500px;
}

#save {
    border: 1px solid #787E8B;
}
</style>

<template>

    <Head title="Saját pont" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Saját pont rögzítés</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                    <div class="grid grid-cols-4">
                        <div class="col-span-3">
                            <div id="map"></div>
                        </div>

                        <div>
                            <div class="flex flex-col items-center">
                                <div>
                                    <select v-model="kekturak" @change="turavaltozas" class="mt-10">
                                        <option value="0" disabled :selected="true">Válassz egy kéktúrát!</option>
                                        <option value="AK">Alföldi Kéktúra</option>
                                        <option value="DDK">Dél-Dunántúli Kéktúra</option>
                                        <option value="OKT">Országos Kéktúra</option>
                                    </select>
                                </div>

                                <div>
                                    <select class="mt-2" v-model="szakasz" @change="szakaszvaltozas">
                                        <option value="0" disabled selected>Válassz szakaszt!</option>
                                        <option v-for="sz in szakaszok" v-bind:value="sz.id">
                                            {{ sz.nev }}
                                        </option>
                                    </select>
                                </div>

                                <div>
                                    <p id="stagename"></p>
                                </div>

                                <div class="w-min mt-8">
                                    <form action="">
                                        <input type="text" placeholder="Saját pont neve" id="nev" name="nev"
                                            class="mb-5" required>
                                        <input type="text" placeholder="szélesség" id="szel" name="szel" class="mb-5" disabled required>
                                        <input type="text" placeholder="hosszúság" id="hossz" name="hossz" class="mb-5" disabled required>
                                        <textarea name="leiras" id="leiras" placeholder="Rövid leírás"></textarea>
                                        <input type="submit" value="Rögzítés" id="save">
                                    </form>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
