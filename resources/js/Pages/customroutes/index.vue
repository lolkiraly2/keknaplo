<script setup>
import CrouteNav from '@/Components/CrouteNav.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';

const props = defineProps({
    customroutes: Object
})

function remove(routeId) {
    router.delete(route('customroutes.destroy', routeId));
}
</script>

<template>

    <Head title="Saját túráim" />

    <AuthenticatedLayout>
        <template #header>
            <CrouteNav></CrouteNav>
        </template>

        <div class="py-12">
            <div class="w-4/5 md:w-3/4 lg:w-[60%] mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <h3 class="text-center font-black text-2xl mt-2">Saját túráim</h3>

                    <div class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-5 items-center px-10 my-2 border-b-4 border-gray-300 sm:border-0 mt-2"
                        v-for="croute in customroutes">
                        <p class="hyphens-auto justify-self-center sm:justify-self-start lg:col-span-3">{{ croute.name
                        }}</p>

                        <button class="diary justify-self-center sm:justify-self-end">
                            <Link class="w-fit" :href="route('customroutes.show', croute.id)">Megtekintés</Link>
                        </button>
                        <button class="delete2 h-[30px] md:h-3/4 justify-self-center sm:justify-self-end my-2"
                            @click="remove(croute.id)">
                            Törlés
                        </button>

                    </div>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
