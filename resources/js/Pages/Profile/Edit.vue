<template>
    <AuthenticatedLayout>
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
                                    <p class="mb-0">Business Profile</p>
                                </div>
                            </div>

                            <div class="card-body">
                                <div>
                                    <div class="container mt-4">
                                        <form>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Name</label>
                                                    <input type="text" class="form-control" name="name">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Company Code</label>
                                                    <input type="text" class="form-control" name="company_code">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">SLBFE Reg Code</label>
                                                    <input type="text" class="form-control" name="slbfe_reg_code">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Address</label>
                                                    <input type="text" class="form-control" name="address">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Postal Code</label>
                                                    <input type="text" class="form-control" name="postal_code">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">City</label>
                                                    <input type="text" class="form-control" name="city">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Dispatch Countries</label>
                                                    <input type="text" class="form-control" name="dispatch_countries">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Email</label>
                                                    <input type="email" class="form-control" name="email">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Phone</label>
                                                    <input type="text" class="form-control" name="phone">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Website</label>
                                                    <input type="url" class="form-control" name="website">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Tax ID</label>
                                                    <input type="text" class="form-control" name="tax_id">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Registration Number</label>
                                                    <input type="text" class="form-control" name="registration_number">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Industry</label>
                                                    <input type="text" class="form-control" name="industry">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Business Type</label>
                                                    <input type="text" class="form-control" name="business_type">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Currency</label>
                                                    <input type="text" class="form-control" name="currency">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Bank Account Details</label>
                                                    <input type="text" class="form-control" name="bank_account_details">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Status</label>
                                                    <select class="form-control" name="status">
                                                        <option value="active">Active</option>
                                                        <option value="inactive">Inactive</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Category</label>
                                                    <input type="text" class="form-control" name="category">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Logo</label>
                                                    <input type="file" class="form-control" name="logo">
                                                </div>
                                                <div class="col-md-12 mb-3">
                                                    <label class="form-label">Notes</label>
                                                    <textarea class="form-control" name="notes" rows="3"></textarea>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Created By</label>
                                                    <input type="text" class="form-control" name="created_by" disabled>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Updated By</label>
                                                    <input type="text" class="form-control" name="updated_by" disabled>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </form>
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
                                                <button class="btn btn-success" @click.prevent="verifyHostIDCard()"
                                                    :disabled="hostData.email_verified == 0 ||
                                                        hostData.mobile_number_verfied ==
                                                        0 ||
                                                        hostData.id_verification_verfied ==
                                                        1 ||
                                                        hostData.is_verfied == 1
                                                        ">
                                                    Verify
                                                </button>
                                                <button class="btn btn-danger" @click.prevent="rejectHostIDCard()"
                                                    :disabled="hostData.email_verified == 0 ||
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
                                                    " class="col-12 col-md-6 d-flex align-items-center justify-content-center identity-card"
                                                        @click="
                                                            showImageModal(
                                                                `${BASE_IMAGE_URL}${hostData.verification_details?.front_image_url}`,
                                                                'Front'
                                                            )
                                                            ">
                                                        <div class="id-input" data-toggle="tooltip"
                                                            data-placement="bottom" title="View Host ID Front Image">
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
                                                                class="img-fluid border border-4 border-white"
                                                                width="50%" />
                                                        </div>
                                                    </div>

                                                    <!-- Back ID Input -->
                                                    <div v-if="
                                                        hostData
                                                            .verification_details
                                                            ?.back_image_url
                                                    " class="col-12 col-md-6 mt-4 mt-md-0 d-flex align-items-center justify-content-center identity-card"
                                                        @click="
                                                            showImageModal(
                                                                `${BASE_IMAGE_URL}${hostData.verification_details?.back_image_url}`,
                                                                'Back'
                                                            )
                                                            ">
                                                        <div class="id-input" data-toggle="tooltip"
                                                            data-placement="bottom" title="View Host ID Back Image">
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
                                                                class="img-fluid border border-4 border-white"
                                                                width="50%" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <h5 class="text-uppercase ">
                                        Main Profile
                                    </h5>

                                    <div class="row">
                                        <h6>Primary Section </h6>
                                        <form @submit.prevent="updateProfile" class="">
                                            <InputLabel for="name" value="Name" />
                                            <input id="name" type="text" class="form-control" v-model="form.name"
                                                required autofocus autocomplete="name" />
                                            <InputError class="mt-2" :message="form.errors.name" />
                                            <InputLabel for="email" value="Email" />
                                            <input id="email" type="email" class="form-control" v-model="form.email"
                                                required autocomplete="username" />
                                            <InputError class="mt-2" :message="form.errors.email" />
                                            <div v-if="mustVerifyEmail && user.email_verified_at === null">
                                                <p class="mt-2 text-sm text-gray-800">
                                                    Your email address is unverified.
                                                    <Link :href="route('verification.send')" method="post" as="button"
                                                        class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                                    Click here to re-send the verification email.
                                                    </Link>
                                                </p>
                                                <div v-show="status === 'verification-link-sent'"
                                                    class="mt-2 text-sm font-medium text-green-600">
                                                    A new verification link has been sent to your email address.
                                                </div>
                                            </div>

                                            <div class="flex items-center gap-4">
                                                <Button :disabled="form.processing"
                                                    class="btn btn-primary">Save</Button>
                                                <Transition enter-active-class="transition ease-in-out"
                                                    enter-from-class="opacity-0"
                                                    leave-active-class="transition ease-in-out"
                                                    leave-to-class="opacity-0">
                                                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">
                                                        Saved.
                                                    </p>
                                                </Transition>
                                            </div>
                                        </form>
                                    </div>

                                    <div class="row">
                                        <h6>Password Section </h6>
                                        <form @submit.prevent="updatePassword" class="">
                                            <div>
                                                <InputLabel for="current_password" value="Current Password" />

                                                <input id="current_password" ref="currentPasswordInput"
                                                    v-model="passwordForm.current_password" type="password"
                                                    class="form-control" autocomplete="current-password" />

                                                <InputError :message="passwordForm.errors.current_password"
                                                    class="mt-2" />
                                            </div>

                                            <div>
                                                <InputLabel for="password" value="New Password" />

                                                <input id="password" ref="passwordInput" v-model="passwordForm.password"
                                                    type="password" class="form-control" autocomplete="new-password" />

                                                <InputError :message="passwordForm.errors.password" class="mt-2" />
                                            </div>

                                            <div>
                                                <InputLabel for="password_confirmation" value="Confirm Password" />

                                                <input id="password_confirmation"
                                                    v-model="passwordForm.password_confirmation" type="password"
                                                    class="form-control" autocomplete="new-password" />

                                                <InputError :message="passwordForm.errors.password_confirmation"
                                                    class="mt-2" />
                                            </div>

                                            <div class="flex items-center gap-4">
                                                <Button :disabled="passwordForm.processing"
                                                    class="btn btn-primary">Save</Button>

                                                <Transition enter-active-class="transition ease-in-out"
                                                    enter-from-class="opacity-0"
                                                    leave-active-class="transition ease-in-out"
                                                    leave-to-class="opacity-0">
                                                    <p v-if="passwordForm.recentlySuccessful"
                                                        class="text-sm text-gray-600">
                                                        Saved.
                                                    </p>
                                                </Transition>
                                            </div>
                                        </form>
                                    </div>

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
                                                        <InputLabel for="password" value="Password" class="sr-only" />

                                                        <TextInput id="password" ref="passwordInput"
                                                            v-model="userForm.password" type="password"
                                                            class="form-control" placeholder="Password"
                                                            @keyup.enter="deleteUser" />

                                                        <InputError :message="userForm.errors.password" class="mt-2" />
                                                    </div>

                                                    <div class="mt-6 flex justify-end">
                                                        <SecondaryButton @click="closeModal">
                                                            Cancel
                                                        </SecondaryButton>

                                                        <Button class="btn btn-danger" :disabled="userForm.processing"
                                                            @click="deleteUser">
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
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

import DangerButton from '@/Components/DangerButton.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { nextTick } from 'vue';


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

// Password section
const passwordInput = ref(null);
const currentPasswordInput = ref(null);

const passwordForm = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const updatePassword = async () => {
    try {
        const response = await axios.put('http://127.0.0.1:8000/password', {
            password: passwordForm.password,
            password_confirmation: passwordForm.password_confirmation,
            current_password: passwordForm.current_password,
        });

        passwordForm.reset();
        console.log('Password updated successfully:', response.data);
    } catch (error) {
        console.error('Error updating password:', error.response?.data || error);
    }
};

const updateProfile = async () => {
    try {
        const response = await axios.patch('http://127.0.0.1:8000/profile', form);
    } catch (error) {
        console.log('Error updating profile:', error.response?.data || error);
    }
}

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
