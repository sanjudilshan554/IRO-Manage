<template>
  <button
    type="submit"
    class="btn btn-primary"
  >
    {{title}}
  </button>
</template>

<script setup>
defineProps({
    title: String
})
</script>
