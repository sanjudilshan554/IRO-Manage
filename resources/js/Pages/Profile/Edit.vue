<template>
    <AppLayout>
        <template #content>
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <!-- Top Cards Section -->
                        <div class="d-flex flex-wrap justify-content-between p-3">
                            <div class="card m-2 flex-grow-1" v-for="card in cards" :key="card.title">
                                <ProfileCard :title="card.title" :value="card.value" :percentage="card.percentage"
                                    :subtitle="card.subtitle" :icon-class="card.iconClass"
                                    :percentage-class="card.percentageClass" />
                            </div>
                        </div>

                        <!-- End of Top Cards Section -->
                        <div class="card-header pb-0">
                            <div class="d-flex align-items-center">
                                <p class="mb-0">Host's Profile</p>
                            </div>
                        </div>

                        <div class="card-body">
                            <p class="text-uppercase text-sm">
                                Primary Information
                            </p>

                            <form @submit.prevent="updateProfile" class="mt-4 space-y-4">
                                <div>
                                    <label class="block text-sm font-medium">First Name</label>
                                    <input v-model="form.name" type="text" class="input-field" />
                                </div>


                                <div>
                                    <label class="block text-sm font-medium">Email</label>
                                    <input v-model="form.email" type="email" class="input-field" />
                                </div>

                                <div v-if="hostData.verification_details">
                                    <h3 class="text-md font-semibold">
                                        Verification Details
                                    </h3>

                                    <div>
                                        <label class="block text-sm font-medium">National ID</label>
                                        <p class="text-gray-700">
                                            {{
                                                hostData.verification_details
                                                    .national_id
                                            }}
                                        </p>
                                    </div>

                                    <div class="flex space-x-4 mt-2">
                                        <div>
                                            <label class="block text-sm font-medium">Front Image</label>
                                            <img v-if="
                                                hostData
                                                    .verification_details
                                                    .front_image_url
                                            " :src="BASE_IMAGE_URL +
                                                    hostData
                                                        .verification_details
                                                        .front_image_url
                                                    " class="w-32 h-20 object-cover cursor-pointer border border-gray-300"
                                                @click="
                                                    showImageModal(
                                                        BASE_IMAGE_URL +
                                                        hostData
                                                            .verification_details
                                                            .front_image_url,
                                                        'Front'
                                                    )
                                                    " />
                                            <p v-else class="text-gray-500">
                                                No image available
                                            </p>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium">Back Image</label>
                                            <img v-if="
                                                hostData
                                                    .verification_details
                                                    .back_image_url
                                            " :src="BASE_IMAGE_URL +
                                                    hostData
                                                        .verification_details
                                                        .back_image_url
                                                    " class="w-32 h-20 object-cover cursor-pointer border border-gray-300"
                                                @click="
                                                    showImageModal(
                                                        BASE_IMAGE_URL +
                                                        hostData
                                                            .verification_details
                                                            .back_image_url,
                                                        'Back'
                                                    )
                                                    " />
                                            <p v-else class="text-gray-500">
                                                No image available
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn-primary">
                                    Update Profile
                                </button>
                            </form>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group d-flex align-items-center">
                                        <i class="bi bi-person me-2 text-primary"></i>
                                        <span class="fw-bold">First name:</span>
                                        <span class="ps-3">{{
                                            hostData?.first_name || "N/A"
                                            }}</span>
                                    </div>
                                </div>

                                <!-- Name -->
                                <div class="col">
                                    <div class="form-group d-flex align-items-center gap-2">
                                        <i class="bi bi-person-badge text-warning"></i>
                                        <span class="fw-bold">Name:</span>
                                        <span class="ps-2">{{
                                            hostData.emergency_contact?.name ||
                                            "N/A"
                                            }}</span>
                                    </div>
                                </div>
                            </div>

                            <hr class="horizontal dark" />

                            <div class="row align-items-center g-3">
                                <!-- Label -->
                                <div class="col-md-3 col-12">
                                    <p class="text-uppercase text-sm">
                                        Host Identity Card
                                    </p>
                                </div>

                                <!-- Buttons -->
                                <div class="col-md-6 col-12 ms-auto" v-if="
                                    hostData.verification_details
                                        ?.front_image_url &&
                                    hostData.verification_details
                                        ?.back_image_url
                                ">
                                    <div class="d-flex justify-content-end gap-2">
                                        <button class="btn btn-success" @click.prevent="verifyHostIDCard()" :disabled="hostData.email_verified == 0 ||
                                            hostData.mobile_number_verfied ==
                                            0 ||
                                            hostData.id_verification_verfied ==
                                            1 ||
                                            hostData.is_verfied == 1
                                            ">
                                            Verify
                                        </button>
                                        <button class="btn btn-danger" @click.prevent="rejectHostIDCard()" :disabled="hostData.email_verified == 0 ||
                                            hostData.mobile_number_verfied ==
                                            0 ||
                                            hostData.id_verification_verfied ==
                                            1 ||
                                            hostData.is_verfied == 1
                                            ">
                                            Reject
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="id-input-container">
                                        <div class="row">
                                            <!-- Front ID Input -->
                                            <div v-if="
                                                hostData
                                                    .verification_details
                                                    ?.front_image_url
                                            "
                                                class="col-12 col-md-6 d-flex align-items-center justify-content-center identity-card"
                                                @click="
                                                    showImageModal(
                                                        `${BASE_IMAGE_URL}${hostData.verification_details?.front_image_url}`,
                                                        'Front'
                                                    )
                                                    ">
                                                <div class="id-input" data-toggle="tooltip" data-placement="bottom"
                                                    title="View Host ID Front Image">
                                                    <label for="example-text-input"
                                                        class="form-control-label">Front</label>
                                                    <img :src="`${BASE_IMAGE_URL}${hostData.verification_details?.front_image_url}`"
                                                        class="img-fluid border border-4 border-white" />
                                                </div>
                                            </div>

                                            <div v-else
                                                class="col-12 col-md-6 d-flex align-items-center justify-content-center identity-card">
                                                <div class="id-input bg-white" data-toggle="tooltip"
                                                    data-placement="bottom" title="Not Found">
                                                    <label for="example-text-input"
                                                        class="form-control-label">Front</label>
                                                    <div class="" style="
                                                            background-color: white;
                                                        "></div>
                                                    <img :src="ImageNotFound"
                                                        class="img-fluid border border-4 border-white" width="50%" />
                                                </div>
                                            </div>

                                            <!-- Back ID Input -->
                                            <div v-if="
                                                hostData
                                                    .verification_details
                                                    ?.back_image_url
                                            "
                                                class="col-12 col-md-6 mt-4 mt-md-0 d-flex align-items-center justify-content-center identity-card"
                                                @click="
                                                    showImageModal(
                                                        `${BASE_IMAGE_URL}${hostData.verification_details?.back_image_url}`,
                                                        'Back'
                                                    )
                                                    ">
                                                <div class="id-input" data-toggle="tooltip" data-placement="bottom"
                                                    title="View Host ID Back Image">
                                                    <label for="example-text-input"
                                                        class="form-control-label">Back</label>
                                                    <img :src="`${BASE_IMAGE_URL}${hostData.verification_details?.back_image_url}`"
                                                        class="img-fluid border border-4 border-white image-border-radius" />
                                                </div>
                                            </div>

                                            <div v-else
                                                class="col-12 col-md-6 mt-4 mt-md-0 d-flex align-items-center justify-content-center identity-card">
                                                <div class="id-input bg-white" data-toggle="tooltip"
                                                    data-placement="bottom" title="Not Found">
                                                    <label for="example-text-input"
                                                        class="form-control-label">Back</label>
                                                    <div class="" style="
                                                            background-color: white;
                                                        "></div>
                                                    <img :src="ImageNotFound"
                                                        class="img-fluid border border-4 border-white" width="50%" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <ProfileDetailCard :user_name="hostData.user_name" :last_name="hostData.last_name"
                    :first_name="hostData.first_name" :image="hostData.profile_logo_url" :language="hostData.language"
                    :about_you="hostData.about_you" :joined_date="hostData.joined_date"
                    :mobile_number="hostData.mobile_number" :address="hostData.address" :unique_id="hostData.unique_id"
                    :status="hostData.status" :email="hostData.email" :email_verified="hostData.email_verified"
                    :id_verification_verfied="hostData.id_verification_verfied"
                    :mobile_number_verfied="hostData.mobile_number_verfied" class="mt-4 mt-md-0" />
            </div>
        </template>

        <template #modals>
            <HostIDModal :selectedIdSide="selectedIdSide" :modalImageSrc="modalImageSrc" />

            <VerifyHostID :title="verifyModal.title" :hostId="host_id" :content="verifyModal.content" :formType="'host'"
                :hostVerificationDetailsId="hostVerificationDetailsId" />

            <RejectHostIDCardModal :title="rejectModal.title" :hostId="host_id" :content="rejectModal.content"
                :formType="'host'" :hostVerificationDetailsId="hostVerificationDetailsId" />
        </template>

        <template #loader>
            <Loader :isLoading="isLoading" />
        </template>
    </AppLayout>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import axios from "axios";
