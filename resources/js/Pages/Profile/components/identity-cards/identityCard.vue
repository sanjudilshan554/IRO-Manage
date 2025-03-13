<template>
    <div class="tab-pane fade" id="identity" role="tabpanel">
        <h4>Identity Cards</h4>
        <p>Upload and verify your identity documents.</p>
        <div class="row">
            <div class="col-md-12">
                <div class="id-input-container">
                    <div class="row">
                        <!-- Front ID Input -->
                        <div v-if="
                            hostData
                                .verification_details
                                ?.front_image_url
                        " class="col-12 col-md-6 d-flex align-items-center justify-content-center identity-card"
                            @click="
                                showImageModal(
                                    `${BASE_IMAGE_URL}${hostData.verification_details?.front_image_url}`,
                                    'Front'
                                )
                                ">
                            <div class="id-input" data-toggle="tooltip" data-placement="bottom"
                                title="View Host ID Front Image">
                                <label for="example-text-input" class="form-control-label">Front</label>
                                <img :src="`${BASE_IMAGE_URL}${hostData.verification_details?.front_image_url}`"
                                    class="img-fluid border border-4 border-white" />
                            </div>
                        </div>

                        <div v-else
                            class="col-12 col-md-6 d-flex align-items-center justify-content-center identity-card">
                            <div class="id-input bg-white" data-toggle="tooltip" data-placement="bottom"
                                title="Not Found">
                                <label for="example-text-input" class="form-control-label">Front</label>
                                <div class="" style="
                            background-color: white;
                        "></div>
                                <img :src="ImageNotFound" class="img-fluid border border-4 border-white" width="50%" />
                            </div>
                        </div>

                        <!-- Back ID Input -->
                        <div v-if="
                            hostData
                                .verification_details
                                ?.back_image_url
                        " class="col-12 col-md-6 mt-4 mt-md-0 d-flex align-items-center justify-content-center identity-card"
                            @click="
                                showImageModal(
                                    `${BASE_IMAGE_URL}${hostData.verification_details?.back_image_url}`,
                                    'Back'
                                )
                                ">
                            <div class="id-input" data-toggle="tooltip" data-placement="bottom"
                                title="View Host ID Back Image">
                                <label for="example-text-input" class="form-control-label">Back</label>
                                <img :src="`${BASE_IMAGE_URL}${hostData.verification_details?.back_image_url}`"
                                    class="img-fluid border border-4 border-white image-border-radius" />
                            </div>
                        </div>

                        <div v-else
                            class="col-12 col-md-6 mt-4 mt-md-0 d-flex align-items-center justify-content-center identity-card">
                            <div class="id-input bg-white" data-toggle="tooltip" data-placement="bottom"
                                title="Not Found">
                                <label for="example-text-input" class="form-control-label">Back</label>
                                <div class="" style="
                            background-color: white;
                        "></div>
                                <img :src="ImageNotFound" class="img-fluid border border-4 border-white" width="50%" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, defineEmits } from "vue";


const hostData = ref([]);

const showImageModal = (imageSrc, side) => {
    isLoading.value = true;
    try {
        selectedIdSide.value = side;
        modalImageSrc.value = imageSrc;
        $("#image-modal").modal("show");
        isLoading.value = false;
    } catch {
        isLoading.value = false;
    }
};


const getHostData = async () => {
    isLoading.value = true;
    try {
        const response = await axios.get(
            `${VITE_BASE_URL}api/v1/host/admin/details`,
            {
                params: {
                    host_id: host_id,
                },
            }
        );
        // console.log('response', response)
        hostData.value = response.data.data;
        totalRows.value = response.data.data.total;
        hostVerificationDetailsId.value =
            response.data.data?.verification_details?.id;
    } catch (error) {
        console.error("Error fetching host data:", error);
    } finally {
        isLoading.value = false;
    }
};
</script>

<style></style>