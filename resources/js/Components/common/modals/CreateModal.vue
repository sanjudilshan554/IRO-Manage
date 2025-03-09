<template>
  <div
    class="modal animated"
    id="createModal"
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
            :is="formComponent"
            @create-category="handleCreateCategory"
            @create-type="handleCreateType"
          />
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
import { ref, defineProps, watchEffect, defineEmits } from 'vue'
import CreateCategoryForm from '@/components/forms/services/categories/CreateCategoryForm.vue'
import CreateTypeForm from '@/components/forms/services/types/CreateTypeForm.vue'
import CreateSubCategoryForm from '@/components/forms/services/sub-categories/CreateSubCategoryForm.vue'
import CreateHostForm from '@/components/forms/hosts/CreateHostForm.vue'
import CreateListingForm from '@/components/forms/listing/CreateListingForm.vue'

const props = defineProps({
  title: {
    type: String,
    required: true,
  },
  formType: {
    type: String,
    required: true,
  },
})

const emit = defineEmits(['create-type', 'create-category'])

const formComponent = ref(null)
const modalInert = ref(false)
const categoryData = ref([])

watchEffect(() => {
  if (props.formType === 'category') {
    formComponent.value = CreateCategoryForm
  } else if (props.formType === 'type') {
    formComponent.value = CreateTypeForm
  } else if (props.formType === 'sub-category') {
    formComponent.value = CreateSubCategoryForm
  } else if (props.formType === 'host') {
    formComponent.value = CreateHostForm
  } else if (props.formType === 'listing') {
    formComponent.value = CreateListingForm
  }
})

const handleCreateCategory = () => {
  emit('create-category')
}

const handleCreateType = () => {
  emit('create-type')
}

const handleClose = () => {
  modalInert.value = true

  setTimeout(() => {
    $('#createModal').modal('hide')
    modalInert.value = false
  }, 300)
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
