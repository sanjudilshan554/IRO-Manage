<template>
  <form @submit.prevent="submitForm">
    <fieldset>
      <div class="row">
        <div class="col-6">
          <div class="mb-3">
            <label for="first_name" class="form-label">First Name</label>
            <input
              v-model="formData.first_name"
              type="text"
              id="first_name"
              class="form-control"
              placeholder="Enter first_name"
            />
            <div v-if="formErrors.first_name" class="text-danger text-sm mt-1">
              {{ formErrors.first_name.join(', ') }}
            </div>
          </div>
        </div>

        <div class="col-6">
          <div class="mb-3">
            <label for="last_name" class="form-label">Last Name</label>
            <input
              v-model="formData.last_name"
              type="text"
              id="last_name"
              class="form-control"
              placeholder="Enter last_name"
            />
            <div v-if="formErrors.last_name" class="text-danger text-sm mt-1">
              {{ formErrors.last_name.join(', ') }}
            </div>
          </div>
        </div>

        <div class="col-12">
          <div class="mb-3">
            <label for="mobile_number" class="form-label">Mobile Number</label>
            <input
              v-model="formData.mobile_number"
              type="text"
              id="mobile_number"
              class="form-control"
              placeholder="Enter Mobile Number"
            />
            <div v-if="formErrors.mobile_number" class="text-danger text-sm mt-1">
              {{ formErrors.mobile_number.join('and ') }}
            </div>
          </div>
        </div>

        <div class="col-12">
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input
              v-model="formData.email"
              type="email"
              id="email"
              class="form-control"
              placeholder="Enter Email Address"
            />
            <div v-if="formErrors.email" class="text-danger text-sm mt-1">
              {{ formErrors.email.join(', ') }}
            </div>
          </div>
        </div>
      </div>

      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input
          v-model="formData.password"
          type="password"
          id="password"
          class="form-control"
          placeholder="Enter Password"
        />
        <div v-if="formErrors.password" class="text-danger text-sm mt-1">
          {{ formErrors.password }}
        </div>
      </div>

      <div class="mb-3">
        <label for="confirm_password" class="form-label">Confirm Password</label>
        <input
          v-model="confirm_password"
          type="password"
          id="confirm_password"
          class="form-control"
          placeholder="Confirm Password"
        />
        <div v-if="formErrors.confirm_password" class="text-danger text-sm mt-1">
          {{ formErrors.confirm_password }}
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
import { emitter, CLEAR_CREATE_HOST_VALIDATION, UPDATE_HOST_TABLE } from '@/event-bus.js'
import Loader from '@/components/main/Loader.vue'
const VITE_BASE_URL = import.meta.env.VITE_BASE_URL

const confirm_password = ref('')
const route = useRouter()
const showSuccess = ref(false)
const formData = ref({})
const emit = defineEmits(['create-category'])
const formErrors = ref({})

const clearFormData = () => {
  formErrors.value = {}
  formData.value = { register_type: 'manual' }
  confirm_password.value = ''
}

onMounted(() => {
  clearFormData()
  emitter.on(CLEAR_CREATE_HOST_VALIDATION, clearFormData)
})

const isLoading = ref(false)

const submitForm = async () => {
  isLoading.value = true

  formErrors.value = {}

  if (!formData.value.password) {
    formErrors.value.password = 'The Password field is required.'
  } else if (formData.value.password.length < 8) {
    formErrors.value.password = 'Password must be at least 8 characters long.'
  }

  if (!confirm_password.value) {
    formErrors.value.confirm_password = 'The Confirm Password field is required.'
  } else if (formData.value.password !== confirm_password.value) {
    formErrors.value.confirm_password = 'Passwords do not match.'
  }

  if (Object.keys(formErrors.value).length > 0) {
    isLoading.value = false
    return
  }

  try {
    await axios.post(`${VITE_BASE_URL}api/v1/host/admin/register`, formData.value)
    emit('create-category')
    $('#createModal').modal('hide')
    clearFormData()
    showSuccess.value = true
    emitter.emit(UPDATE_HOST_TABLE)
    console.log('update stage 1')
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

const successAlert = { title: 'New host created successfully' }
</script>
