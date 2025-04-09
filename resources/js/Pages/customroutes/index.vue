<script setup>
import CrouteNav from '@/Components/CrouteNav.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';

const props = defineProps({
    customroutes: Object
})

function remove(routeId){
    router.delete(route('customroutes.destroy' , routeId));
}
</script>

<template>

    <Head title="Saját túráim" />

    <AuthenticatedLayout>
        <template #header>
            <!-- <h2 class="font-semibold text-xl text-gray-800 leading-tight">Saját pont rögzítés</h2> -->
            <CrouteNav></CrouteNav>
        </template>

        <div class="py-12">
            <div class="w-3/4 sm:w-1/2 mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <h3 class="text-center font-black text-2xl mt-2">Saját túráim</h3>

                    <div class="flex justify-between items-center px-5 my-2" v-for="croute in customroutes">
                        <p class="hyphens-auto">{{ croute.name }}</p>
                        <div class="grid grid-cols-1 md:grid-cols-2 justify-items-center">
                            <button class="edit">
                                <Link :href="route('customroutes.show', croute.id)">Megtekintés</Link>
                            </button>
                            <button class="delete2" @click="remove(croute.id)">
                                Törlés
                            </button>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
