<script setup>
import InputError from '@/Components/InputError.vue';
import { Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const showPassword = ref(false);

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template #content>
    <div class="row min-vh-100 justify-content-center align-items-center">
        <div class="col-lg-6 col-md-8 col-12 d-flex justify-content-center align-items-center">
            <div class="card shadow-lg border-0 rounded-4 p-4 w-100" style="max-width: 400px;">
                <div class="card-header text-center">
                    <h3 class="fw-bold text-primary">Sign In</h3>
                    <p class="text-muted">Enter your credentials to access your account</p>
                </div>
                <div class="card-body">
                    <form @submit.prevent="submit">
                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">Email</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white">
                                    <i class="bi bi-envelope-at text-primary"></i>
                                </span>
                                <input id="email" type="email" class="form-control" v-model="form.email" required
                                    autofocus autocomplete="username" placeholder="Enter your email" />
                            </div>

                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold">Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white">
                                    <i class="bi bi-shield-lock text-primary"></i>
                                </span>
                                <input :type="showPassword ? 'text' : 'password'" id="password" class="form-control"
                                    v-model="form.password" required autocomplete="current-password"
                                    placeholder="Enter your password" />
                                <span class="input-group-text bg-white cursor-pointer"
                                    @click="showPassword = !showPassword">
                                    <i
                                        :class="showPassword ? 'fas fa-eye text-primary' : 'fas fa-eye-slash text-muted'"></i>
                                </span>
                            </div>

                        </div>

                        <InputError class="mt-2 text-danger" :message="form.errors.password" />
                        <InputError class="mt-2 text-danger" :message="form.errors.email" />

                        <div class="d-flex justify-content-between align-items-center">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="rememberMe"
                                    v-model="form.remember" />
                                <label class="form-check-label text-muted" for="rememberMe">Remember me</label>
                            </div>

                            <Link v-if="canResetPassword" :href="route('password.request')"
                                class="text-primary text-decoration-none fw-semibold">
                            <i class="bi bi-question-circle me-1"></i> Forgot password?
                            </Link>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 mt-4 rounded-3 py-2"
                            :disabled="form.processing">
                            <span v-if="form.processing" class="spinner-border spinner-border-sm me-2"></span>
                            <span v-if="!form.processing">Sign In</span>
                            <span v-else>Signing in...</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>



</template>

<style scoped></style>