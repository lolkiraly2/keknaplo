<template>
  <div class="mx-auto w-fit">
    <button @click="toggleDark"
      class="px-4 py-2 my-2 rounded bg-gray-100 hover:duration-500 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-black dark:text-white">
      {{ isDark ? '☀️ Világos téma' : '🌙 Sötét téma' }}
    </button>
  </div>

</template>

<script setup>
import { ref, onMounted } from 'vue'

const isDark = ref(false)

onMounted(() => {
  // Check saved preference OR system preference
  if (localStorage.getItem('theme')) {
    isDark.value = localStorage.getItem('theme') === 'dark'
  } else {
    isDark.value = window.matchMedia('(prefers-color-scheme: dark)').matches
  }

  document.documentElement.classList.toggle('dark', isDark.value)
})

function toggleDark() {
  isDark.value = !isDark.value
  document.documentElement.classList.toggle('dark', isDark.value)
  localStorage.setItem('theme', isDark.value ? 'dark' : 'light')
}
</script>
