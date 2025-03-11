<template>
    <form @submit.prevent="submitForm">
        <fieldset>
            <div class="row">
                <div class="col-6">
                    <div class="mb-3">
                        <label for="name" class="form-label">Company Name</label>
                        <input v-model="formData.name" type="text" id="name" class="form-control"
                            placeholder="Enter Company Name" />
                        <div v-if="formErrors.name" class="text-danger text-sm mt-1">
                            {{ formErrors.name.join(', ') }}
                        </div>
                    </div>
                </div>

                <div class="col-6">
                    <div class="mb-3">
                        <label for="company_code" class="form-label">Company Code</label>
                        <input v-model="formData.company_code" type="text" id="company_code" class="form-control"
                            placeholder="Enter company_code" />
                        <div v-if="formErrors.company_code" class="text-danger text-sm mt-1">
                            {{ formErrors.company_code.join(', ') }}
                        </div>
                    </div>
                </div>

                <div class="col-6">
                    <div class="mb-3">
                        <label for="slbfe_registration_code" class="form-label">SLBFE Registration Code</label>
                        <input v-model="formData.slbfe_registration_code" type="text" id="slbfe_registration_code"
                            class="form-control" placeholder="Enter Mobile Number" />
                        <div v-if="formErrors.slbfe_registration_code" class="text-danger text-sm mt-1">
                            {{ formErrors.slbfe_registration_code.join('and ') }}
                        </div>
                    </div>
                </div>

                <div class="col-6">
                    <div class="mb-3">
                        <label for="postal_code" class="form-label">Postal Code</label>
                        <input v-model="formData.postal_code" type="text" id="postal_code"
                            class="form-control" placeholder="Enter Mobile Number" />
                        <div v-if="formErrors.postal_code" class="text-danger text-sm mt-1">
                            {{ formErrors.postal_code.join('and ') }}
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input v-model="formData.address" type="text" id="address" class="form-control"
                            placeholder="Enter Company Address" />
                        <div v-if="formErrors.address" class="text-danger text-sm mt-1">
                            {{ formErrors.address.join('and ') }}
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input v-model="formData.email" type="email" id="email" class="form-control"
                            placeholder="Enter Email Address" />
                        <div v-if="formErrors.email" class="text-danger text-sm mt-1">
                            {{ formErrors.email.join(', ') }}
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

    if (Object.keys(formErrors.value).length > 0) {
        isLoading.value = false
        return
    }

    try {
        await axios.post(`http://127.0.0.1:8000/company/store`, formData.value)
        console.log('hello');
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

const successAlert = { title: 'New company created successfully' }
</script>
