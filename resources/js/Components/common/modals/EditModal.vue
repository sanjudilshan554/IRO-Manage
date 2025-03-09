<template>
  <div
    class="modal animated"
    id="editModal"
    tabindex="-1"
    aria-labelledby="createModalLabel"
    data-bs-backdrop="static"
    :inert="modalInert"
  >
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="createModalLabel">{{ title }}</h5>
          <button
            type="button"
            class="btn-close btn-close-dark"
            aria-label="Close"
            data-bs-dismiss="modal"
            @click="handleClose"
          ></button>
        </div>
        <div class="modal-body">
          <component
            :editId="props.editId"
            :is="formComponent"
            @edit-category="handleEditCategory"
            @edit-host="handleEditHost"
          />
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
import { ref, defineProps, watchEffect, defineEmits } from 'vue'
// import EditHostForm from '@/components/forms/hosts/EditHostForm.vue'

const props = defineProps({
  title: {
    type: String,
    required: true,
  },
  formType: {
    type: String,
    required: true,
  },
  editId: {
    type: Number,
    required: true,
  },
})

const emit = defineEmits(['edit-host', 'edit-category'])

const formComponent = ref(null)
const modalInert = ref(false)

watchEffect(() => {
  // if (props.formType == 'host') {
  //   formComponent.value = EditHostForm
  // }
})

const handleEditCategory = () => {
  emit('edit-category')
}

const handleEditHost = () => {
  emit('edit-host')
}

const handleClose = () => {
  setTimeout(() => {
    const modal = new bootstrap.Modal(document.getElementById('editModal'))
    modal.hide()
  })
}
</script>
<style scoped>
@keyframes slideDown {
  from {
    opacity: 0;
    transform: translateY(-50px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

@keyframes slideUp {
  from {
    opacity: 1;
    transform: translateY(0);
  }
  to {
    opacity: 0;
    transform: translateY(-50px);
  }
}

.modal.animated .modal-dialog {
  transition:
    opacity 0.3s ease-out,
    transform 0.3s ease-out;
}

.modal.animated.show .modal-dialog {
  animation: slideDown 0.3s ease-out;
}

.modal.animated:not(.show) .modal-dialog {
  animation: slideUp 0.3s ease-out;
}
</style>
