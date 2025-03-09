<template>
  <form @submit.prevent="submitForm">
    <fieldset>
      <div class="mb-3">
        <label for="title" class="form-label">Category</label>
        <select
          class="form-select"
          aria-label="Type selection"
          v-model="formData.category_id"
          required
        >
          <option value="" disabled>Select a type</option>
          <option v-for="(item, index) in categoryData" :key="index" :value="item.id">
            {{ item.name }}
          </option>
        </select>
        <div v-if="formErrors.category_id" class="text-danger text-sm">
          {{ formErrors.category_id.join(', ') }}
        </div>
      </div>

      <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input
          v-model="formData.name"
          type="text"
          id="name"
          class="form-control"
          placeholder="Enter Sub Category Name"
        />
        <div v-if="formErrors.name" class="text-danger text-sm">
          {{ formErrors.name.join(', ') }}
        </div>
      </div>
      <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea
          v-model="formData.description"
          type="text"
          id="description"
          class="form-control"
          placeholder="Enter description"
        />
        <div v-if="formErrors.description" class="text-danger text-sm">
          {{ formErrors.description.join(', ') }}
        </div>
      </div>
      <div class="mb-3">
        <label for="status" class="form-label">Status</label>
        <div class="form-check form-switch">
          <input
            v-model="formData.status"
            class="form-check-input"
            type="checkbox"
            id="rememberMe"
            checked
            required
          />
        </div>
        <div v-if="formErrors.status" class="text-danger text-sm">
          {{ formErrors.status.join(', ') }}
        </div>
      </div>
      <div class="text-right">
        <SubmitButton />
      </div>
    </fieldset>
  </form>
  <Loader :isLoading="isLoading" />
</template>

<script setup>
import { ref, defineEmits, onMounted } from 'vue'
import SubmitButton from '@/components/common/buttons/SubmitButton.vue'
import axios from 'axios'
import Loader from '@/components/main/Loader.vue'
const VITE_BASE_URL = import.meta.env.VITE_BASE_URL
import { emitter, CLEAR_CREATE_SUB_CATEGORY_VALIDATION } from '@/event-bus.js'

const formData = ref({
  category_id: '',
  name: '',
  description: '',
  status: true,
})

const emit = defineEmits(['create-category'])
const categoryData = ref([])
const formErrors = ref({})
const isLoading = ref(false)

const clearFormData = () => {
  formErrors.value = {}
  formData.value = { status: true }
}

onMounted(() => {
  clearFormData()
  emitter.on(CLEAR_CREATE_SUB_CATEGORY_VALIDATION, clearFormData)
})

const submitForm = async () => {
  isLoading.value = true
  try {
    await axios.post(`${VITE_BASE_URL}api/v1/sub-categories`, formData.value)
    $('#createModal').modal('hide')
    clearFormData()
    isLoading.value = false
  } catch (error) {
    if (error.response && error.response.data) {
      console.error('Validation Error:', error.response.data)
      const validationErrors = error.response.data.errors

      Object.entries(validationErrors).forEach(([field, messages]) => {
        console.error(`${field}: ${messages.join(', ')}`)
      })

      formErrors.value = validationErrors
      isLoading.value = false
    } else {
      // reminder to add sweet alert
      console.error('Error creating sub category:', error)
      isLoading.value = false
    }
  }
}

const getCategoryData = async () => {
  try {
    const response = await axios.get(`${VITE_BASE_URL}api/v1/categories`)
    categoryData.value = response.data.data
  } catch (error) {
    console.error('Error fetching task  data:', error)
  }
}

onMounted(() => {
  getCategoryData()
})
</script>
