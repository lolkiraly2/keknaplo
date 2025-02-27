<script setup>
import grouphikeNav from '@/Components/grouphikeNav.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';

const props = defineProps({
    grouphikes: Number
})

function remove(routeId){
    router.delete(route('customroutes.destroy' , routeId));
}
</script>

<template>

    <Head title="Saját pont" />

    <AuthenticatedLayout>
        <template #header>
            <!-- <h2 class="font-semibold text-xl text-gray-800 leading-tight">Saját pont rögzítés</h2> -->
           <grouphikeNav></grouphikeNav>
        </template>

        <div class="py-12">
            <div class="w-3/4 sm:w-1/2 mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <h3 class="text-center mt-2">Nyilvános túrák</h3>

                    <div class="flex justify-between items-center" v-for="croute in customroutes">
                        <p class="ml-3">{{ croute.name }}</p>
                        <div>
                            <button class="edit">
                                <Link :href="route('customroutes.show', croute.id)">Megtekintés</Link>
                            </button>
                            <button class="delete" @click="remove(croute.id)">
                                Törlés
                            </button>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
