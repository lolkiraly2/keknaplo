<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import grouphikeNav from '@/Components/grouphikeNav.vue';
import { computed } from 'vue';

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
    maxparticipants: null,
    user_id: user.id,
    customroute_id: null,
    description: null
})

const isInvalid = computed(() => {
    return form.starttime < form.gatheringtime;
});

</script>


<template>

    <Head title="Új csoportos túra" />

    <AuthenticatedLayout>
        <template #header>
            <grouphikeNav></grouphikeNav>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                    <div class="flex flex-col">

                        <div class=" w-full">
                            <div class="flex flex-col justify-center">

                                <div class="mt-8">
                                    <h2 class="text-center font-black text-2xl mb-10">Új csoportos túra tervezés</h2>
                                    <form @submit.prevent="form.post(route('grouphikes.store'))"
                                        class="grid grid-cols-2 gap-6 px-[20%]">


                                        <label for="name">Túra neve: <span class="text-red-600"
                                                v-if="form.errors.name"><br>{{
                                                    form.errors.name
                                                }}</span></label>
                                        <input type="text" id="name" v-model="form.name" class="inp" required>

                                        <label for="start_point_name">Kiindulópont neve: <span class="text-red-600"
                                                v-if="form.errors.start_point_name"><br>{{
                                                    form.errors.start_point_name
                                                }}</span></label>
                                        <input type="text" v-model="form.start_point_name" id="start_point_name"
                                            class="inp" required>

                                        <label for="end_point_name">Végpont neve: <span class="text-red-600"
                                                v-if="form.errors.end_point_name"><br>{{
                                                    form.errors.end_point_name
                                                }}</span></label>
                                        <input type="text" id="end_point_name" v-model="form.end_point_name" class="inp"
                                            required>

                                        <label for="location">Túra helyszíne: <span class="text-red-600"
                                                v-if="form.errors.location"><br>{{
                                                    form.errors.location
                                                }}</span></label>
                                        <input type="text" id="location" v-model="form.location" class="inp" required>

                                        <label for="date">Túra időpontja: <span class="text-red-600"
                                                v-if="form.errors.date"><br>{{
                                                    form.errors.date
                                                }}</span></label>
                                        <input type="date" id="date" v-model="form.date" class="inp" required
                                            v-bind:min="today">

                                        <label for="gatheringtime">Gyülekező: <span class="text-red-600"
                                                v-if="form.errors.gatheringtime"><br>{{
                                                    form.errors.gatheringtime
                                                }}</span></label>
                                        <input type="time" id="gatheringtime" v-model="form.gatheringtime" class="inp"
                                            required>

                                        <label for="starttime">indulás: <span class="text-red-600"
                                                v-if="form.errors.starttime"><br>{{
                                                    form.errors.starttime
                                                }}</span></label>
                                        <input type="time" id="starttime" v-model="form.starttime" class="inp" required>
                                        <p v-if="isInvalid" class="text-red-600 text-center col-span-2">
                                            Az indulás ideje nem lehet korábban a gyülekező idejénél!
                                        </p>

                                        <label for="public">Nyílvános-e: <span class="text-red-600"
                                                v-if="form.errors.public"><br>{{
                                                    form.errors.public
                                                }}</span><br>
                                            <span class="text-red-600">Később nem
                                                módosítható!</span></label>
                                        <select id="public" v-model="form.public" class="inp">
                                            <option value="1">Publikus</option>
                                            <option value="0">Privát</option>
                                        </select>

                                        <label v-if="form.public == 0" for="password">Jelszó:<br>
                                            <span class="text-red-600">Később nem
                                                módosítható!</span> </label>
                                        <input type="password" id="password" v-model="form.password"
                                            v-if="form.public == 0" class="inp" required>

                                        <label for="maxparticipants">Résztvevők maximális száma:<span
                                                class="text-red-600" v-if="form.errors.maxparticipants"><br>{{
                                                    form.errors.maxparticipants
                                                }}</span></label>
                                        <input type="number" id="maxparticipants" v-model="form.maxparticipants" min=1
                                            max=100 class="inp" required>

                                        <label for="route">Túra útvonala: <span class="text-red-600"
                                                v-if="form.errors.customroute_id"><br>{{
                                                    form.errors.customroute_id
                                                }}</span></label>
                                        <select id="route" v-model="form.customroute_id" class="inp">
                                            <option v-for="croute in myroutes" v-bind:value="croute.id">
                                                {{ croute.name }}
                                            </option>
                                        </select>
                                        <label for="description">Rövid leírás: <span class="text-red-600"
                                                v-if="form.errors.description"><br>{{
                                                    form.errors.description
                                                }}</span></label>
                                        <textarea id="description" v-model="form.description" class="inp"
                                            required></textarea>

                                        <input type="submit" v-show="!isInvalid" value="Létrehozás" id="save"
                                            class="submit">

                                    </form>

                                    <!-- <div class="error px-[20%] text-red-600">
                                        <p v-for="(error, key) in form.errors" :key="key">{{ error }}</p>
                                    </div> -->
                                    <div>
                                        {{ form.errors.description }}
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
