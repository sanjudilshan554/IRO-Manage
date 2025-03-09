<template>
  <form @submit.prevent="submitForm">
    <fieldset>
      <div class="row">
        <div class="col-6">
          <div class="mb-3">
            <label for="title" class="form-label">Host</label>
            <select
              class="form-select"
              aria-label="Type selection"
              v-model="formData.host_id"
              required
            >
              <option value="" disabled>Select a host</option>
              <option v-for="(item, index) in hostData" :key="index" :value="item.id">
                {{ item.first_name }}
              </option>
            </select>
            <div v-if="formErrors.host_id" class="text-danger text-sm">
              {{ formErrors.host_id.join(', ') }}
            </div>
          </div>
        </div>

        <div class="col-6">
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
        </div>

        <div class="col-12">
          <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input
              v-model="formData.title"
              type="text"
              id="title"
              class="form-control"
              placeholder="Enter Title"
            />
            <div v-if="formErrors.title" class="text-danger text-sm mt-1">
              {{ formErrors.title.join('and') }}
            </div>
          </div>
        </div>

        <div class="col-12">
          <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input
              v-model="formData.price"
              type="number"
              id="price"
              class="form-control"
              placeholder="Enter Price"
            />
            <div v-if="formErrors.price" class="text-danger text-sm mt-1">
              {{ formErrors.price.join('and') }}
            </div>
          </div>
        </div>

        <div class="col-12">
          <div class="mb-3">
            <label for="location" class="form-label">Location</label>
            <input
              v-model="formData.location"
              type="number"
              id="location"
              class="form-control"
              placeholder="Enter Location"
            />
            <div v-if="formErrors.location" class="text-danger text-sm mt-1">
              {{ formErrors.location.join('and') }}
            </div>
          </div>
        </div>

        <div class="col-12">
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
        </div>

        <div class="col-12">
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
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import SubmitButton from '@/components/common/buttons/SubmitButton.vue'
import axios from 'axios'
import successMessage from '@/components/alerts/dataSaveAlert.vue'
import { emitter, UPDATE_LISTING_TABLE, CLEAR_CREATE_LISTING_VALIDATION } from '@/event-bus.js'
import Loader from '@/components/main/Loader.vue'
const VITE_BASE_URL = import.meta.env.VITE_BASE_URL

const confirm_password = ref('')
const route = useRouter()
const showSuccess = ref(false)
const formData = ref({})
const emit = defineEmits(['create-category'])
const formErrors = ref({})
const hostData = ref([])
const categoryData = ref([])

const clearFormData = () => {
  formErrors.value = {}
  formData.value = { register_type: 'manual' }
  confirm_password.value = ''
  formData.value = { status: true }
}

onMounted(() => {
  clearFormData()
  emitter.on(CLEAR_CREATE_LISTING_VALIDATION, clearFormData)
})

const isLoading = ref(false)

const submitForm = async () => {
  isLoading.value = true

  formErrors.value = {}

  try {
    await axios.post(`${VITE_BASE_URL}api/v1/host/admin/register`, formData.value)
    $('#createModal').modal('hide')
    clearFormData()
    showSuccess.value = true
    emitter.emit(UPDATE_LISTING_TABLE)
  } catch (error) {
    if (error.response && error.response.data) {
      const validationErrors = error.response.data.errors
      formErrors.value = validationErrors
    } else {
      console.error('Error creating category:', error)
    }
  } finally {
    isLoading.value = false
  }
}

const getHostData = async () => {
  try {
    const response = await axios.get(`${VITE_BASE_URL}api/v1/host/admin/details/all`)
    hostData.value = response.data.data.data
  } catch (error) {
    console.error('Error fetching task  data:', error)
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
  getHostData()
  getCategoryData()
})

const successAlert = { title: 'New Listing created successfully' }
</script>
