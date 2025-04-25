<script setup>
import grouphikeNav from '@/Components/grouphikeNav.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';

const props = defineProps({
    grouphikes: Object
})

function remove(grouphikeid){
    router.delete(route('grouphikes.destroy', grouphikeid));
}
</script>

<template>

    <Head title="Általam szervezett túrák" />

    <AuthenticatedLayout>
        <template #header>
            <!-- <h2 class="font-semibold text-xl text-gray-800 leading-tight">Saját pont rögzítés</h2> -->
           <grouphikeNav></grouphikeNav>
        </template>

        <div class="py-12">
            <div class="w-3/4 sm:w-2/3 mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <h3 class="text-center font-black text-2xl mt-4">Általam szervezett túrák</h3>

                    <div class="flex justify-between items-center border-b-4 py-2" v-for="grouphike in grouphikes">
                        <p class="ml-3">{{ grouphike.name }}</p>
                        <div class="grid grid-cols-1 justify-items-center md:justify-items-start
                         md:grid-cols-3 gap-3 py-1 items-center">
                            <button class="edit">
                                <Link :href="route('grouphikes.show', grouphike.id)">Megtekintés</Link>
                            </button>

                            <button class="edit">
                                <Link :href="route('grouphikes.edit', grouphike.id)">Szerkesztés</Link>
                            </button>

                            <button class="delete2 h-[30px] md:h-3/4" @click="remove(grouphike.id)">
                                Törlés
                            </button>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
