<template>
  <div class="card mb-3 rating-card">
    <div class="row g-0">

      <div class="col-12 col-md-4 text-center">
        <img :src="image" class="img-fluid rounded-start small-image" alt="..." />
      </div>

      <div class="col-12 col-md-8 ps-2 pe-2">
        <div>
          <h5 class="p-0 m-0 small-title">{{ title }}</h5>
          <p class="p-0 m-0 small-subtitle">{{ subtitle }}</p>
          <p class="p-0 m-0">
            <small class="text-muted fw-bold">Last updated 3 mins ago</small>
          </p>

          <div class="rating me-3">
            <span
              v-for="star in 5"
              :key="star"
              @click="setRating(star)"
              @mouseover="hoverRating(star)"
              @mouseleave="hoverRating(0)"
              :class="['star', { filled: star <= currentRating || star <= hoverRatingValue }]"
            >
              ★
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'

defineProps({
  title: { type: String, required: true },
  subtitle: { type: String, required: true },
  image: { type: String, required: true },
})

const currentRating = ref(3)
const hoverRatingValue = ref(0)

const ratingLabels = {
  1: 'Very bad',
  2: 'Bad',
  3: 'Meh',
  4: 'Good',
  5: 'Very good',
}

const ratingLabel = computed(() => ratingLabels[currentRating.value])

const setRating = (rating) => {
  currentRating.value = rating
}

const hoverRating = (rating) => {
  hoverRatingValue.value = rating
}
</script>

<style scoped></style>
