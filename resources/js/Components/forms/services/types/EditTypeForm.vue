<template>
  <form @submit.prevent="submitForm">
    <fieldset>
      <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input
          v-model="formData.name"
          type="text"
          id="name"
          class="form-control"
          placeholder="Enter Type Name"
          required
        />
      </div>
      <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea
          v-model="formData.description"
          type="text"
          id="description"
          class="form-control"
          placeholder="Enter Type Description"
        />
      </div>
      <div class="mb-3">
        <label for="description" class="form-label">Status</label>
        <div class="form-check form-switch">
          <input
            class="form-check-input"
            v-model="formData.status"
            type="checkbox"
            id="rememberMe"
            checked
            required
          />
        </div>
      </div>

      <div class="text-right">
        <SaveButton />
      </div>
    </fieldset>
  </form>
</template>

<script setup>
import { ref, defineEmits, onMounted, watchEffect } from 'vue'
import SaveButton from '@/components/common/buttons/SaveButton.vue'
import axios from 'axios'
const VITE_BASE_URL = import.meta.env.VITE_BASE_URL

const props = defineProps({
  editId: {
    type: Number,
    required: true,
  },
})

console.log('edit form')

const formData = ref({ name: '', description: '', status: true })
const emit = defineEmits(['create-type'])

const clearFormData = () => {
  formData.value = { name: '', description: '', status: true }
}

const getFormData = () => {
  try {
    console.log('id', props.editId)
    // const response = await axios.post(`${VITE_BASE_URL}api/v1/update/entity-types/${props.editId}`)
    // formData.value = response.data
    // emit('edit-type')
    // $('#editModal').modal('hide')
    // clearFormData()
  } catch (error) {
    // console.error('Error creating category:', error)
  }
}

watchEffect(() => {
  if (props.editId) {
    console.log('edit type form', props.editId)
  }
})

const submitForm = async () => {
  try {
    console.log('edit is ongoing')
    // await axios.post(`${VITE_BASE_URL}api/v1/update/entity-types`, formData.value)
    // emit('create-type')
    // $('#createModal').modal('hide')
    // clearFormData()
  } catch (error) {
    console.error('Error updating category:', error)
  }
}

onMounted(() => {
  getFormData()
})
</script>
