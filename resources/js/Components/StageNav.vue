<script setup>
import { Popover, PopoverButton, PopoverPanel } from '@headlessui/vue'
import { ChevronDownIcon } from '@heroicons/vue/20/solid'
import { Link } from '@inertiajs/vue3';

</script>

<template>
  <Popover class="relative">
    <PopoverButton
      class="inline-flex items-center gap-x-1 text-sm px-1 pt-1 font-semibold leading-6 text-gray-500 hover:text-gray-700 hover:border-gray-300 transition duration-150 ease-in-out">
      <span>Új szakasz</span>
      <ChevronDownIcon class="h-5 w-5" aria-hidden="true" />
    </PopoverButton>

    <transition enter-active-class="transition ease-out duration-200" enter-from-class="opacity-0 translate-y-1"
      enter-to-class="opacity-100 translate-y-0" leave-active-class="transition ease-in duration-150"
      leave-from-class="opacity-100 translate-y-0" leave-to-class="opacity-0 translate-y-1">
      <PopoverPanel class="absolute left-1/2 z-10 mt-5 flex w-screen max-w-max -translate-x-1/2 px-4">
        <div
          class="w-screen max-w-md flex-auto overflow-hidden rounded-3xl bg-white text-sm leading-6 shadow-lg ring-1 ring-gray-900/5">
          <div class="p-4">
            <div class="group relative flex items-center gap-x-6 rounded-lg p-4 hover:bg-gray-50">
              <div
                class="flex h-12 w-12 flex-none items-center justify-center rounded-lg bg-gray-50 group-hover:bg-white">

                <img :src="'/ico/OKT_logo.png'" alt="logo">
              </div>
              <div>
                <Link :href="route('bluehikes.create', { hike: 'OKT' })" class="font-semibold text-gray-900 text-lg">
                Országos Kéktúra</Link>
              </div>
            </div>

            <div class="group relative flex items-center gap-x-6 rounded-lg p-4 hover:bg-gray-50">
              <div
                class="flex h-12 w-12 flex-none items-center justify-center rounded-lg bg-gray-50 group-hover:bg-white">

                <img :src="'/ico/DDK_logo.png'" alt="logo">
              </div>
              <div>
                <Link :href="route('bluehikes.create', { hike: 'DDK' })" class="font-semibold text-gray-900 text-lg">
                Rockenbauer Pál Dél-dunántúli Kéktúra</Link>
              </div>
            </div>

            <div class="group relative flex items-center gap-x-6 rounded-lg p-4 hover:bg-gray-50">
              <div
                class="flex h-12 w-12 flex-none items-center justify-center rounded-lg bg-gray-50 group-hover:bg-white">

                <img :src="'/ico/AK_logo.png'" alt="logo">
              </div>
              <div>
                <Link :href="route('bluehikes.create', { hike: 'AK' })" class="font-semibold text-gray-900 text-lg"> Alföldi
                Kéktúra </Link>
              </div>
            </div>

          </div>

        </div>

      </PopoverPanel>
    </transition>
  </Popover>
</template>