<script setup>
import Pointnav from '@/Components/pointnav.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    points: Object
})
</script>

<template>

    <Head title="Saját pont" />

    <AuthenticatedLayout>
        <template #header>
            <!-- <h2 class="font-semibold text-xl text-gray-800 leading-tight">Saját pont rögzítés</h2> -->
            <Pointnav></Pointnav>
        </template>

        <div class="py-12">
            <div class="w-3/4 sm:w-1/2 mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <h3 class="text-center font-black text-2xl mt-2">Saját pont neve</h3>

                    <div class="flex justify-between items-center px-10" v-for="point in points">
                        <Link :href="route('custompoints.show', point.id)" class="ml-3">{{ point.name }}</Link>
                        <button class="edit">
                            <Link :href="route('custompoints.edit', point.id)">szerkesztés</Link>
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
