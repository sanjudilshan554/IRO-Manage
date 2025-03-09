<template>
  <form @submit.prevent="submitForm">
    <fieldset>
      <legend>Basic Data</legend>
      <div class="mb-3">
        <label for="title" class="form-label">Title</label>
        <input
          v-model="formData.title"
          type="text"
          id="title"
          class="form-control"
          placeholder="Enter title"
          required
        />
      </div>
      <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <input
          v-model="formData.description"
          type="text"
          id="description"
          class="form-control"
          placeholder="Enter description"
          required
        />
      </div>
      <div class="text-right">
        <SubmitButton />
      </div>
    </fieldset>
  </form>
</template>

<script setup>
import { defineProps, defineEmits } from 'vue'
import SubmitButton from '@/components/common/buttons/SaveButton.vue'

defineProps({
  formData: { type: Object, required: true },
})

const emit = defineEmits(['save'])

const submitForm = () => {
  emit('save')
}
</script>
