<script setup>
import VendegLayout from '@/Layouts/VendegLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Főoldal" />

    <VendegLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg px-20">
                    <!-- <div class="p-6 text-gray-900">You're logged in!</div> -->
                    <h1 class="noto-serif-600 text-4xl text-center mt-4">Kéknapló</h1>
                    <div class="flex flex-col md:flex-row w-1/2 mx-auto gap-5 justify-between items-center my-4">
                        <img class="w-[100px] h-[100px]" src="storage/ico/DDK_logo.png" alt="">
                        <img class="w-[100px] h-[100px]" src="storage/ico/OKT_logo.png" alt="">
                        <img class="w-[100px] h-[100px]" src="storage/ico/AK_logo.png" alt="">
                    </div>
                    <p>Az Országos Kékkör, gyakran egyszerűen csak Kékkör, három önálló túraútvonalat: az Országos
                        Kéktúrát, a
                        Rockenbauer Pál Dél-dunántúli Kéktúrát és az Alföldi Kéktúrát magába foglaló egybefüggő
                        túraútvonal.
                    </p>
                    <img class="w-1/2 mx-auto" src="storage/okk_terkep.png" alt="">
                    <h2 class="text-xl my-3">Az oldal funkcióihoz regisztrálás után van lehetőség, amik a következőek:</h2>
                    <ul class="">
                        <li class="list-disc">Erdőlátogatási korlátozások megtekintése</li>
                        <li class="list-disc">A kékkörön található pecsétek megtekintése</li>
                        <li class="list-disc">Saját egyéni túrák tervezése több pont álltal</li>
                        <li class="list-disc">Kék szakaszok mentése két pont megadásával</li>
                        <li class="list-disc">Saját pont létrehozása, ami felhasználható a kékszakasz tervezésekor</li>
                        <li class="list-disc">Csoportos túra szervezése és csatlakozás meglévőkhöz</li>
                    </ul>

                    <!-- <h3>A kéktúra rövid története:</h3> -->
                    <p></p>

                </div>
            </div>
        </div>
    </VendegLayout>
</template>