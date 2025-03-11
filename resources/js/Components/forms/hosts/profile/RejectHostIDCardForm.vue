<template>
  <div class="form">
    <form>
      <label>Comment</label>
      <textarea
        type="text"
        class="form-control mb-3"
        v-model="formData.comment"
        placeholder="Enter reject reason"
      />
      <div v-if="formErrors.status" class="text-danger text-sm">
        {{ formErrors.status.join(', ') }}
      </div>

      <div class="d-flex justify-content-end gap-2">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <RejectButton @click.prevent="rejectHostIDCard" />
      </div>
    </form>
  </div>
  <Loader :isLoading="isLoading" />
  <successMessage v-if="showSuccess" :alertTitle="successAlert.title" />
</template>

<script setup>
import { ref, defineProps, defineEmits, onMounted } from 'vue'
import RejectButton from '@/components/common/buttons/RejectButton.vue'
import axios from 'axios'
import Loader from '@/components/main/Loader.vue'
import successMessage from '@/components/alerts/dataSaveAlert.vue'
const VITE_BASE_URL = import.meta.env.VITE_BASE_URL
import { emitter, UPDATE_AFTER_REJECT_HOST_ID, CLEAR_HOST_REJECT_FIELDS } from '@/event-bus.js'
const formData = ref({ status: 'rejected', comment: '' })
const showSuccess = ref(false)
const formErrors = ref({})
const isLoading = ref(false)
const clearFormData = () => {
  formErrors.value = {}
  formData.value = { status: 'rejected', comment: '' }
}
const props = defineProps({
  hostId: {
    type: Number,
    required: true,
  },
  hostVerificationDetailsId: {
    type: Number,
    required: true,
  },
})

const rejectHostIDCard = async () => {
  isLoading.value = true
  showSuccess.value = false
  try {
    await axios.post(`${VITE_BASE_URL}api/v1/host/admin/change/verification/status`, {
      host_id: props.hostId,
      host_verification_details_id: props.hostVerificationDetailsId,
      status: formData.value.status,
      comment: formData.value.comment,
    })
    $('#reject-host-id-card-modal').modal('hide')
    emitter.emit(UPDATE_AFTER_REJECT_HOST_ID)
    clearFormData()
    isLoading.value = false
    showSuccess.value = true
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
      console.error('Error creating types:', error)
      isLoading.value = false
    }
  }
}

onMounted(() => {
  clearFormData()
  emitter.on(CLEAR_HOST_REJECT_FIELDS, clearFormData)
})

const successAlert = { title: 'Host ID card rejected successfully' }
</script>
