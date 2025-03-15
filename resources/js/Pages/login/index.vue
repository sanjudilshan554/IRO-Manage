<template>
  <AuthenticatedLayout>
    <template #content>
      <div class="row">
        <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto">
          <div class="card card-plain">
            <div class="card-header pb-0 text-start">
              <h4 class="font-weight-bolder">Sign In</h4>
              <p class="mb-0">Enter your email and password to sign in</p>
            </div>
            <div class="card-body">
              <form @submit.prevent="submitForm" class="form">
                <div class="mb-3">
                  <input
                    v-model="formData.email"
                    type="email"
                    class="form-control form-control-lg"
                    placeholder="Email"
                    aria-label="Email"
                  />
                  <div v-if="formErrors.email" class="text-danger text-sm mt-1">
                    {{ formErrors.email.join(', ') }}
                  </div>
                </div>
                <div class="mb-3">
                  <input
                    v-model="formData.password"
                    type="password"
                    class="form-control form-control-lg"
                    placeholder="Password"
                    aria-label="Password"
                  />
                  <div v-if="formErrors.password" class="text-danger text-sm mt-1">
                    {{ formErrors.password.join(', ') }}
                  </div>
                </div>
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" id="rememberMe" />
                  <label class="form-check-label" for="rememberMe">Remember me</label>
                </div>
                <div class="text-center">
                  <button
                    type="submit"
                    class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0"
                    :disabled="isLoading"
                  >
                    <span
                      v-if="isLoading"
                      class="spinner-border spinner-border-sm me-2"
                      role="status"
                      aria-hidden="true"
                    ></span>
                    <span v-if="!isLoading">Sign in</span>
                    <span v-else>Signing in...</span>
                  </button>
                </div>
              </form>
            </div>
            <!-- <div class="card-footer text-center pt-0 px-lg-2 px-1">
              <p class="mb-4 text-sm mx-auto">
                Don't have an account?
                <a href="javascript:;" class="text-primary text-gradient font-weight-bold"
                  >Sign up</a
                >
              </p>
            </div> -->
          </div>
        </div>

        
        <div
          class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 end-0 text-center justify-content-center flex-column"
        >
          <div
            class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center overflow-hidden"
            style="
              background-image: url('https://raw.githubusercontent.com/creativetimofficial/public-assets/master/argon-dashboard-pro/assets/img/signin-ill.jpg');
              background-size: cover;
            "
          >
            <span class="mask bg-gradient-primary opacity-6"></span>
            <h4 class="mt-5 text-white font-weight-bolder position-relative">
              "Attention is the new currency"
            </h4>
            <p class="text-white position-relative">
              The more effortless the writing looks, the more effort the writer actually put into
              the process.
            </p>
          </div>
        </div>
      </div>
      <successMessage v-if="showSuccess" :alertTitle="successAlert.title" />
    </template>
  </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { useRouter } from 'vue-router'
import { ref, defineEmits, onMounted } from 'vue'
// import successMessage from '@/Component/alerts/dataSaveAlert.vue'
import { emitter, CLEAR_LOGIN_VALIDATION } from '@/event-bus.js'
// import Loader from '@/components/main/Loader.vue'
import axios from 'axios'

const showSuccess = ref(false)

const VITE_BASE_URL = import.meta.env.VITE_BASE_URL
const isLoading = ref(false)
const formData = ref({
  email: '',
  password: '',
})

onMounted(() => {
  clearFormData()
  emitter.on(CLEAR_LOGIN_VALIDATION, clearFormData)
})

const route = useRouter()

const formErrors = ref({})

const clearFormData = () => {
  formErrors.value = {}
  formData.value = {}
}

const submitForm = async () => {
  isLoading.value = true
  formErrors.value = {}

  try {
    console.log('email', formData.value)
    const response = await axios.post(`${VITE_BASE_URL}api/v1/system-user/login`, formData.value)

    const userData = response.data.data
    const token = response.data.token

    localStorage.setItem('user', JSON.stringify(userData))
    localStorage.setItem('token', token)

    $('#createModal').modal('hide')
    clearFormData()
    showSuccess.value = true
    isLoading.value = false
    route.push({ name: 'dashboard' })
  } catch (error) {
    isLoading.value = false

    if (error.response && error.response.data) {
      console.error('Validation Error:', error.response.data)

      const responseData = error.response.data

      if (responseData.errors && responseData.errors.email) {
        formErrors.value.email = responseData.errors.email
      }

      if (responseData.errors && responseData.errors.password) {
        formErrors.value.password = responseData.errors.password
      }

      if (responseData.status_code === 401 && responseData.message) {
        formErrors.value.password = [responseData.message]
      }

      // if (responseData.message && responseData.message.includes('email')) {
      //   formErrors.value.email = [responseData.message]
      // }
    } else {
      console.error('Unexpected Error:', error)
    }
  }
}

const successAlert = { title: 'Login Successfully' }
</script>

<style scoped></style>
