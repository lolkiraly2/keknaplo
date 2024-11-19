<script setup>
import NavLink from '@/Components/NavLink.vue';
</script>

<template>
    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                <NavLink :href="route('custompoints.index')" :active="route().current('custompoints.index')">
                    Saját pontjaim
                </NavLink>

                <NavLink :href="route('custompoints.create')" :active="route().current('custompoints.create')">
                    Új pont rögzítés
                </NavLink>
            </div>
</template>