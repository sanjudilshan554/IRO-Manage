<template>
    <button type="submit" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#AccountDeleteModal">
        {{ title }}
    </button>
</template>

<script setup>
defineProps({
    title: String
})
</script>
