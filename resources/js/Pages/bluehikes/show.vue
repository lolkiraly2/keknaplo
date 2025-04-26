<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import CrouteNav from '@/Components/CrouteNav.vue';
import { Head, router } from '@inertiajs/vue3';
import { onMounted } from 'vue';
import "leaflet/dist/leaflet.css";
import L from "leaflet";
import 'leaflet-extra-markers';
import 'leaflet-extra-markers/dist/css/leaflet.extra-markers.min.css';
import '@raruto/leaflet-elevation/src/index.js';
import '@raruto/leaflet-elevation/src/index.css';
import 'leaflet-i18n';
import EditorJS from '@editorjs/editorjs';
import Header from '@editorjs/header';
import EditorjsList from '@editorjs/list';
import AlignmentTuneTool from 'editorjs-text-alignment-blocktune';
import Underline from '@editorjs/underline';

const props = defineProps({
  gpx: String,
  bluehike: Object
})

let map;
let routeXML;
let routeGPX;
let controlElevation;
const jsondiary = JSON.parse(props.bluehike.diary);
const editor = new EditorJS({
  holder: 'editorjs',

  i18n: {
    messages: {
      ui: {
        blockTunes: {
          toggler: {
            'Click to tune': 'Módosítás'
          }
        },
        popover: {
          "Convert to": "Átalakítás erre",
          'Filter': 'Szűrés',

        },
        toolbar: {
          toolbox: {
            'Add': 'Új elem',
          }
        }
      },
      toolNames: {
        Text: 'Szöveg',
        Heading: 'Címsor',
        "Ordered List": "Számozott lista",
        "Unordered List": "Egyszerű lista",
        "Checklist": "Ellenőrző lista",
        "Bold": "Félkövér",
        "Italic": "Dőlt",
        "Underline": "Aláhúzott",
        "Link": "Hivatkozás",
      },
      tools: {
        list: {
          'Ordered': 'Számozott',
          'Unordered': 'Egyszerű',
          'Checklist': 'Ellenőrző lista',
          'Start with': 'Kezdőérték',
          'Counter type': 'Számozás típusa',
          'Numeric': 'Szám',
          'Lower Roman': 'Római kisbetűs',
          'Upper Roman': 'Római nagybetűs',
          'Lower Alpha': 'Kisbetűs',
          'Upper Alpha': 'Nagybetűs'
        },
        header: {
          'Heading 1': 'Címsor 1',
          'Heading 2': 'Címsor 2',
          'Heading 3': 'Címsor 3',
          'Heading 4': 'Címsor 4',
          'Heading 5': 'Címsor 5',
          'Heading 6': 'Címsor 6'
        },
        "convertTo": {
          "Convert to": "Átalakítás erre"
        }
      },
      blockTunes: {
        delete: {
          'Delete': 'Törlés',
          'Click to delete': 'Törlés'
        },
        moveUp: {
          'Move up': 'Mozgatás felfelé'
        },
        moveDown: {
          'Move down': 'Mozgatás lefelé'
        }
      }
    }
  },

  tools: {
    header: {
      class: Header,
      inlineToolbar: true,
      tunes: ['align']
    },

    list: {
      class: EditorjsList,
      inlineToolbar: true,
      config: {
        defaultStyle: 'unordered'
      }
    },

    align: {
      class: AlignmentTuneTool,
      config: {
        default: "left",
        blocks: {
          header: 'center',
        }
      },
    },

    paragraph: {
      inlineToolbar: true,
      tunes: ['align']
    },

    underline: Underline
  },
  data: jsondiary
})


let huLabels = {
  "Total Length: ": "Táv: ",
  "Max Elevation: ": "Legmagasabb pont: ",
  "Min Elevation: ": "Legalacsonyabb pont: ",
  "Avg Elevation: ": "Szint átlag: ",
  "Total Time: ": "Idő: ",
  "Total Ascent: ": "Emelkedés: ",
  "Total Descent: ": "Lejtés: ",
  "x: ": "Táv: ",
  "y: ": "Szint: "
};
onMounted(() => {
  InitMap();
})

