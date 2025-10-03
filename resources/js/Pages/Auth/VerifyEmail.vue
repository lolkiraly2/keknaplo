<script setup>
import { computed } from 'vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    status: {
        type: String,
    },
});

const form = useForm({});

const submit = () => {
    form.post(route('verification.send'));
};

const verificationLinkSent = computed(() => props.status === 'verification-link-sent');
</script>

<template>
    <GuestLayout>

        <Head title="Email Verification" />

        <div class="mb-4 text-sm text-gray-600 dark:text-white">
            Kérem, erősítse meg az email címét a linkre kattintva, amit most
            küldtünk el önnek. Ha nem kapta meg az emailt, az alábbi gombra kattintva újat kérhet.
        </div>

        <div class="mb-4 font-medium text-sm text-green-600" v-if="verificationLinkSent">
            Elküldtük az új megerősítő linket a megadott email címre.
        </div>

        <form @submit.prevent="submit">
            <div class="mt-4 flex items-center justify-between">
                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    megerősítő link újraküldése
                </PrimaryButton>

                <Link :href="route('logout')" method="post" as="button"
                    class="underline text-sm text-gray-600 dark:text-white hover:text-gray-900 dark:hover:text-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Kijelentkezés</Link>
            </div>
        </form>
    </GuestLayout>
</template>
