<template>
  <form @submit.prevent="submitForm">
    <div class="mb-3">
      <label for="image" class="form-label">Image URL</label>
      <input
        v-model="localData.imageUrl"
        type="text"
        id="image"
        class="form-control"
        placeholder="Enter image URL"
      />
    </div>
    <SaveButton />
  </form>
</template>

<script setup>
import SaveButton from '@/components/common/buttons/SaveButton.vue'
import { reactive, toRefs } from 'vue'

defineProps({
  formData: { type: Object, required: true },
})

const emit = defineEmits(['update'])

const localData = reactive({ ...formData })

const submitForm = () => {
  emit('update', { ...localData })
}
</script>
