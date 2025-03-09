<template>
  <form @submit.prevent="submitForm">
    <fieldset>
      <!-- <div class="mb-3">
        <label for="title" class="form-label">Type</label>
        <select class="form-select" aria-label="Type selection" v-model="formData.type_id" required>
          <option value="" disabled>Select a type</option>
          <option v-for="(item, index) in typeData" :key="index" :value="item.id">
            {{ item.name }}
          </option>
        </select>
        <div v-if="formErrors.type_id" class="text-danger text-sm">
          {{ formErrors.type_id.join(', ') }}
        </div>
      </div> -->
      <div class="mb-3">
        <label for="title" class="form-label">Name</label>
        <input
          v-model="formData.name"
          type="text"
          id="name"
          class="form-control"
          placeholder="Enter Category Name"
        />
        <div v-if="formErrors.name" class="text-danger text-sm">
          {{ formErrors.name.join(', ') }}
        </div>
      </div>
      <div class="mb-3">
        <label for="image" class="form-label">Image</label>
        <input
          type="file"
          id="description"
          class="form-control"
          placeholder="Enter description"
          @change="handleFileUpload"
        />
        <div v-if="formErrors.image" class="text-danger text-sm">
          {{ formErrors.image.join(', ') }}
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
        <label for="description" class="form-label">Status</label>
        <div class="form-check form-switch">
          <input
            class="form-check-input"
            type="checkbox"
            id="rememberMe"
            v-model="formData.status"
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
    <Loader :isLoading="isLoading" />
  </form>

  <successMessage v-if="showSuccess" :alertTitle="successAlert.title" />
</template>

<script setup>
import { ref, defineEmits, onMounted } from 'vue'
import SubmitButton from '@/components/common/buttons/SubmitButton.vue'
import successMessage from '@/components/alerts/dataSaveAlert.vue'
import { emitter, CLEAR_CREATE_CATEGORY_VALIDATION } from '@/event-bus.js'
import Loader from '@/components/main/Loader.vue'
import axios from 'axios'

const VITE_BASE_URL = import.meta.env.VITE_BASE_URL
const isLoading = ref(false)
const formData = ref({
  type_id: '',
  name: '',
  description: '',
  status: true,
  image_url: null,
})
const showSuccess = ref(false)
const typeData = ref([])
const emit = defineEmits(['create-category'])
const formErrors = ref({})

const clearFormData = () => {
  formErrors.value = {}
  formData.value = { status: true }
}

const handleFileUpload = (event) => {
  formData.value.image_url = event.target.files[0]
}

onMounted(() => {
  clearFormData()
  emitter.on(CLEAR_CREATE_CATEGORY_VALIDATION, clearFormData)
})

const getTypeData = async () => {
  try {
    const response = await axios.get(`${VITE_BASE_URL}api/v1/entity-types`)
    typeData.value = response.data.data
  } catch (error) {
    console.error('Error fetching task  data:', error)
  }
}

onMounted(() => {
  getTypeData()
})

const submitForm = async () => {
  isLoading.value = true
  try {
    await axios.post(`${VITE_BASE_URL}api/v1/categories`, formData.value, {
      headers: {
        'Content-Type': 'multipart/form-data',
      },
    })
    emit('create-category')
    $('#createModal').modal('hide')
    clearFormData()
    showSuccess.value = true
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
      console.error('Error creating category:', error)
      isLoading.value = false
    }
  }
}

const successAlert = { title: 'New category created successfully' }
</script>