function InitMap() {
  L.registerLocale('hu', huLabels);
  L.setLocale('hu');

  map = L.map('map', {
  }).setView([47.234, 18.600], 7);

  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> és közreműködői, Térképadatok: <a href="https://turistaterkepek.hu/">MTSZ Térinformatikai Portál</a>'
  }).addTo(map);

  L.tileLayer.wms('https://turistaterkepek.hu/server/services/Turistaut_nyilvantartas/nyilvantartaswms/MapServer/WMSServer', {
    layers: '00',
    format: 'image/png',
    transparent: true
  }).addTo(map);

  addGPXtoMap()
}

function addGPXtoMap() {

  controlElevation = L.control.elevation({
    srcFolder: 'http://unpkg.com/@raruto/leaflet-elevation/src/',
    theme: "lightblue-theme",

    // Chart container outside/inside map container
    detached: true,

    // if (detached), the elevation chart container
    elevationDiv: "#elevation-div",

    // if (!detached) initial state of chart profile control
    collapsed: true,

    // Toggle close icon visibility
    closeBtn: true,

    // Autoupdate map center on chart mouseover.
    followMarker: true,

    // Autoupdate map bounds on chart update.
    autofitBounds: true,

    // Altitude chart profile: true || "summary" || "disabled" || false
    altitude: true,

    // Display time info: true || "summary" || false
    time: true,

    // Display distance info: true || "summary" || false
    distance: true,

    // Summary track info style: "inline" || "multiline" || false
    summary: 'inline',

    // Download link: "link" || false || "modal"
    downloadLink: 'link',

    // Toggle chart ruler filter
    ruler: false,

    // Toggle chart legend filter
    legend: false,

    // Toggle "leaflet-almostover" integration
    almostOver: true,

    // Toggle "leaflet-distance-markers" integration
    distanceMarkers: false,

    // Toggle "leaflet-edgescale" integration
    edgeScale: false,

    // Toggle "leaflet-hotline" integration
    hotline: false,

    // Display track datetimes: true || false
    timestamps: false,

    preferCanvas: true,
  }).addTo(map)

  controlElevation.load(props.gpx);

}

function downloadGPX() {
  const blob = new Blob([props.gpx], { type: "application/gpx+xml" });
  const link = document.createElement("a");
  link.href = URL.createObjectURL(blob);
  link.download = props.bluehike.name + ".gpx";
  document.body.appendChild(link);
  link.click();
  document.body.removeChild(link);
}


function Saving() {
  editor.save().then((outputData) => {
   
    router.post('/bluehikes/savediary', {
      bluehike_id: props.bluehike.id,
      diary: JSON.stringify(outputData)
    });


  }).catch((error) => {
    console.log('Saving failed: ', error)
  });

}
</script>

<style>
.leaflet-grab {
  cursor: auto;
}

#map {
  height: 500px;
}
</style>

<template>

  <Head title="Túra megtekintő" />

  <AuthenticatedLayout>
    <template #header>
      <CrouteNav></CrouteNav>
    </template>

    <div class="py-12">
      <div class="max-w-8xl mx-auto sm:px-6 lg:px-8 relative z-0" id="page">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

          <div class="flex flex-col">
            <h1 class="text-center text-2xl font-black my-2">{{ bluehike.name }}</h1>
            <div id="map" class="w-full"></div>
            <button @click="downloadGPX" class="join my-5">Útvonal letöltése</button>
            <h2 class="text-center text-xl font-black my-2">Napló</h2>
            <div id="editorjs" class="border-2 rounded-md border-black w-2/3 mx-auto my-5 p-5"></div>
            <button @click="Saving" class="join">Mentés</button>
          </div>

        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>