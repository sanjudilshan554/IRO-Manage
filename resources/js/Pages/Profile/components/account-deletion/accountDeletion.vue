<template>
    <div class="tab-pane fade" id="account" role="tabpanel">
        <h4 class="text-danger">Account Deletion</h4>
        <p class="mt-1 text-muted">
            Once your account is deleted, all of its resources and data will
            be permanently deleted. Before deleting your account, please
            download any data or information that you wish to retain.
        </p>

        <div class="row">
            <section>
                <DangerButton @click="confirmUserDeletion">Delete Account</DangerButton>

                <Modal :show="confirmingUserDeletion" @close="closeModal">
                    <div class="p-4">
                        <h2 class="h5 text-dark">Are you sure you want to delete your account?</h2>

                        <p class="mt-2 text-muted">
                            Once your account is deleted, all of its resources and data
                            will be permanently deleted. Please enter your password to
                            confirm you would like to permanently delete your account.
                        </p>

                        <div class="mt-4">
                            <InputLabel for="password" value="Password" class="sr-only" />
                            <TextInput id="password" ref="passwordInput" v-model="userForm.password" type="password"
                                class="form-control" placeholder="Password" @keyup.enter="deleteUser" />
                            <InputError :message="userForm.errors.password" class="mt-2" />
                        </div>

                        <div class="mt-4 d-flex justify-content-end gap-3">
                            <SecondaryButton @click="closeModal">Cancel</SecondaryButton>
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
import { ref, nextTick } from "vue";
import { useForm } from "@inertiajs/vue3";

// Define reactive variables
const confirmingUserDeletion = ref(false);
const passwordInput = ref(null); // Define password input reference

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
</script>
