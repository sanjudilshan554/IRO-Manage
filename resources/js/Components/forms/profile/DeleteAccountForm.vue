<template>
    <div class="p-4 text-center">
        <h2 class="h5 fw-semibold text-dark">
            Are you sure you want to delete your account?
        </h2>

        <p class="mt-2   text-danger">
            ⚠️ Once your account is deleted, all associated data will be permanently removed.
            Please enter your password to confirm.
        </p>

        <div class="mt-4">
            <input id="password" ref="passwordInput" v-model="userForm.password" type="password"
                class="form-control w-30 mx-auto shadow-sm" placeholder="Enter your password"
                @keyup.enter="deleteUser" />


            <div class="mt-2">
                <span v-if="errorMessage" class="text-danger">{{ errorMessage }}</span>
            </div>
        </div>

        <!-- Buttons -->
        <div class="mt-4 d-flex justify-content-center gap-3">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                Cancel
            </button>

            <DeleteButton class="btn btn-danger" :disabled="userForm.processing" @click="verifyAndDelete();"
                :title="'Delete Account'" />
        </div>
    </div>

    <Loader :isLoading="isLoading" />

    <dataSavedAlert v-if="alertMessage" :alertTitle="alertMessage" />

</template>

<script setup>
import { ref, nextTick } from "vue";
import { useForm } from "@inertiajs/vue3";
import DeleteButton from '@/Components/common/buttons/DeleteButton.vue';
import Loader from '@/Components/main/Loader.vue';
import dataSavedAlert from '@/Components/alerts/dataSaveAlert.vue'
import { Modal } from "bootstrap";
import axios from 'axios';

const isLoading = ref(false)
const alertMessage = ref(null);

const passwordInput = ref(null);
const userForm = useForm({ password: '' });
const errorMessage = ref('');

const verifyAndDelete = async () => {
    isLoading.value = true;
    try {
        const response = await axios.post(route('profile.verify'), userForm);
        if (response) {
            await userForm.delete(route('profile.destroy'), {
                preserveScroll: true,
                onError: () => passwordInput.value?.focus(),
                onFinish: () => userForm.reset(),
            });

            alertMessage.value = "Account deleted successfully";
            window.location.reload();
            hideModal();
        }
    } catch (error) {
        errorMessage.value = error.response?.data?.message || "An error occurred.";
        console.error(error);
    } finally {
        isLoading.value = false;
    }
};

const hideModal = () => {
    const modalElement = document.getElementById("AccountDeleteModal");
    if (modalElement) {
        const modalInstance = Modal.getInstance(modalElement) || new Modal(modalElement);
        modalInstance.hide();
    }
};
</script>
