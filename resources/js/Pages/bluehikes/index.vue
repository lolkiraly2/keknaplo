<script setup>
import bluehikeNav from '@/Components/bluehikeNav.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import dayjs from 'dayjs'

const props = defineProps({
    bluehikes: Object
})

function remove(routeId) {
    router.delete(route('bluehikes.destroy', routeId));
}
</script>

<template>

    <Head title="Saját túráim" />

    <AuthenticatedLayout>
        <template #header>
            <bluehikeNav></bluehikeNav>
        </template>

        <div class="py-12">
            <div class="w-[70%] md:w-[60%] mx-auto sm:px-6 lg:px-7">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <h3 class="text-center font-black text-2xl mt-2">Kéktúra szakaszaim</h3>

                    <div class="grid grid-cols-2 border-b-4 border-gray-300 sm:border-0 mt-2 sm:mt-0 justify-items-center sm:justify-items-start sm:grid-cols-5 md:grid-cols-7 items-center"
                        v-for="bluehike in bluehikes">
                        <p class="pl-3 sm:col-span-2 md:pl-7 md:col-span-3">{{ bluehike.name }}</p>

                        <p class=" sm:justify-self-end md:pr-5 md:col-span-2">{{
                            dayjs(bluehike.date).format('YYYY.MM.DD')
                        }}</p>
                        <button class="diary">
                            <Link :href="route('bluehikes.show', bluehike.id)">Napló</Link>
                        </button>
                        <button class="delete3" @click="remove(bluehike.id)">
                            Törlés
                        </button>

                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
