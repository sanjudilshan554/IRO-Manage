<template>
    <div class="tab-pane fade" id="basic" role="tabpanel">
        <h4>Basic Profile</h4>
        <p>Manage your business details here.</p>

        <div class="row">
            <div class="col-md-6">
                <form @submit.prevent="updateProfile">
                    <div class="mb-3">
                        <InputLabel for="name" value="Name" />
                        <input id="name" type="text" class="form-control" v-model="form.name" required autofocus
                            autocomplete="name" />
                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>

                    <div class="mb-3">
                        <InputLabel for="email" value="Email" />
                        <input id="email" type="email" class="form-control" v-model="form.email" required
                            autocomplete="username" />
                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>

                    <div v-if="mustVerifyEmail && user.email_verified_at === null" class="mt-3">
                        <p class="text-sm text-gray-800">
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

                    <div class="text-end mt-4">
                        <Button :disabled="form.processing" class="btn btn-primary">Save</Button>
                        <Transition enter-active-class="transition ease-in-out" enter-from-class="opacity-0"
                            leave-active-class="transition ease-in-out" leave-to-class="opacity-0">
                            <p v-if="form.recentlySuccessful" class="text-sm text-gray-600 mt-2">
                                Saved.
                            </p>
                        </Transition>
                    </div>
                </form>
            </div> 
        </div>
    </div>
</template>

<script setup>

import axios from "axios";
import { Link, useForm, usePage } from "@inertiajs/vue3";

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

const updateProfile = async () => {
    try {
        const response = await axios.patch('http://127.0.0.1:8000/profile', form);
    } catch (error) {
        console.log('Error updating profile:', error.response?.data || error);
    }
}

</script>

<style></style>