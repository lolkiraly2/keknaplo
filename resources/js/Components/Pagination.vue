<script setup>
import { Link } from '@inertiajs/vue3';
defineProps({
    links: Array,
    hike: String
})
</script>

<template>
    <div v-if="links.length > 0" class="flex justify-center overflow-x-visible">
        <template v-for="(link, linkindex) in links" :kexy="linkindex">
            <div v-if="link.url === null" cl v-html="link.label"
                class="mr-1 mb-1 px-4 py-3 text-sm leading-4 text-gray-400 border rounded">


            </div>

            <Link v-else
                class="mr-1 mb-1 px-4 py-3 text-sm leading-4 text-gray-400 border rounded hover:bg-gray-200 hover:text-gray-700 focus:border-indigo-500 focus:text-indigo-500 inline-block"
                :class="{ 'bg-blue-700 text-white': link.active }" :href="link.url + (link.url.includes('?') ? '&' : '?') + 'hike=' + hike" >
                <span v-html="link.label"></span>
            </Link>

        </template>
    </div>



</template>