import { ref, onMounted, defineEmits } from "vue";
import Loader from "@/components/main/Loader.vue";
import ProfileCard from "@/Components/cards/profile/ProfileTopCard.vue";
import ProfileDetailCard from "@/Components/cards/profile/ProfileDetailCard.vue";
import { useRoute } from "vue-router";
import ImageNotFound from "@/src/assets/img/empty-state-images/image-not-found.png";
import HostIDModal from "@/Components/common/modals/host-profile/HostIDModal.vue";
import VerifyHostID from "@/Components/common/modals/host-profile/HostIDVerifiedModal.vue";
import RejectHostIDCardModal from "@/Components/common/modals/host-profile/HostIDRejectModal.vue";

import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
// import input from '@/Components/input.vue';
import { Link, useForm, usePage } from "@inertiajs/vue3";

import {
    emitter,
    UPDATE_AFTER_REJECT_HOST_ID,
    UPDATE_AFTER_VERIFY_HOST_ID,
    CLEAR_HOST_REJECT_FIELDS,
} from "@/event-bus.js";

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const user = usePage().props.auth.user;

const form = useForm({
    name: user.name,
    email: user.email,
});

const VITE_BASE_URL = import.meta.env.VITE_BASE_URL;
const BASE_IMAGE_URL = import.meta.env.VITE_BASE_IMAGE_URL;

