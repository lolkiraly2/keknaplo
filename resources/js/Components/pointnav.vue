<script setup>
import { Link } from '@inertiajs/vue3'
</script>

<template>
    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                <Link :href="route('custompoints.index')">
                    Saját pontjaim
                </Link>

                <Link :href="route('custompoints.create')">
                    Új pont rögzítés
                </Link>
            </div>
</template>