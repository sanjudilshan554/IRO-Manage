<template>
   <button class="btn btn-danger" @click="$emit('click')">{{ title }}</button>
</template>

<script setup>

defineProps({
  title: String
});

</script>
