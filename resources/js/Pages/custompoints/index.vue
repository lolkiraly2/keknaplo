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
            <Pointnav />
        </template>

        <div class="py-12">
            <div class="w-3/4 lg:w-[60%] mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 text-black dark:text-white overflow-hidden shadow-sm sm:rounded-lg">
                    <h2 class="text-center font-black text-2xl mt-2">Saját pontjaim</h2>

                    <div class="grid grid-cols-1 sm:grid-cols-3 md:grid-cols-4 px-10 items-center border-b-4 border-gray-300 sm:border-0"
                        v-for="point in points">
                        <Link :href="route('custompoints.show', point.id)"
                            class="justify-self-center sm:justify-self-start sm:ml-3 md:col-span-2">{{ point.name }}
                        </Link>
                        <p class="justify-self-center sm:justify-self-end">{{ point.stage.name }} </p>
                        <button class="diary justify-self-center sm:justify-self-end">
                            <Link :href="route('custompoints.edit', point.id)">szerkesztés</Link>
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
