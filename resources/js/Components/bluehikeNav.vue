<script setup>
import NavLink from '@/Components/NavLink.vue';
import StageNav from './StageNav.vue';
</script>

<template>
    <div class="space-x-8 my-px ms-10 flex">

        <NavLink :href="route('bluehikes.index')" :active="route().current('bluehikes.index')">
            Megtett szakaszaim
        </NavLink>

        <NavLink :href="route('bluehikes.plannedhikes')" :active="route().current('bluehikes.plannedhikes')">
            Tervezett szakaszaim
        </NavLink>

        <StageNav />
    </div>
</template>