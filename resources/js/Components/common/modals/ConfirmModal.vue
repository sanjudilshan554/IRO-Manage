<template>
  <div
    class="modal fade"
    id="confirmModal"
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
        <div class="modal-body">{{ content }}</div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <component :is="formComponent" :deleteId="deleteId" />
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, defineProps, watchEffect, defineEmits } from 'vue'
import DeleteTypeForm from '@/components/forms/services/types/DeleteTypeForm.vue'
import LogoutForm from '@/components/forms/main/LogoutForm.vue'

const formComponent = ref(null)

const props = defineProps({
  title: { type: String, required: true },
  content: { type: String, required: true },
  formType: {
    type: String,
    required: true,
  },
  deleteId: {
    type: Number,
    required: true,
  },
})

watchEffect(() => {
  if (props.formType === 'type') {
    formComponent.value = DeleteTypeForm
  }
  // console.log('form ', props.formType)
  if (props.formType === 'logout') {
    formComponent.value = LogoutForm
  }
})
</script>