const hostData = ref([]);
const isLoading = ref(false);
const emit = defineEmits(["clear-validation"]);
const route = useRoute();
const totalRows = ref(0);
//   const host_id = route.params.host_id
const modalImageSrc = ref("");
const selectedIdSide = ref("");
const hostVerificationDetailsId = ref(0);

const showImageModal = (imageSrc, side) => {
    isLoading.value = true;
    try {
        selectedIdSide.value = side;
        modalImageSrc.value = imageSrc;
        $("#image-modal").modal("show");
        isLoading.value = false;
    } catch {
        isLoading.value = false;
    }
};

const getHostData = async () => {
    isLoading.value = true;
    try {
        const response = await axios.get(
            `${VITE_BASE_URL}api/v1/host/admin/details`,
            {
                params: {
                    host_id: host_id,
                },
            }
        );
        // console.log('response', response)
        hostData.value = response.data.data;
        totalRows.value = response.data.data.total;
        hostVerificationDetailsId.value =
            response.data.data?.verification_details?.id;
    } catch (error) {
        console.error("Error fetching host data:", error);
    } finally {
        isLoading.value = false;
    }
};

onMounted(() => {
    //   getHostData()
    //   emitter.on(UPDATE_AFTER_REJECT_HOST_ID, getHostData)
    //   emitter.on(UPDATE_AFTER_VERIFY_HOST_ID, getHostData)
});

const cards = [
    {
        title: "Today's Money",
        value: "$53,000",
        percentage: "+55%",
        subtitle: "since yesterday",
        iconClass: "ni ni-money-coins text-lg opacity-10",
    },
    {
        title: "New Users",
        value: "2,300",
        percentage: "+5%",
        subtitle: "since last week",
        iconClass: "ni ni-money-coins text-lg opacity-10",
    },
    {
        title: "Sales",
        value: "$103,000",
        percentage: "+10%",
        subtitle: "since last month",
        iconClass: "ni ni-cart text-lg opacity-10",
    },
];

const verifyModal = {
    title: "Verify Host Identity Card",
    content: "Are you sure you want to verify this host identity card?",
};

const rejectModal = {
    title: "Reject Host Identity Card",
    content: "Are you sure you want to reject this host identity card?",
};

const verifyHostIDCard = () => {
    try {
        $("#verify-host-id-modal").modal("show");
    } catch (error) {
        console.log("error", error);
    }
};

const rejectHostIDCard = () => {
    try {
        emitter.emit(CLEAR_HOST_REJECT_FIELDS);
        $("#reject-host-id-card-modal").modal("show");
    } catch (error) {
        console.log("error", error);
    }
};
</script>

<style scoped>
.identity-card img {
    width: 500px;
    height: 250px;
    object-fit: contain;
    border-radius: 8px;
}
</style>
