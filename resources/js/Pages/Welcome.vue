<script setup>
import VendegLayout from '@/Layouts/VendegLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Főoldal" />

    <VendegLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Főoldal</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">You're logged in!</div>
                </div>
            </div>
        </div>
    </VendegLayout>
</template>
