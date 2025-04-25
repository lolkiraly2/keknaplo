<script setup>
import grouphikeNav from '@/Components/grouphikeNav.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import dayjs from 'dayjs';

const props = defineProps({
    futurehikes: Object,
})

</script>

<template>

    <Head title="Közelgő túráim" />

    <AuthenticatedLayout>
        <template #header>
            <!-- <h2 class="font-semibold text-xl text-gray-800 leading-tight">Saját pont rögzítés</h2> -->
            <grouphikeNav></grouphikeNav>
        </template>

        <div class="py-12">
            <div class="w-3/4 lg:w-[60%] mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <h3 class="text-center font-black text-2xl mt-2">Közelgő túráim</h3>

                    <div class="grid grid-cols-1 sm:grid-cols-3 md:grid-cols-5 items-center px-10 border-b-4 border-gray-300 sm:border-0"
                        v-for="futurehike in futurehikes">
                        <p class="ml-3 justify-self-center sm:justify-self-start md:col-span-3">{{ futurehike.grouphike.name }}</p>
                        <p class="justify-self-center sm:justify-self-start">{{
                            dayjs(futurehike.grouphike.date).format('YYYY.MM.DD') }}</p>
                        <button class="diary">
                            <Link :href="route('grouphikes.show', futurehike.grouphike.id)">Megtekintés</Link>
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
