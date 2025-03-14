<template>
    <AuthenticatedLayout>
        <AppLayout>
            <template #content>
                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header pb-0 d-flex align-items-center">
                                <p class="mb-0">Business Profile</p>
                            </div>
                            <div class="card-body mt-4">
                                <ul class="nav nav-tabs" id="profileTab" role="tablist">
                                    <li v-for="tab in tabs" :key="tab.id" class="nav-item" role="presentation">
                                        <button class="nav-link" :class="{ active: tab.active }" :id="tab.id"
                                            data-bs-toggle="tab" :data-bs-target="tab.target" type="button" role="tab">
                                            {{ tab.label }}
                                        </button>
                                    </li>
                                </ul>
                                <div class="tab-content mt-3" id="profileTabContent">
                                    <businessProfile />
                                    <basicProfile />
                                    <identityCard />
                                    <passwordReset />
                                    <accountDeletion />
                                </div>
                            </div>
                        </div>
                    </div>
                    <ProfileDetailCard v-bind="hostData" class="mt-4 mt-md-0" />
                </div>
            </template>
            <template #modals>

            </template>
            <template #loader>
                <Loader :isLoading="isLoading" />
            </template>
        </AppLayout>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref, onMounted, defineEmits } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Loader from '@/Components/main/Loader.vue';
import ProfileDetailCard from '@/Components/cards/profile/ProfileDetailCard.vue';
import businessProfile from '../Profile/components/business-profile/businessProfile.vue';
import basicProfile from '../Profile/components/basic-profile/basicProfile.vue';
import identityCard from '../Profile/components/identity-cards/identityCard.vue';
import passwordReset from '../Profile/components/password-reset/passwordReset.vue';
import accountDeletion from '../Profile/components/account-deletion/accountDeletion.vue';

const hostData = ref({});
const isLoading = ref(false);
const emit = defineEmits(['clear-validation']);

const tabs = [
    { id: 'business-tab', label: 'Business Profile', target: '#business', active: true },
    { id: 'basic-tab', label: 'Basic Profile', target: '#basic', active: false },
    { id: 'identity-tab', label: 'Identity Cards', target: '#identity', active: false },
    { id: 'password-tab', label: 'Password Reset', target: '#password', active: false },
    { id: 'account-tab', label: 'Account Deletion', target: '#account', active: false, class: 'text-danger' },
];

onMounted(() => {
    // Fetch host data if necessary
});



</script>

<style scoped></style>