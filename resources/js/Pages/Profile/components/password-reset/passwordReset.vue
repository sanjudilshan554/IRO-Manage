<template>
    <div class="tab-pane fade" id="password" role="tabpanel">
        <h4>Password Reset</h4>
        <p>Change or reset your password here.</p>

        <div class="row">
            <div class="col-md-6">
                <h6>Password Section</h6>
                <form @submit.prevent="updatePassword">
                    <div class="mb-3">
                        <InputLabel for="current_password" value="Current Password" />
                        <input id="current_password" ref="currentPasswordInput" v-model="passwordForm.current_password"
                            type="password" class="form-control" autocomplete="current-password" />
                        <InputError :message="passwordForm.errors.current_password" class="mt-2" />
                    </div>

                    <div class="mb-3">
                        <InputLabel for="password" value="New Password" />
                        <input id="password" ref="passwordInput" v-model="passwordForm.password" type="password"
                            class="form-control" autocomplete="new-password" />
                        <InputError :message="passwordForm.errors.password" class="mt-2" />
                    </div>

                    <div class="mb-3">
                        <InputLabel for="password_confirmation" value="Confirm Password" />
                        <input id="password_confirmation" v-model="passwordForm.password_confirmation" type="password"
                            class="form-control" autocomplete="new-password" />
                        <InputError :message="passwordForm.errors.password_confirmation" class="mt-2" />
                    </div>

                    <div class="d-flex align-items-center gap-3 mt-3">
                        <Button :disabled="passwordForm.processing" class="btn btn-primary">Save</Button>
                        <Transition enter-active-class="transition ease-in-out" enter-from-class="opacity-0"
                            leave-active-class="transition ease-in-out" leave-to-class="opacity-0">
                            <p v-if="passwordForm.recentlySuccessful" class="text-sm text-gray-600">Saved.</p>
                        </Transition>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup>
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";

// Password section
const passwordInput = ref(null);
const currentPasswordInput = ref(null);

const passwordForm = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const updatePassword = () => {
    passwordForm.put(route('password.update'), {
        preserveScroll: true,
        onSuccess: () => passwordForm.reset(),
        onError: (errors) => console.error('Error updating password:', errors),
    });
};
</script>
