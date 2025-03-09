<template>
  <LogoutButton @click.prevent="logoutUser" />
  <Loader :isLoading="isLoading" />
  <successMessage v-if="showSuccess" :alertTitle="successAlert.title" :formType="formType" />
</template>

<script setup>
import { ref, defineProps } from 'vue'
import LogoutButton from '@/components/common/buttons/LogoutButton.vue'
import Loader from '@/components/main/Loader.vue'
import successMessage from '@/components/alerts/dataSaveAlert.vue'
import { useRouter } from 'vue-router'
const showSuccess = ref(false)
const isLoading = ref(false)

const router = useRouter()
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

const logoutUser = async () => {
  isLoading.value = true
  showSuccess.value = false
  try {
    localStorage.removeItem('user')
    localStorage.removeItem('token')
    $('#confirmModal').modal('hide')
    isLoading.value = false
    showSuccess.value = true
    router.push({ name: 'login' })
  } catch (error) {
    console.error('Error verified host id', error)
    isLoading.value = false
  }
}

const formType = 'logout'
const successAlert = { title: 'Logout successfully' }
</script>
