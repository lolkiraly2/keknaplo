<script setup>
import Pointnav from '@/Components/pointnav.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3'

const props = defineProps({
    points: Array
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
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                    <table class="w-full whitespace-nowrap" v-for="point in points">
                        <tr class="text-left font-bold">
                            <th class="pb-4 pt-6 px-6">Saját pont neve</th>
                            <th class="pb-4 pt-6 px-6"></th>
                        </tr>

                        <tr>
                            <td class="px-6">{{ point.nev }}</td>
                            <td class="text-right px-6"><Link :href="route('custompoints.edit',point.id)">szerkesztés</Link></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
