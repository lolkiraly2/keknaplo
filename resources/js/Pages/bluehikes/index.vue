<script setup>
import bluehikeNav from '@/Components/bluehikeNav.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';

const props = defineProps({
    // customroutes: Object
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
            <bluehikeNav></bluehikeNav>
        </template>

        <div class="py-12">
            <div class="w-3/4 sm:w-1/2 mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <h3 class="text-center mt-2">Kéktúra szakaszaim</h3>

                    <!-- <div class="flex justify-between items-center px-4 my-2" v-for="croute in customroutes">
                        <p>{{ croute.name }}</p>
                        <div>
                            <button class="edit">
                                <Link :href="route('customroutes.show', croute.id)">Megtekintés</Link>
                            </button>
                            <button class="delete2" @click="remove(croute.id)">
                                Törlés
                            </button>
                        </div>

                    </div> -->

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
