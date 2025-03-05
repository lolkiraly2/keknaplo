<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import grouphikeNav from '@/Components/grouphikeNav.vue';
import { ref, onMounted, computed } from 'vue'

const page = usePage();
const user = page.props.auth.user
const props = defineProps({
    myroutes: Object,
    grouphike: Object
})

const today = new Date().toISOString().split('T')[0];

const form = useForm({
    name: props.grouphike.name,
    start_point_name: props.grouphike.start_point_name,
    end_point_name: props.grouphike.end_point_name,
    location: props.grouphike.location,
    date: props.grouphike.date,
    gatheringtime: props.grouphike.gatheringtime,
    starttime: props.grouphike.starttime,
    public: props.grouphike.public,
    password: props.grouphike.password,
    maxparticipants: props.grouphike.maxparticipants,
    user_id: user.id,
    customroute_id: props.grouphike.customroute_id,
    description: props.grouphike.description
})

const isInvalid = computed(() => {
      return form.starttime < form.gatheringtime;
    });

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

                    <div class="flex flex-col">

                        <div class=" w-full">
                            <div class="flex flex-col justify-center">

                                <div class="mt-8">
                                    <h2 class="text-center font-black text-2xl mb-10">Új csoportos túra tervezés</h2>
                                    <form @submit.prevent="form.put(route('grouphikes.update',props.grouphike.id))"
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
                                        <p v-if="isInvalid" class="text-red-600 text-center col-span-2">Az indulás ideje nem lehet korábban a gyülekező idejénél!</p>

                                        <label for="public">Nyílvános-e: </label>
                                        <select id="public" v-model="form.public" disabled class="inp">
                                            <option value="1">Publikus</option>
                                            <option value="0">Privát</option>
                                        </select>

                                        <label for="maxparticipants">Résztvevők maximális száma: </label>
                                        <input type="number" id="maxparticipants" v-model="form.maxparticipants" min=1 max=100
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

                                        <input type="submit" v-show="!isInvalid" value="Mentés" id="save" class="submit">

                                    </form>

                                    <div class="error px-[20%] text-red-600">
                                        <p v-for="(error, key) in form.errors" :key="key">{{ error }}</p>
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
