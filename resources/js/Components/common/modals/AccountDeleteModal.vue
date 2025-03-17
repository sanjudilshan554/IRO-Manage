<template>
    <div class="modal modal-xl fade " id="AccountDeleteModal" tabindex="-1" aria-labelledby="accountDeleteLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="accountDeleteLabel">{{ title }}</h5>
                    <button type="button" class="btn-close btn-close-dark" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <!-- <div class="modal-body">{{ content }}</div> -->
                <DeleteAccountForm/>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, defineProps, watchEffect, defineEmits } from 'vue'
import DeleteAccountForm from '@/Components/forms/profile/DeleteAccountForm.vue'
import { Modal } from "bootstrap";
const formComponent = ref(null)

const props = defineProps({
    title: { type: String, required: true },
    content: { type: String, required: true },
    formType: {
        type: String,
        required: true,
    }
})

watchEffect(() => {

})
</script>
<style scoped>
.modal {
    z-index: 1050 !important;
}

.modal-backdrop {
    z-index: 1050 !important;
}

/* .modal-backdrop.show {
    opacity: var(--bs-backdrop-opacity) !important;
} */

.modal-backdrop.fade {
    opacity: 0 !important;
}
</style>