<script setup>
import grouphikeNav from '@/Components/grouphikeNav.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import dayjs from 'dayjs'

const props = defineProps({
    grouphikes: Object,
    previusgrouphikes: Object
})

function remove(grouphikeid) {
    router.delete(route('grouphikes.destroy', grouphikeid));
}
</script>

<template>

    <Head title="Általam szervezett túrák" />

    <AuthenticatedLayout>
        <template #header>
            <grouphikeNav />
        </template>

        <div class="py-12">
            <div class="w-4/5 md:w-[85%] lg:w-[75%] mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 dark:text-white overflow-hidden shadow-sm sm:rounded-lg">
                    <h2 class="text-center font-black text-2xl mt-4 mb-2">Általam szervezett túrák</h2>

                    <div class="grid grid-cols-1 sm:grid-cols-3 md:grid-cols-5 lg:grid-cols-6 items-center px-10 border-b-4 border-gray-300 md:border-0"
                        v-for="grouphike in grouphikes">
                        <p class=" lg:col-span-2 justify-self-center md:justify-self-start">
                            {{ grouphike.name }}</p>
                        <p class="justify-self-center sm:col-start-3 md:col-start-2 lg:col-start-3">
                            {{ dayjs(grouphike.date).format('YYYY.MM.DD') }}</p>
                        <button class="diary md:justify-self-end">
                            <Link :href="route('grouphikes.show', grouphike.id)">Megtekintés</Link>
                        </button>

                        <button class="diary md:justify-self-end">
                            <Link :href="route('grouphikes.edit', grouphike.id)">Szerkesztés</Link>
                        </button>

                        <button class="delete2 h-[30px] justify-self-center md:justify-self-end"
                            @click="remove(grouphike.id)">
                            Törlés
                        </button>
                    </div>

                    <h2 class="text-center font-black text-2xl mt-4 mb-2">Korábbi szervezett túráim</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-3 md:grid-cols-5 lg:grid-cols-6 items-center px-10 border-b-4 border-gray-300 md:border-0"
                        v-for="grouphike in previusgrouphikes">
                        <p class=" lg:col-span-2 justify-self-center md:justify-self-start">
                            {{ grouphike.name }}</p>
                        <p class="justify-self-center sm:col-start-3 md:col-start-2 lg:col-start-3">
                            {{ dayjs(grouphike.date).format('YYYY.MM.DD') }}</p>
                        <button class="diary md:justify-self-end">
                            <Link :href="route('grouphikes.show', grouphike.id)">Megtekintés</Link>
                        </button>

                        <button class="diary md:justify-self-end">
                            <Link :href="route('grouphikes.edit', grouphike.id)">Szerkesztés</Link>
                        </button>

                        <button class="delete2 h-[30px] justify-self-center md:justify-self-end"
                            @click="remove(grouphike.id)">
                            Törlés
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
