<script setup>
import NavLink from '@/Components/NavLink.vue';
</script>

<template>
    <div class="space-x-8 my-px ms-10 flex">

        <NavLink :href="route('grouphikes.index')" :active="route().current('grouphikes.index')">
            Nyilvános túrák
        </NavLink>

        <NavLink :href="route('customroutes.index')" :active="route().current('customroutes.index')">
            Túrát vezetek
        </NavLink>

        <NavLink :href="route('grouphikes.create')" :active="route().current('grouphikes.create')">
            új csoportos túra
        </NavLink>

        <NavLink :href="route('customroutes.create')" :active="route().current('customroutes.create')">
            csatlakozás privát túrához
        </NavLink>
    </div>
</template>