<template>
    <div class="tab-pane fade" id="account" role="tabpanel">
        <h4 class="text-danger">Account Deletion</h4>
        <p class="mt-1 text-muted">
            Once your account is deleted, all of its resources and data will
            be permanently deleted. Before deleting your account, please
            download any data or information that you wish to retain.
        </p>

        <div class="row">
            <section class="space-y-6">
                <button @click="showModal" type="button" class="btn btn-danger">Delete Account</button>
            </section>

        </div>
    </div>
    <AccountDeleteModal ref="accountDeleteModal" :title="deleteModal.title" :content="deleteModal.content"
        :formType="'host'" @create-host="handleDeleteType" />

    <Loader :isLoading="isLoading" />

    <dataSavedAlert v-if="alertMessage" :alertTitle="alertMessage" />
</template>

<script setup>
import { ref } from "vue";
import Loader from '@/Components/main/Loader.vue';
import dataSavedAlert from '@/Components/alerts/dataSaveAlert.vue'
import AccountDeleteModal from '@/Components/common/modals/AccountDeleteModal.vue'

const alertMessage = ref(null);
const isLoading = ref(false);

const deleteModal = {
    title: '🛑 Delete Account ',
    content: 'Please enter your password to confirm you would like to permanently delete your account.',
}

import { Modal } from "bootstrap";

const showModal = () => {
    const modalElement = document.getElementById("AccountDeleteModal");
    if (modalElement) {
        const modalInstance = Modal.getInstance(modalElement) || new Modal(modalElement);
        modalInstance.show();
    }
};

</script>
