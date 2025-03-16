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

            <DeleteButton class="btn btn-danger" :disabled="userForm.processing" @click="deleteUser();"
                :title="'Delete Account'" />
        </div>
    </div>
</template>

<script setup>
import { ref, nextTick } from "vue";
import { useForm } from "@inertiajs/vue3";
import InputError from '@/Components/InputError.vue';
import DeleteButton from '@/Components/common/buttons/DeleteButton.vue';

const passwordInput = ref(null);
const userForm = useForm({ password: '' });

const deleteUser = () => {
    userForm.delete(route('profile.destroy'), {
        preserveScroll: true,
        onSuccess: () => window.location.reload(),
        onError: () => {
            if (passwordInput.value) passwordInput.value.focus();
        },
        onFinish: () => { window.location.reload(), userForm.reset()}
    });
};
</script>
