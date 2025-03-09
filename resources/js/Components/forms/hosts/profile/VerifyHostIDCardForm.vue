<template>
  <VerifyButton @click.prevent="verifyHostID" />
  <Loader :isLoading="isLoading" />
  <successMessage v-if="showSuccess" :alertTitle="successAlert.title" />
</template>

<script setup>
import { ref, defineProps, watchEffect, defineEmits } from 'vue'
import VerifyButton from '@/components/common/buttons/VerifyButton.vue'
import axios from 'axios'
import Loader from '@/components/main/Loader.vue'
import successMessage from '@/components/alerts/dataSaveAlert.vue'
import { emitter, UPDATE_AFTER_VERIFY_HOST_ID } from '@/event-bus.js'

const VITE_BASE_URL = import.meta.env.VITE_BASE_URL
const showSuccess = ref(false)
const isLoading = ref(false)
const formData = ref({
  status: 'verified',
  comment: '',
})

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

const clearFormData = () => {
  formData.value = { status: 'verified', comment: '' }
}

const verifyHostID = async () => {
  isLoading.value = true
  showSuccess.value = false
  try {
    console.log('verifying is ongoing', props.hostId)
    await axios.post(`${VITE_BASE_URL}api/v1/host/admin/change/verification/status`, {
      host_id: props.hostId,
      host_verification_details_id: props.hostVerificationDetailsId,
      status: formData.value.status,
      comment: formData.value.comment,
    })

    $('#verify-host-id-modal').modal('hide')
    clearFormData()
    isLoading.value = false
    showSuccess.value = true
    emitter.emit(UPDATE_AFTER_VERIFY_HOST_ID)
  } catch (error) {
    console.error('Error verified host id', error)
    isLoading.value = false
  }
}

const successAlert = { title: 'Host ID card verified successfully' }
</script>
