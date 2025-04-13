<script setup>
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { useFavicon } from '@vueuse/core';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import pecsetek from '@/Components/pecsetek.vue';
import ProgressNav from '@/Components/ProgressNav.vue';
import { Link } from '@inertiajs/vue3';
const showingNavigationDropdown = ref(false);
const icon = useFavicon();
icon.value = "/storage/sav-kek.jpg";
</script>

<template>
    <div>
        <div class="min-h-screen bg-gray-100">
            <nav class="bg-white border-b border-gray-100">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex items-center">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center">
                                <Link :href="route('dashboard')">
                                <ApplicationLogo class="block h-9 w-auto fill-current text-gray-800" />
                                </Link>
                            </div>

                            <!-- Navigation Links -->
                            <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex sm:items-center">

                                <ProgressNav></ProgressNav>

                                <NavLink :href="route('custompoints.index')">
                                    Saját pontjaim
                                </NavLink>

                                <NavLink :href="route('bluehikes.index')">
                                    Kék szakaszaim
                                </NavLink>

                                <NavLink :href="route('customroutes.index')" :active="route().current('customroutes.index')">
                                    Túráim
                                </NavLink>

                                <NavLink :href="route('grouphikes.index')" :active="route().current('grouphikes.index')">
                                   Csoportos túrák
                                </NavLink>

                                <pecsetek></pecsetek>

                                <NavLink :href="route('restrictions')" :active="route().current('restrictions')">
                                    Korlátozások
                                </NavLink>
                            </div>

                        </div>



                        <div class="hidden sm:flex sm:items-center sm:ms-6">
                            <!-- Settings Dropdown -->
                            <div class="ms-3 relative">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button type="button"
                                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                                {{ $page.props.auth.user.name }}

                                                <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <DropdownLink :href="route('profile.edit')"> Profil </DropdownLink>
                                        <DropdownLink :href="route('logout')" method="post" as="button">
                                            Kijelentkezés
                                        </DropdownLink>
                                    </template>
                                </Dropdown>
                            </div>
                        </div>

                        <!-- Hamburger -->
                        <div class="-me-2 flex items-center sm:hidden">
                            <button @click="showingNavigationDropdown = !showingNavigationDropdown"
                                class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path :class="{
                                        hidden: showingNavigationDropdown,
                                        'inline-flex': !showingNavigationDropdown,
                                    }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16" />
                                    <path :class="{
                                        hidden: !showingNavigationDropdown,
                                        'inline-flex': showingNavigationDropdown,
                                    }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div :class="{ block: showingNavigationDropdown, hidden: !showingNavigationDropdown }"
                    class="sm:hidden">

                    <div class="pt-1 pb-2 space-y-1">
                        <p 
                            class="block w-full ps-3 pe-4 pt-2 pb-1 border-l-4 border-transparent text-start text-base font-medium text-gray-600">
                            Haladás
                        </p>
                    </div>

                    <div class="pt-0 pb-0 space-y-1">
                        <ResponsiveNavLink :href="route('bluehikes.progress', { hike: 'OKT' })" class="pl-4 pb-1 pt-0">
                            • Országos Kéktúra
                        </ResponsiveNavLink>
                    </div>

                    <div class="pt-0 pb-0 space-y-1">
                        <ResponsiveNavLink :href="route('bluehikes.progress', { hike: 'DDK' })"  class="pl-4 pb-1">
                            • Rockenbauer Pál Dél-dunántúli Kéktúra
                        </ResponsiveNavLink>
                    </div>

                    <div class="pt-0 pb-0 space-y-1">
                        <ResponsiveNavLink :href="route('bluehikes.progress', { hike: 'AK' })" class="pl-4 pb-1">
                            • Alföldi Kéktúra 
                        </ResponsiveNavLink>
                    </div>

                    <div class="pt-0 pb-0 space-y-1">
                        <ResponsiveNavLink :href="route('bluehikes.progress', { hike: 'OKK' })" class="pl-4 pb-1">
                            • Országos Kékkör
                        </ResponsiveNavLink>
                    </div>

                    <div class="pt-1 pb-2 space-y-1">
                        <ResponsiveNavLink :href="route('custompoints.index')"
                            :active="route().current('custompoints.index')">
                            Saját pontjaim
                        </ResponsiveNavLink>
                    </div>

                    <div class="pt-1 pb-2 space-y-1">
                        <ResponsiveNavLink :href="route('bluehikes.index')" :active="route().current('bluehikes.index')">
                           Kék szakaszaim
                        </ResponsiveNavLink>
                    </div>

                    <div class="pt-1 pb-2 space-y-1">
                        <ResponsiveNavLink :href="route('customroutes.index')" :active="route().current('customroutes.index')">
                            Túráim
                        </ResponsiveNavLink>
                    </div>

                    <div class="pt-1 pb-2 space-y-1">
                        <ResponsiveNavLink :href="route('grouphikes.index')" :active="route().current('grouphikes.index')">
                                   Csoportos túrák
                                </ResponsiveNavLink>
                    </div>

                    <div class="pt-1 pb-2 space-y-1">
                        <p 
                            class="block w-full ps-3 pe-4 pt-2 pb-1 border-l-4 border-transparent text-start text-base font-medium text-gray-600">
                            Pecsétek
                        </p>
                    </div>

                    <div class="pt-0 pb-0 space-y-1">
                        <ResponsiveNavLink :href="route('stamps.index', { hike: 'OKT' })" class="pl-4 pb-1 pt-0">
                            • Országos Kéktúra
                        </ResponsiveNavLink>
                    </div>

                    <div class="pt-0 pb-0 space-y-1">
                        <ResponsiveNavLink :href="route('stamps.index', { hike: 'DDK' })"  class="pl-4 pb-1">
                            • Rockenbauer Pál Dél-dunántúli Kéktúra
                        </ResponsiveNavLink>
                    </div>

                    <div class="pt-0 pb-0 space-y-1">
                        <ResponsiveNavLink :href="route('stamps.index', { hike: 'AK' })" class="pl-4 pb-1">
                            • Alföldi Kéktúra 
                        </ResponsiveNavLink>
                    </div>

                    <div class="pt-1 pb-2 space-y-1">
                        <ResponsiveNavLink :href="route('restrictions')" :active="route().current('restrictions')">
                            Korlátozások
                        </ResponsiveNavLink>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 border-t border-gray-200">
                        <div class="px-4">
                            <div class="font-medium text-base text-gray-800">
                                {{ $page.props.auth.user.name }}
                            </div>
                            <div class="font-medium text-sm text-gray-500">{{ $page.props.auth.user.email }}</div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <ResponsiveNavLink :href="route('profile.edit')"> Profil </ResponsiveNavLink>
                            <ResponsiveNavLink :href="route('logout')" method="post" as="button">
                                Kijelentkezés
                            </ResponsiveNavLink>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header class="bg-white shadow" v-if="$slots.header">
                <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <slot />
            </main>
        </div>
    </div>
</template>
