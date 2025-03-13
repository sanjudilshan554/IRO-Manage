<template>
    <div class="tab-pane fade" id="account" role="tabpanel">
        <h4 class="text-danger">Account Deletion</h4>
        <p class="mt-1 text-sm text-gray-600">
            Once your account is deleted, all of its resources and data will
            be permanently deleted. Before deleting your account, please
            download any data or information that you wish to retain.
        </p>

        <div class="row">
            <section class="space-y-6">


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

                            <TextInput id="password" ref="passwordInput" v-model="userForm.password" type="password"
                                class="form-control" placeholder="Password" @keyup.enter="deleteUser" />

                            <InputError :message="userForm.errors.password" class="mt-2" />
                        </div>

                        <div class="mt-6 flex justify-end">
                            <SecondaryButton @click="closeModal">
                                Cancel
                            </SecondaryButton>

                            <Button class="btn btn-danger" :disabled="userForm.processing" @click="deleteUser">
                                Delete Account
                            </Button>
                        </div>
                    </div>
                </Modal>
            </section>
        </div>

    </div>
</template>

<script setup>
import { ref, onMounted, defineEmits } from "vue";
import { Link, useForm, usePage } from "@inertiajs/vue3";

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
</script>

<style></style>