<template>
  <fieldset>
    <div class="text-right">
      <DeleteButton @click.prevent="deleteType" />
    </div>
  </fieldset>
</template>

<script setup>
import { ref, defineProps, watchEffect, defineEmits } from 'vue'
import DeleteButton from '@/components/common/buttons/DeleteButton.vue'
import axios from 'axios'
const VITE_BASE_URL = import.meta.env.VITE_BASE_URL

const emit = defineEmits(['delete-type'])

const props = defineProps({
  deleteId: {
    type: Number,
    required: true,
  },
})

watchEffect(() => {
  if (props.deleteId) {
    console.log('delete type form', props.deleteId)
  }
})

const deleteType = async () => {
  try {
    console.log('delete is ongoing')
    // await axios.post(`${VITE_BASE_URL}api/v1/delete/entity-types/${props.editId}`)
    // emit('delete-type')
    // $('#confirmModal').modal('hide')
    // clearFormData()
  } catch (error) {
    // console.error('Error creating category:', error)
  }
}
</script>
