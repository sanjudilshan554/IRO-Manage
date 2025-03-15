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

<template>
    <div class="row min-vh-100 d-flex justify-content-center">

        <div class="col-lg-6 d-none d-lg-flex align-items-center justify-content-center order-lg-1 m-3">
            <div class="position-relative bg-gradient-primary h-100 w-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center overflow-hidden"
                style="
              background-image: url('https://raw.githubusercontent.com/creativetimofficial/public-assets/master/argon-dashboard-pro/assets/img/signin-ill.jpg');
              background-size: cover;
              background-position: center;
            ">
                <span class="mask bg-gradient-primary opacity-6"></span>
                <h4 class="mt-5 text-white font-weight-bolder position-relative text-center">
                    "Attention is the new currency"
                </h4>
                <p class="text-white position-relative text-center px-4">
                    The more effortless the writing looks, the more effort the writer actually put into
                    the process.
                </p>
            </div>
        </div>

        <div class="col-lg-5 col-md-7 m-3 order-lg-2">
            <div class="card shadow-lg border-0 p-4">
                <div class="card-header text-center">
                    <h4 class="fw-bold text-primary">Sign In</h4>
                    <p class="text-muted">Enter your credentials to access your account</p>
                </div>
                <div class="card-body">
                    <form @submit.prevent="submit">
                        <div class="mb-3 position-relative">
                            <label for="email" class="form-label fw-semibold">Email</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-envelope-at fs-5"></i>
                                </span>
                                <input id="email" type="email" class="form-control" v-model="form.email" required
                                    autofocus autocomplete="username" placeholder="Enter your email" />
                            </div>
                            <InputError class="mt-2 text-danger" :message="form.errors.email" />
                        </div>

                        <div class="mb-3 position-relative">
                            <label for="password" class="form-label fw-semibold">Password</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-shield-lock fs-5"></i>
                                </span>
                                <input :type="showPassword ? 'text' : 'password'" id="password" class="form-control"
                                    v-model="form.password" required autocomplete="current-password"
                                    placeholder="Enter your password" />
                                <span class="input-group-text cursor-pointer" @click="showPassword = !showPassword">
                                    <i :class="showPassword ? 'fas fa-eye' : 'fas fa-eye-slash'"></i>
                                </span>
                            </div>
                            <InputError class="mt-2 text-danger" :message="form.errors.password" />
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="rememberMe"
                                    v-model="form.remember" />
                                <label class="form-check-label" for="rememberMe">Remember me</label>
                            </div>

                            <Link v-if="canResetPassword" :href="route('password.request')"
                                class="text-primary text-decoration-none fw-semibold d-flex align-items-center">
                            <i class="bi bi-question-circle me-1"></i> Forgot password?
                            </Link>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 mt-4" :disabled="form.processing">
                            <span v-if="form.processing" class="spinner-border spinner-border-sm me-2"></span>
                            <span v-if="!form.processing">Sign In</span>
                            <span v-else>Signing in...</span>
                        </button>
                    </form>
                </div>
                <div class="card-footer text-center">
                    <p class="text-muted">
                        Don't have an account?
                        <a href="javascript:;" class="text-primary fw-bold">Sign up</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>
