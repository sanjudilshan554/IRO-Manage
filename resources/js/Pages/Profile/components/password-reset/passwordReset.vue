<template>
    <div class="tab-pane fade" id="password" role="tabpanel">
        <h4>Password Reset</h4>
        <p>Change or reset your password here.</p>

        <div class="row">
            <div class="col-md-6">
                <h6>Password Section</h6>
                <form @submit.prevent="updatePassword">
                    <div class="mb-3">
                        <label class="form-label">Current Password</label>
                        <input id="current_password" ref="currentPasswordInput" v-model="passwordForm.current_password"
                            type="password" class="form-control" autocomplete="current-password" />
                        <InputError :message="passwordForm.errors.current_password" class="mt-2 text-danger" />
                    </div>

                    <div class="mb-3">
                        <label class="form-label">New Password</label>
                        <input id="password" ref="passwordInput" v-model="passwordForm.password" type="password"
                            class="form-control" autocomplete="new-password" />
                        <InputError :message="passwordForm.errors.password" class="mt-2 text-danger" />
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Confirm Password</label>
                        <input id="password_confirmation" v-model="passwordForm.password_confirmation" type="password"
                            class="form-control" autocomplete="new-password" />
                        <InputError :message="passwordForm.errors.password_confirmation" class="mt-2 text-danger" />
                    </div>

                    <div class="d-flex align-items-center gap-3 mt-3 float-end">
                        <SaveButton :disabled="passwordForm.processing" class="d-flex float-end" :title="`Save`" />
                    </div>
                </form>
            </div>
        </div>
    </div>

    <Loader :isLoading="isLoading" />

    <dataSavedAlert v-if="alertMessage" :alertTitle="alertMessage" />

</template>

<script setup>
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";
import InputError from '@/Components/InputError.vue';
import SaveButton from "@/Components/common/buttons/SaveButton.vue";
import Loader from '@/Components/main/Loader.vue';
import dataSavedAlert from '@/Components/alerts/dataSaveAlert.vue'

// Password section
const passwordInput = ref(null);
const currentPasswordInput = ref(null);
const isLoading = ref(false)
const alertMessage = ref(null);

const passwordForm = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const updatePassword = async () => {
    isLoading.value = true;
    try {
        await passwordForm.put(route('password.update'), {
            preserveScroll: true,
            onSuccess: () => {
                passwordForm.reset();
                alertMessage.value = "Password reset successfully";
                isLoading.value = false;
            },
            onError: (errors) => {
                console.error('Error updating password:', errors),
                    isLoading.value = false;
            }
        });
    } catch (error) {
        console.error('Unexpected error updating password:', error);
        isLoading.value = false;
    }
};

</script>
