<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps({
 stages: [Object],
})

const form = useForm({
    mtsz_id: null,
    stamp_id: null,
    stage_id: null,
    name: null,
    location: null,
    location_description: null,
    address: null,
    availability: "Folyamatos",
    opening_hours: null,
    lat: null,
    lon: null,
    stamp_url: null,
    picture1_url: null,
    picture2_url: null,
    picture3_url: null,
})

function CheckAvailability() {
    if (form.availability === 'Folyamatos') {
        form.opening_hours = "nincs";
        return false
    } else {
        form.opening_hours = "";
        return true
    }
}


</script>


<template>

    <Head title="Új pecsét" />

    <AdminLayout>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                    <div class="flex flex-col">

                        <div class=" w-full">
                            <div class="flex flex-col justify-center">

                                <div class="mt-8">
                                    <h2 class="text-center font-black text-2xl mb-10">Új Pecsét</h2>
                                    <form @submit.prevent="form.post(route('stampsedit.store'))"
                                        class="grid grid-cols-1  sm:grid-cols-2 gap-6 px-[20%] items-center">


                                        <label for="name">MTSZ id: <span class="text-red-600"
                                                v-if="form.errors.mtsz_id"><br>{{
                                                    form.errors.mtsz_id
                                                }}</span></label>
                                        <input type="text" id="MTSZ id" v-model="form.mtsz_id" class="inp" required>

                                        <label for="stamp_id">stamp_id: <span class="text-red-600"
                                                v-if="form.errors.stamp_id"><br>{{
                                                    form.errors.stamp_id
                                                }}</span></label>
                                        <input type="text" v-model="form.stamp_id" id="stamp_id" class="inp" required>


                                        <label for="stage_id">Szakasz: <span class="text-red-600"
                                                v-if="form.errors.stage_id"><br>{{
                                                    form.errors.stage_id
                                                }}</span></label>
                                        <select id="stage_id"
                                            v-model="form.stage_id" class="inp">
                                            <option v-for="stage in props.stages" :value="stage.id">{{ stage.name }}</option>
                                        </select>


                                        <label for="name">Név: <span class="text-red-600" v-if="form.errors.name"><br>{{
                                            form.errors.name
                                                }}</span></label>
                                        <input type="text" id="name" v-model="form.name" class="inp" required>

                                        <label for="location">Helyszín: <span class="text-red-600"
                                                v-if="form.errors.location"><br>{{
                                                    form.errors.location
                                                }}</span></label>
                                        <input type="text" id="location" v-model="form.location" class="inp" required>

                                        <label for="location_description">Helyszín leírás: <span class="text-red-600"
                                                v-if="form.errors.location_description"><br>{{
                                                    form.errors.location_description
                                                }}</span></label>
                                        <input type="text" id="location_description" v-model="form.location_description"
                                            class="inp" required>

                                        <label for="address">Cím: <span class="text-red-600"
                                                v-if="form.errors.address"><br>{{
                                                    form.errors.address
                                                }}</span></label>
                                        <input type="text" id="address" v-model="form.address" class="inp" required>

                                        <label for="availability">Elérhetőség: <span class="text-red-600"
                                                v-if="form.errors.availability"><br>{{
                                                    form.errors.availability
                                                }}</span></label>
                                        <select id="availability" @change="CheckAvailability()"
                                            v-model="form.availability" class="inp">
                                            <option value="Folyamatos">Folyamatos</option>
                                            <option value="Nyitvatartás szerint">Nyitvatartás szerint</option>
                                        </select>

                                        <label v-show="CheckAvailability()" for="opening_hours">Nyitvatartás: </label>
                                        <input v-show="CheckAvailability()" type="text" id="opening_hours" v-model="form.opening_hours" class="inp" >

                                        <label for="lat">Szélesség: <span class="text-red-600"
                                                v-if="form.errors.lat"><br>{{
                                                    form.errors.lat
                                                }}</span></label>
                                        <input type="text" staps="any" id="lat" v-model="form.lat" class="inp"
                                            required>

                                        <label for="lon">Hosszúság: <span class="text-red-600"
                                                v-if="form.errors.lon"><br>{{
                                                    form.errors.lon
                                                }}</span></label>
                                        <input type="text" staps="any" id="lon" v-model="form.lon" class="inp"
                                            required>


                                        <label for="stamp_url">Pecsét url címe: <span class="text-red-600"
                                                v-if="form.errors.stamp_url"><br>{{
                                                    form.errors.stamp_url
                                                }}</span></label>
                                        <input type="url" id="stamp_url" v-model="form.stamp_url" class="inp" required>

                                        <label for="picture1_url">1. kép url címe: <span class="text-red-600"
                                                v-if="form.errors.picture1_url"><br>{{
                                                    form.errors.picture1_url
                                                }}</span></label>
                                        <input type="url" id="picture1_url" v-model="form.picture1_url" class="inp"
                                            required>

                                        <label for="picture2_url">2. kép url címe: <span class="text-red-600"
                                                v-if="form.errors.picture2_url"><br>{{
                                                    form.errors.picture2_url
                                                }}</span></label>
                                        <input type="url" id="picture2_url" v-model="form.picture2_url" class="inp">

                                        <label for="picture3_url">3. kép url címe: <span class="text-red-600"
                                                v-if="form.errors.picture3_url"><br>{{
                                                    form.errors.picture3_url
                                                }}</span></label>
                                        <input type="url" id="picture3_url" v-model="form.picture3_url" class="inp">

                                        <input type="submit" value="Létrehozás" id="save"
                                            class="submit">

                                    </form>

                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
