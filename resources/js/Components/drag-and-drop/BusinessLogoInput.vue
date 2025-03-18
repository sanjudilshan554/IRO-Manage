<template>
    <div
        class="dropzone"
        @dragover.prevent
        @drop.prevent="handleDrop"
        @click="triggerFileInput"
    >
        <label class="form-control-label">{{ label }}</label>
        <input type="file" ref="fileInput" @change="handleFileInput" hidden accept="image/*" />

        <img v-if="previewImage" :src="previewImage" class="img-fluid border border-4 border-white" />
        <p v-else class="placeholder-text">Drag & Drop or Click to Upload</p>
    </div>
</template>

<script setup>
import { ref, watch } from "vue";

const props = defineProps({
    label: String,
    modelValue: String // Image URL
});
const emit = defineEmits(["update:modelValue", "upload"]);

const fileInput = ref(null);
const previewImage = ref(props.modelValue || null);

const handleDrop = (event) => {
    const file = event.dataTransfer.files[0];
    processFile(file);
};

const handleFileInput = (event) => {
    const file = event.target.files[0];
    processFile(file);
};

const processFile = (file) => {
    if (file && file.type.startsWith("image/")) {
        const reader = new FileReader();
        reader.onload = (e) => {
            previewImage.value = e.target.result;
        };
        reader.readAsDataURL(file);
        emit("upload", file);
    }
};

const triggerFileInput = () => fileInput.value.click();

watch(() => props.modelValue, (newVal) => {
    previewImage.value = newVal;
});
</script>

<style scoped>
.dropzone {
    /* width: 100%;
    height: 100%; */
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px dashed #ccc;
    border-radius: 100%;
    text-align: center;
    cursor: pointer;
    background-color: white;
    transition: 0.3s;
}
.dropzone:hover {
    background-color: #f9f9f9;
}
.placeholder-text {
    color: #aaa;
}
img {
    max-width: 100%;
    max-height: 180px;
    object-fit: cover;
}
</style>
