<template>
  <button type="submit" class="btn btn-info">{{title}}</button>
</template>

<script setup>
defineProps({
    title: String
})
</script>
