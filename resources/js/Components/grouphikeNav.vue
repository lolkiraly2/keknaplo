<script setup>
import NavLink from '@/Components/NavLink.vue';
</script>

<template>
    <div class="space-x-8 my-px ms-10 flex">

        <NavLink :href="route('grouphikes.index')" :active="route().current('grouphikes.index')">
            Nyilvános túrák
        </NavLink>

        <NavLink :href="route('grouphikes.futurehikes')" :active="route().current('grouphikes.futurehikes')">
            Közelgő túráim
        </NavLink>

        <NavLink :href="route('grouphikes.mygrouphikes')" :active="route().current('grouphikes.mygrouphikes')">
            Túrát vezetek
        </NavLink>

        <NavLink :href="route('grouphikes.create')" :active="route().current('grouphikes.create')">
            Új csoportos túra
        </NavLink>

        <NavLink :href="route('grouphikes.join_private_hike')" :active="route().current('grouphikes.join_private_hike')">
            Csatlakozás privát túrához
        </NavLink>
    </div>
</template>