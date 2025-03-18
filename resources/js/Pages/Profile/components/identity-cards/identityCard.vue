<template>
    <div class="tab-pane fade" id="identity" role="tabpanel">
        <h4>Business Related Documents</h4>
        <p>Ensure the safety of your business documents with this section.</p>
        <div class="row ">
            <div v-for="(document, index) in identityDocuments" :key="index" class="col-md-6 mt-3">
                <label class="fs-6">{{ document.label }}</label>
                <div class="">
                    <label>{{ document.subLabel }}</label>
                    <FileDropzone v-model="businessDocumentsData.document[document.key]"
                        @upload="uploadImage($event, document.key)" />
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import FileDropzone from "@/Components/drag-and-drop/FileDropzone.vue";

const businessDocumentsData = ref({
    document: {}
});

const identityDocuments = ref([
    { label: "BR (Business Registration)", subLabel: "Business Registration Image", key: "br_image" },
    { label: "License (This year)", subLabel: "Current License Image", key: "license_image" },
    { label: "SLBFE Identity Card (Chairman's)", subLabel: "Front Image", key: "slbfe_front_image" },
    { label: "SLBFE Identity Card (Chairman's)", subLabel: "Back Image", key: "slbfe_back_image" }
]);

const uploadImage = async (file, key) => {
    if (!file) return;

    const formData = new FormData();
    formData.append("image", file);
    formData.append("title", key);

    try {
        const response = await axios.post(route('business.document.store'), formData, {
            headers: { "Content-Type": "multipart/form-data" }
        });
        getBusinessDocuments();
    } catch (error) {
        console.error(`Error uploading ${key}:`, error);
    }
};

const getBusinessDocuments = async () => {
    try {
        const response = await axios.get(route('business.documents.all'));
        const latest_documents = response.data;

        Object.entries(latest_documents).forEach(([key, value]) => {
            businessDocumentsData.value.document[key] = value;
        });

    } catch (error) {
        console.error("Error fetching business documents:", error);
    }
};

onMounted(getBusinessDocuments);

</script>
