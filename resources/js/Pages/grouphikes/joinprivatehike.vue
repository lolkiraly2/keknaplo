<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import grouphikeNav from '@/Components/grouphikeNav.vue';

const form = useForm({
  email: null,
  password: null
})
</script>


<template>

    <Head title="Csatlakozás privát túrához" />

    <AuthenticatedLayout>
        <template #header>
            <grouphikeNav></grouphikeNav>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 dark:text-white overflow-hidden shadow-sm sm:rounded-lg">

                    <div class="flex flex-col">
                
                        <div class=" w-full">
                            <div class="flex flex-col justify-center">

                                <div class="mt-8">
                                    <h2 class="text-center font-black text-2xl mb-5">Csatlakozás privát túrához</h2>

                                    <div class="error px-[20%] text-red-600 w-fit mx-auto mb-5">
                                        <p v-for="(error, key) in form.errors" :key="key">{{ error }}</p>
                                    </div>

                                    <form @submit.prevent="form.post(route('grouphikes.join_private_hike_store'))"
                                        class="grid grid-cols-2 gap-6 px-[20%]">

                                        <label for="email">Szervező email címe: </label>
                                        <input type="email" id="email" v-model="form.email" class="inp" required>

                                        <label for="password">Jelszó: </label>
                                        <input type="password" v-model="form.password" id="password"
                                            class="inp" required>

                                        <input type="submit" value="Csatlakozás" id="save" class="submit">
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
