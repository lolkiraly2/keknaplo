<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>

    <Head title="Főoldal" />

    <AdminLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg px-20">

                    <h1 class="noto-serif-600 text-4xl text-center mt-4">Admin panel</h1>
                    <div class="flex flex-col md:flex-row w-3/4 mx-auto gap-5 justify-between items-center my-4">

                        <a href="">
                            <div
                                class="border-2 border-gray-300 rounded-lg p-4 flex flex-col items-center hover:bg-gray-200 hover:duration-500">
                                <img class="w-[200px] h-[150px]" src="storage/trail.png" alt="Szakasz logó">
                                <p class="mt-3">Szakaszok</p>
                            </div>
                        </a>

                        <a :href="route('stampsedit.index')">
                            <div
                                class="border-2 border-gray-300 rounded-lg p-4 flex flex-col items-center hover:bg-gray-200 hover:duration-500">
                                <img class="w-[200px] h-[150px]" src="storage/stamp.png" alt="Pecsét logó">
                                <p class="mt-3">Pecsétek</p>
                            </div>
                        </a>

                        <a href="">
                            <div
                                class="border-2 border-gray-300 rounded-lg p-4 flex flex-col items-center hover:bg-gray-200 hover:duration-500">
                                <img class="w-[200px] h-[150px]" src="storage/users.png" alt="felhasználók logó">
                                <p class="mt-3">Felhasználók</p>
                            </div>
                        </a>

                    </div>

                </div>
            </div>
        </div>
    </AdminLayout>
</template>