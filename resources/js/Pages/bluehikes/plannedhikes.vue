<script setup>
import bluehikeNav from '@/Components/bluehikeNav.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import dayjs from 'dayjs'

const props = defineProps({
    plannedhikes: Object
})

function complete(bluehike) {
    router.post(route('bluehikes.completehike', bluehike));
}

function remove(routeId) {
    router.delete(route('bluehikes.destroy', routeId));
}
</script>

<template>

    <Head title="Saját túráim" />

    <AuthenticatedLayout>
        <template #header>
            <bluehikeNav />
        </template>

        <div class="py-12">
            <div class="w-[75%] lg:w-[60%] mx-auto sm:px-6 lg:px-7">
                <div class="bg-white dark:bg-gray-800 dark:text-white overflow-hidden shadow-sm sm:rounded-lg">
                    <h3 class="text-center font-black text-2xl mt-2">Tervezett kéktúra szakaszaim</h3>

                    <div class="grid border-b-4 border-gray-300 sm:border-0 px-5 justify-items-center sm:justify-items-start grid-cols-1 sm:grid-cols-2 md:grid-cols-6 items-center"
                        v-for="bluehike in plannedhikes">
                        <p class="pl-3 md:pl-7 md:col-span-2 justify-self-center md:justify-self-start">
                            {{ bluehike.name }}
                        </p>

                        <p class="justify-self-center md:justify-self-end md:pr-5 md:col-span-2">
                            {{ dayjs(bluehike.date).format('YYYY.MM.DD') }}
                        </p>
                        <button class="diary justify-self-cenet md:justify-self-end" @click="complete(bluehike)">
                            Teljesítve
                        </button>
                        <button class="delete3 justify-self-center md:justify-self-end" @click="remove(bluehike.id)">
                            Törlés
                        </button>

                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
