<template>
    <AuthenticatedLayout>
        <AppLayout>
            <template #content>

                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header pb-0">
                                <div class="d-flex align-items-center">
                                    <p class="mb-0">Business Profile</p>
                                </div>
                            </div>

                            <div class="card-body mt-4">
                                <ul class="nav nav-tabs" id="profileTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="business-tab" data-bs-toggle="tab"
                                            data-bs-target="#business" type="button" role="tab">Business
                                            Profile</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="basic-tab" data-bs-toggle="tab"
                                            data-bs-target="#basic" type="button" role="tab">Basic
                                            Profile</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="identity-tab" data-bs-toggle="tab"
                                            data-bs-target="#identity" type="button" role="tab">Identity Cards</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="password-tab" data-bs-toggle="tab"
                                            data-bs-target="#password" type="button" role="tab">Password Reset</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link text-danger" id="account-tab" data-bs-toggle="tab"
                                            data-bs-target="#account" type="button" role="tab">Account Deletion</button>
                                    </li>
                                </ul>

                                <div class="tab-content mt-3" id="profileTabContent">

                                    <businessProfile/>

                                    <basicProfile/>

                                    <identityCard/>

                                    <passwordReset/>



                                    <div class="tab-pane fade" id="account" role="tabpanel">
                                        <h4 class="text-danger">Account Deletion</h4>
                                        <p>Warning: Deleting your account is irreversible!</p>

                                        <div class="row">
                                            <section class="space-y-6">
                                                <header>
                                                    <h2 class="text-lg font-medium text-gray-900">
                                                        Delete Account
                                                    </h2>

                                                    <p class="mt-1 text-sm text-gray-600">
                                                        Once your account is deleted, all of its resources and data will
                                                        be permanently deleted. Before deleting your account, please
                                                        download any data or information that you wish to retain.
                                                    </p>
                                                </header>

                                                <DangerButton @click="confirmUserDeletion">Delete Account</DangerButton>

                                                <Modal :show="confirmingUserDeletion" @close="closeModal">
                                                    <div class="p-6">
                                                        <h2 class="text-lg font-medium text-gray-900">
                                                            Are you sure you want to delete your account?
                                                        </h2>

                                                        <p class="mt-1 text-sm text-gray-600">
                                                            Once your account is deleted, all of its resources and data
                                                            will be permanently deleted. Please enter your password to
                                                            confirm you would like to permanently delete your account.
                                                        </p>

                                                        <div class="mt-6">
                                                            <InputLabel for="password" value="Password"
                                                                class="sr-only" />

                                                            <TextInput id="password" ref="passwordInput"
                                                                v-model="userForm.password" type="password"
                                                                class="form-control" placeholder="Password"
                                                                @keyup.enter="deleteUser" />

                                                            <InputError :message="userForm.errors.password"
                                                                class="mt-2" />
                                                        </div>

                                                        <div class="mt-6 flex justify-end">
                                                            <SecondaryButton @click="closeModal">
                                                                Cancel
                                                            </SecondaryButton>

                                                            <Button class="btn btn-danger"
                                                                :disabled="userForm.processing" @click="deleteUser">
                                                                Delete Account
                                                            </Button>
                                                        </div>
                                                    </div>
                                                </Modal>
                                            </section>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <ProfileDetailCard :user_name="hostData.user_name" :last_name="hostData.last_name"
                        :first_name="hostData.first_name" :image="hostData.profile_logo_url"
                        :language="hostData.language" :about_you="hostData.about_you"
                        :joined_date="hostData.joined_date" :mobile_number="hostData.mobile_number"
                        :address="hostData.address" :unique_id="hostData.unique_id" :status="hostData.status"
                        :email="hostData.email" :email_verified="hostData.email_verified"
                        :id_verification_verfied="hostData.id_verification_verfied"
                        :mobile_number_verfied="hostData.mobile_number_verfied" class="mt-4 mt-md-0" />
                </div>
            </template>

            <template #modals>
                <HostIDModal :selectedIdSide="selectedIdSide" :modalImageSrc="modalImageSrc" />

                <VerifyHostID :title="verifyModal.title" :hostId="host_id" :content="verifyModal.content"
                    :formType="'host'" :hostVerificationDetailsId="hostVerificationDetailsId" />

                <RejectHostIDCardModal :title="rejectModal.title" :hostId="host_id" :content="rejectModal.content"
                    :formType="'host'" :hostVerificationDetailsId="hostVerificationDetailsId" />
            </template>

            <template #loader>
                <Loader :isLoading="isLoading" />
            </template>
        </AppLayout>
    </AuthenticatedLayout>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import axios from "axios";
import { ref, onMounted, defineEmits } from "vue";
import Loader from "@/Components/main/Loader.vue";
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
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

import DangerButton from '@/Components/DangerButton.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { nextTick } from 'vue';

import businessProfile  from '../Profile/components/business-profile/businessProfile.vue'
import basicProfile  from '../Profile/components/basic-profile/basicProfile.vue'
import identityCard  from '../Profile/components/identity-cards/identityCard.vue'
import passwordReset  from '../Profile/components/password-reset/passwordReset.vue'

// PASSWORD SECTION
// Define reactive variables
const confirmingUserDeletion = ref(false);


// Define form for user deletion
const userForm = useForm({
    password: '',
});

// Function to open the confirmation modal
const confirmUserDeletion = () => {
    confirmingUserDeletion.value = true;

    nextTick(() => {
        if (passwordInput.value) {
            passwordInput.value.focus();
        }
    });
};

// Function to delete the user
const deleteUser = () => {
    userForm.delete(route('profile.destroy'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => {
            if (passwordInput.value) {
                passwordInput.value.focus();
            }
        },
        onFinish: () => userForm.reset(),
    });
};

// Function to close the modal
const closeModal = () => {
    confirmingUserDeletion.value = false;
    userForm.clearErrors();
    userForm.reset();
};




import { Link, useForm, usePage } from "@inertiajs/vue3";

import {
    emitter,
    UPDATE_AFTER_REJECT_HOST_ID,
    UPDATE_AFTER_VERIFY_HOST_ID,
    CLEAR_HOST_REJECT_FIELDS,
} from "@/event-bus.js";


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
