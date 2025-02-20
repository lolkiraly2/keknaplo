<script setup>
import NavLink from '@/Components/NavLink.vue';
</script>

<template>
    <div class="space-x-8 my-px ms-10 flex">
                <NavLink :href="route('customroutes.index')" :active="route().current('customroutes.index')">
                    Saját túráim
                </NavLink>

                <NavLink :href="route('customroutes.create')" :active="route().current('customroutes.create')">
                    Új saját túra
                </NavLink>
            </div>
</template>