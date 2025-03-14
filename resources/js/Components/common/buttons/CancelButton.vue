<template>
    <button
      class="btn btn-secondary"
    >
      {{title}}
    </button>
  </template>

  <script setup>
defineProps({
    title: String
})
</script>
