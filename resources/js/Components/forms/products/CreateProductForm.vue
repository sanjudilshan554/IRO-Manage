<template>
  <form @submit.prevent="submitForm">
    <fieldset>
      <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input
          v-model="formData.name"
          type="text"
          id="name"
          class="form-control"
          placeholder="Enter name"
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
        />
      </div>
      <div class="mb-3">
        <label for="price" class="form-label">Price</label>
        <input
          v-model="formData.price"
          type="number"
          id="price"
          class="form-control"
          placeholder="Enter price"
        />
      </div>
      <div class="mb-3">
        <label for="category" class="form-label">Category</label>
        <input
          v-model="formData.category"
          type="text"
          id="category"
          class="form-control"
          placeholder="Enter category"
        />
      </div>
      <div class="text-right">
        <SubmitButton />
      </div>
    </fieldset>
  </form>
</template>

<script setup>
import { ref, defineEmits } from 'vue'
import SubmitButton from '@/components/common/buttons/SaveButton.vue'
import axios from 'axios'

const formData = ref({ name: '', price: 0.0, category: '', description: '' })
const emit = defineEmits(['create-product'])

const clearFormData = () => {
  formData.value = { name: '', price: 0.0, category: '', description: '' }
}

const submitForm = async () => {
  try {
    await axios.post('http://127.0.0.1:8000/api/product/store', formData.value)
    emit('create-product')
    $('#createModal').modal('hide')
    clearFormData()
  } catch (error) {
    console.error('Error creating product:', error)
  }
}
</script>
