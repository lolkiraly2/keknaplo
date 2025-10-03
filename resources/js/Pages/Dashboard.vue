<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Főoldal" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:text-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg px-20">

                    <h1 class="noto-serif-600 text-4xl text-center mt-4">Kéknapló</h1>
                    <div class="flex flex-col md:flex-row w-1/2 mx-auto gap-5 justify-between items-center my-4">
                        <img class="w-[100px] h-[100px]" src="storage/ico/DDK_logo.png"
                            alt="Dél-Dunántúli Kéktúra logó">
                        <img class="w-[100px] h-[100px]" src="storage/ico/OKT_logo.png" alt="Országos Kéktúra logó">
                        <img class="w-[100px] h-[100px]" src="storage/ico/AK_logo.png" alt="Alföldi Kéktúra logó">
                    </div>
                    <h2 class="text-xl my-2">Mi is az a kéknapló?</h2>
                    <p class="my-2">A Kéknapló egy olyan weboldal, ami a hazai természetjárás és a kéktúrázás
                        szerelmeseinek nyújt
                        segítéget. <br> Az oldal használata regisztrációhoz kötött.</p>
                    <p>Az oldal funkciói a következőek:</p>

                    <ul class="list-disc ml-5">
                        <li class="list-disc">Kék szakaszok mentése két pont megadásával akár saját ponttal.</li>
                        <li class="list-disc">Élménybeszámolók írása a megtett szakaszokhoz.</li>
                        <li class="list-disc">A kékkörön megtett szakaszok megtekintése térképen.</li>
                        <li class="list-disc">A kékkörön található pecsétek megtekintése</li>
                        <li class="list-disc">Saját egyéni túrák tervezése több pont álltal</li>
                        <li class="list-disc">Csoportos túra szervezése és csatlakozás meglévőkhöz</li>
                        <li class="list-disc">Erdőlátogatási korlátozások megtekintése</li>
                    </ul>

                    <h2 class="text-xl my-3"> Mi is az a kéktúra?</h2>
                    <h3>Napjainkban aligha akad olyan természetjáró, aki ne hallott volna a
                        legendás kéktúráról.</h3>
                    <p class="my-2">Hazánk leghíresebb túraútvonalai páratlan lehetőségeket tartogatnak a felfedezőkedvű
                        vándoroknak,
                        a kiránduló családoknak és bárkinek, aki szereti a természetet és a túrázást. Hogy kinek és
                        miről szól a kéktúrázás, azt mindenki maga dönti el, de vitathatatlan, hogy a megtett
                        kilométerek közben olyan élményekre tehetünk szert, amelyek átformálnak bennünket, nyitottabbá
                        tesznek a természetre, gazdagítják látásmódunkat.
                    </p>

                    <p class="my-2">Az Országos Kékkör, gyakran egyszerűen csak Kékkör, három önálló túraútvonalat: az
                        Országos
                        Kéktúrát, a
                        Rockenbauer Pál Dél-dunántúli Kéktúrát és az Alföldi Kéktúrát magába foglaló egybefüggő
                        túraútvonal.
                    </p>

                    <p class="my-2">A kéktúra útvonalkövető mozgalom, amit kizárólag gyalogosan lehet szabályosan
                        teljesíteni.</p>

                    <p class="my-2">A kéktúrák speciális egysége a szakasz, ami lehet rövidebb, egy nap alatt
                        teljesíthető vagy
                        hosszabb, többnapos is. A szakaszok végén mindig találunk bélyegzőhelyet, mivel ott praktikus
                        „kiszállni”, és onnan lehet majd folytatni a kéktúrát. A szakasz persze csak egy mankó, segítség
                        ahhoz, hogy hogyan lehet megtervezni egy túrát, de nem kötelező eszerint haladni, mindenki úgy
                        tervezi meg a saját szakaszait, ahogy neki kényelmes. Ugyanígy az irány sem kötelező, és
                        időhatára sincs a teljesítésnek.</p>

                    <p class="my-2">Forrás: <a href="https://www.kektura.hu/tudastar-cikk/mi-az-a-kektura-2021-01-27"
                            class="text-sky-700">Kéktúra hivatalos tudástára</a></p>
                    <div class="bg-sky-300 w-2/3 mx-auto border-4 b border-sky-700 rounded-lg mb-6">
                        <a href="storage/okk_terkep.png"><img class="p-4" src="storage/okk_terkep.png"
                                alt="Kékkör térkép"></a>
                    </div>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>