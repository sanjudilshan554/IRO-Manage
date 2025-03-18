<template>
    <div class="col-md-4">
        <div class="card card-profile">
            <div class="row justify-content-center mt-4">
                <div class="text-center col-4 col-lg-4 order-lg-2">
                    <div class="text-center  order-lg-2 position-relative">
                        <div class="image-container position-relative"
                            v-if="image?.path && image?.path !== 'storage/default/invalid.jpg'"
                            @click="triggerFileUpload">
                            <img :src="image?.path" class="rounded-circle img-fluid border border-2 border-white" />
                            <div class="pencil-overlay d-flex align-items-center justify-content-center">
                                <i class="bi bi-pencil-fill"></i>
                            </div>
                            <input type="file" ref="fileInput" class="d-none" @change="handleFileUpload" />
                        </div>

                        <div class="image-container position-relative" v-else @click="triggerFileUpload">
                            <img :src="default_user" class="rounded-circle img-fluid border border-2 border-white" />
                            <div class="pencil-overlay d-flex align-items-center justify-content-center">
                                <i class="bi bi-pencil-fill"></i>
                            </div>
                            <input type="file" ref="fileInput" class="d-none" @change="handleFileUpload" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body pt-0">
                <!-- Header Section -->
                <div class="text-center mt-4">
                    <h5>{{ name }}</h5>
                </div>

                <!-- Details Section -->
                <div class="details mt-3">
                    <div class="row mb-2">
                        <div class="col-6 text-left"><i class="bi bi-circle pe-2"></i>SLBFE Reg No</div>
                        <div class="col-6 text-right" v-if="email">{{ slbfe_reg_code }}</div>
                        <div class="col-6 text-right" v-else> not configured </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6 text-left"><i class="bi bi-envelope pe-2"></i>Email</div>
                        <div class="col-6 text-right" v-if="email">{{ email }}</div>
                        <div class="col-6 text-right" v-else> not configured </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6 text-left"><i class="bi bi-telephone pe-2"></i>Phone</div>
                        <div class="col-6 text-right" v-if="phone">
                            {{ phone }}
                            <span v-if="phone_2">/ {{ phone_2 }}</span>
                        </div>
                        <div class="col-6 text-right" v-else> not configured </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6 text-left"><i class="bi bi-calendar pe-2"></i>Joined</div>
                        <div class="col-6 text-right" v-if="created_at">{{ formatDate(created_at) }}</div>
                        <div class="col-6 text-right" v-else> not assigned </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6 text-left"><i class="bi bi-geo-alt-fill pe-2"></i>City</div>
                        <div class="col-6 text-right" v-if="city">{{ city }}</div>
                        <div class="col-6 text-right" v-else> not configured </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6 text-left"><i class="bi bi-cash pe-2"></i>Base Currency</div>
                        <div class="col-6 text-right" v-if="currency">{{ currency }}</div>
                        <div class="col-6 text-right" v-else> not configured </div>
                    </div>
                    <h6 class="text-center">{{ about_you }}</h6>
                </div>

                <hr class="horizontal dark" />

                <h6 class="text-left gray-6">Business Profile Status</h6>

                <!-- Verification Section -->
                <div class="details mt-3 text-left">
                    <div class="row mb-2">
                        <div class="col-1 text-left">
                            <i class="bi bi-check-circle-fill text-success" v-if="id_verification_verfied"></i>
                            <i class="bi bi-check-circle-fill" v-else></i>
                        </div>
                        <div class="col-6 text-left">identity</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-1 text-left">
                            <i class="bi bi-check-circle-fill text-success" v-if="email_verified"></i>
                            <i class="bi bi-check-circle-fill" v-else></i>
                        </div>
                        <div class="col-6 text-left">Email Address</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-1 text-left">
                            <i class="bi bi-check-circle-fill text-success" v-if="mobile_number_verfied"></i>
                            <i class="bi bi-check-circle-fill" v-else></i>
                        </div>
                        <div class="col-6 text-left">Phone Number</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <Loader :isLoading="isLoading" />

    <dataSavedAlert v-if="alertMessage" :alertTitle="alertMessage" />

</template>

<script setup>
import default_user from '@/src/assets/img/user-image/default_business2.png'
import axios from "axios"
import { defineProps, ref } from "vue";
import Loader from '@/Components/main/Loader.vue';
import dataSavedAlert from '@/Components/alerts/dataSaveAlert.vue'

defineProps(['name', 'email', 'phone', 'phone_2', 'created_at', 'city', 'industry', 'slbfe_reg_code', 'currency', 'image'])

const fileInput = ref(null)
const isLoading = ref(false)
const alertMessage = ref(null);


const triggerFileUpload = () => {
    fileInput.value.click()
}

const handleFileUpload = async (event) => {
    isLoading.value = true;
    const file = event.target.files[0];
    if (!file) {
        isLoading.value = false;
        return;
    }

    const formData = new FormData();
    formData.append("logo", file);

    try {
        await axios.post(route('business.logo.store'), formData, {
            headers: { "Content-Type": "multipart/form-data" }
        });
        alertMessage.value = "Business Logo updated successfully";
        isLoading.value = false;
        window.location.reload();
    } catch (error) {
        console.error("Error uploading logo:", error);
        isLoading.value = false;
    }
};

const formatDate = (date) => {
    const options = {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
    };
    return new Date(date).toLocaleString('en-US', options);
};

</script>

<style scoped>
.rounded-circle {
    box-shadow: 1px 5px 5px rgb(201, 198, 198);
}

.image-container {
    cursor: pointer;
    position: relative;
}

.pencil-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.4);
    border-radius: 50%;
    opacity: 0;
    transition: opacity 0.3s;
    color: #fff;
    font-size: 24px;
}

.image-container:hover .pencil-overlay {
    opacity: 1;
}

.card-profile {
    padding: 20px;
    border-radius: 15px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    background-color: #fff;
}

.image-container {
    position: relative;
    aspect-ratio: 1 / 1;
    overflow: hidden;
    border-radius: 50%;
    border: 3px solid #fff;
    box-shadow: 1px 5px 5px rgb(201, 198, 198);
    background-color: #f0f0f0;
}

.image-container img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
}

.pencil-overlay i {
    color: #fff;
}
</style>