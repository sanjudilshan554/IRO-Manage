<template>
  <div
    class="modal fade"
    id="reject-host-id-card-modal"
    tabindex="-1"
    aria-labelledby="confirmModalLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="confirmModalLabel">{{ title }}</h5>
          <button
            type="button"
            class="btn-close btn-close-dark"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
        <div class="modal-body">
          <div class="pb-3">
            {{ content }}
          </div>

          <component
            :is="formComponent"
            :hostId="hostId"
            :hostVerificationDetailsId="hostVerificationDetailsId"
          />
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, defineProps, watchEffect, defineEmits } from 'vue'
import RejectHostIDCard from '@/components/forms/hosts/profile/RejectHostIDCardForm.vue'

const formComponent = ref(null)

const props = defineProps({
  title: { type: String, required: true },
  content: { type: String, required: true },
  formType: {
    type: String,
    required: true,
  },
  hostId: {
    type: Number,
    required: true,
  },
  hostVerificationDetailsId: {
    type: Number,
    required: true,
  },
})

watchEffect(() => {
  if (props.formType === 'host') {
    formComponent.value = RejectHostIDCard
  }
})
</script>
