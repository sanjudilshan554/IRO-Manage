<template>
  <div v-if="isLoading" class="loading-screen">
    <img :src="companyLogo" alt="Loading" class="loading-image" />
  </div>
</template>

<script setup>
import { defineProps } from 'vue'
import companyLogo from '@/src/assets/loader-images/loader.png'

defineProps({
  isLoading: {
    type: Boolean,
    required: true,
  },
})
</script>

<style scoped>
.loading-screen {
  position: fixed;
  top: 0;
  left: 0;
  width: 100vw;
  height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  background-color: rgba(122, 122, 122, 0.062) !important;
  z-index: 9999;
}

.loading-image {
  width: 150px;
  animation: blink 1s infinite;
}

@keyframes blink {
  0%,
  100% {
    opacity: 1;
  }
  50% {
    opacity: 0;
  }
}
</style>
