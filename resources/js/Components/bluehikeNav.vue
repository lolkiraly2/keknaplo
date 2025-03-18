<script setup>
import NavLink from '@/Components/NavLink.vue';
</script>

<template>
    <div class="space-x-8 my-px ms-10 flex">

        <NavLink :href="route('bluehikes.index')" :active="route().current('bluehikes.index')">
            Megtett szakaszaim
        </NavLink>

        <NavLink :href="route('grouphikes.futurehikes')" :active="route().current('grouphikes.futurehikes')">
            Tervezett szakaszaim
        </NavLink>

        <NavLink :href="route('grouphikes.mygrouphikes')" :active="route().current('grouphikes.mygrouphikes')">
            Új OKT szakasz
        </NavLink>

        <NavLink :href="route('grouphikes.create')" :active="route().current('grouphikes.create')">
            Új DDK szakasz
        </NavLink>

        <NavLink :href="route('grouphikes.join_private_hike')" :active="route().current('grouphikes.join_private_hike')">
            Új AK szakasz
        </NavLink>
    </div>
</template>