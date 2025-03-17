<template>
    <div class="p-4 text-center">
        <h2 class="h5 fw-semibold text-dark">
            ⚠️ Are you sure you want to delete your account?
        </h2>

        <p class="mt-2 text-muted">
            Once your account is deleted, all associated data will be permanently removed.
            Please enter your password to confirm.
        </p>

        <div class="mt-4">
            <input id="password" ref="passwordInput" v-model="userForm.password" type="password"
                class="form-control w-30 mx-auto shadow-sm" placeholder="Enter your password"
                @keyup.enter="deleteUser" />

            <InputError :message="userForm.errors.password" class="text-danger mt-2" />
        </div>

        <!-- Buttons -->
        <div class="mt-4 d-flex justify-content-center gap-3">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                Cancel
            </button>

            <DeleteButton class="btn btn-danger" :disabled="userForm.processing" @click="verifyUser();"
                :title="'Delete Account'" />

            <section class="space-y-6">
                <button @click="hideModal" type="button" class="btn btn-danger">Delete Account</button>
            </section>
        </div>
    </div>

    <Loader :isLoading="isLoading" />

    <dataSavedAlert v-if="alertMessage" :alertTitle="alertMessage" />

</template>

<script setup>
import { ref, nextTick } from "vue";
import { useForm } from "@inertiajs/vue3";
import InputError from '@/Components/InputError.vue';
import DeleteButton from '@/Components/common/buttons/DeleteButton.vue';
import Loader from '@/Components/main/Loader.vue';
import dataSavedAlert from '@/Components/alerts/dataSaveAlert.vue'
import { Modal } from "bootstrap";
import axios from 'axios';

const isLoading = ref(false)
const alertMessage = ref(null);

const passwordInput = ref(null);
const userForm = useForm({ password: '' });

// const deleteUser = async () => {
//     isLoading.value = true;

//     verifyUser();

//     await userForm.delete(route('profile.destroy'), {
//         preserveScroll: true,
//         onSuccess: () => {
//             hideModal();
//             // window.location.reload(),

//             // alertMessage.value = "Account deleted successfully";

//                 isLoading.value = false;
//         },
//         onError: () => {
//             if (passwordInput.value) passwordInput.value.focus();
//             isLoading.value = false
//         },
//         onFinish: () => {
//             //  window.location.reload(),
//               userForm.reset(), isLoading.value = false }
//     });
// };

const verifyUser = async () => {
    isLoading.value = true;
    try {
        // Verify the user account
        const user = await axios.post(route('profile.verify'), userForm);

        if (user) {
            window.location.reload();
            hideModal();
            alertMessage.value = "Account deleted successfully";


            // Now delete the user account
            await userForm.delete(route('profile.destroy'), {
                preserveScroll: true,
                onSuccess: () => {
                    // Optionally, you could handle success logic here
                },
                onError: () => {
                    // If error, focus the password input
                    if (passwordInput.value) passwordInput.value.focus();
                },
                onFinish: () => {
                    // Reset the form and stop loading
                    userForm.reset();
                    isLoading.value = false;
                }
            });
        }

        console.log(user.data);  // Corrected to use 'user' instead of 'response'
    } catch (error) {
        isLoading.value = false;
        console.log(error);
    } finally {
        // Ensure loading is turned off
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
