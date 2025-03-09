<template>
  <AdminLayout>
    <template #content>
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header pb-0">
              <div class="d-flex align-items-center">
                <div class="mb-0 fs-4">Listing's Profile</div>
              </div>
            </div>

            <div class="card-body">
              <p class="text-uppercase text-sm fw-bold">Primary Information</p>

              <div class="row">
                <div class="col-12 col-md-6">
                  <label class="label fs-6 pe-1">
                    <i class="bi bi-tag text-primary"></i> Title:
                  </label>
                  <span v-if="listingData.title"> {{ listingData.title }}</span>
                  <span v-else> N/A</span>
                </div>
                <div class="col-12 col-md-6">
                  <label class="label fs-6 pe-1">
                    <i class="bi bi-card-text text-primary"></i> Description:
                  </label>
                  <span v-if="listingData.description"> {{ listingData.description }}</span>
                  <span v-else> N/A</span>
                </div>
                <div class="col-12 col-md-6">
                  <label class="label fs-6 pe-1">
                    <i class="bi bi-folder text-primary"></i> Category:
                  </label>
                  <span v-if="listingData.category?.name"> {{ listingData.category?.name }}</span>
                  <span v-else> N/A</span>
                </div>
                <div class="col-12 col-md-6">
                  <label class="label fs-6 pe-1">
                    <i class="bi bi-flag text-primary"></i> Status:
                  </label>
                  <span class="badge bg-warning" v-if="listingData.status == 'under_review'">
                    Under Review
                  </span>
                  <span class="badge bg-success" v-if="listingData.status == 'approved'">
                    Approved
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-12 mt-4">
          <div class="card">
            <div class="card-header pb-0">
              <div class="d-flex align-items-center">
                <p class="mb-0 fs-4">Listing's Images</p>
              </div>
            </div>

            <div class="card-body text-center d-flex align-items-center justify-content-center">
              <div class="row" v-if="listingData?.farmhouse_details?.farm_house_image.length">
                <div
                  class="col-xl-3 col-lg-6 col-md-12"
                  v-for="(image, index) in listingData?.farmhouse_details?.farm_house_image"
                  :key="index"
                >
                  <div class="card m-2">
                    <img
                      :src="BASE_IMAGE_URL + image.image_url"
                      class="card-img-top"
                      @error="onImageError"
                    />
                    <div class="card-body">
                      <p class="card-text">Temp Text</p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="" v-else>
                <img :src="ImageNotFound" width="200" />
                <h6>Currently, there are no images available.</h6>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-12 mt-4">
          <div class="card">
            <!-- End of Top Cards Section -->
            <div class="card-header pb-0">
              <div class="d-flex align-items-center">
                <p class="mb-0 fs-4">Address</p>
              </div>
            </div>

            <div class="card-body">
              <p class="text-uppercase text-sm fw-bold">Basic Information</p>

              <div class="row">
                <div class="col-12 col-md-6">
                  <label class="label fs-6 pe-1">
                    <i class="bi bi-house text-success"></i> Address Line 1:
                  </label>
                  <span v-if="listingData?.farmhouse_details?.addreess?.address_line_1">
                    {{ listingData?.farmhouse_details?.addreess?.address_line_1 }}
                  </span>
                  <span v-else> N/A</span>
                </div>
                <div class="col-12 col-md-6">
                  <label class="label fs-6 pe-1">
                    <i class="bi bi-clipboard text-success"></i> Address Line 2:
                  </label>
                  <span v-if="listingData?.farmhouse_details?.addreess?.address_line_2">
                    {{ listingData?.farmhouse_details?.addreess?.address_line_2 }}
                  </span>
                  <span v-else> N/A</span>
                </div>
                <div class="col-12 col-md-6">
                  <label class="label fs-6 pe-1">
                    <i class="bi bi-building text-success"></i> City:
                  </label>
                  <span v-if="listingData?.farmhouse_details?.addreess?.city">
                    {{ listingData?.farmhouse_details?.addreess?.city }}
                  </span>
                  <span v-else> N/A</span>
                </div>
                <div class="col-12 col-md-6">
                  <label class="label fs-6 pe-1">
                    <i class="bi bi-globe text-success"></i> Country:
                  </label>
                  <span v-if="listingData?.farmhouse_details?.addreess?.country">
                    {{ listingData?.farmhouse_details?.addreess?.country }}
                  </span>
                  <span v-else> N/A</span>
                </div>
                <div class="col-12 col-md-6">
                  <label class="label fs-6 pe-1">
                    <i class="bi bi-envelope text-success"></i> Postal Code:
                  </label>
                  <span v-if="listingData?.farmhouse_details?.addreess?.postal_code">
                    {{ listingData?.farmhouse_details?.addreess?.postal_code }}
                  </span>
                  <span v-else> N/A</span>
                </div>
                <div class="col-12 col-md-6">
                  <label class="label fs-6 pe-1">
                    <i class="bi bi-map text-success"></i> State:
                  </label>
                  <span v-if="listingData?.farmhouse_details?.addreess?.state">
                    {{ listingData?.farmhouse_details?.addreess?.state }}
                  </span>
                  <span v-else> N/A</span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-12 mt-4">
          <div class="card">
            <div class="card-header pb-0">
              <div class="d-flex align-items-center">
                <p class="mb-0 fs-4">Documents</p>
              </div>
            </div>

            <div class="card-body">
              <p class="text-uppercase text-sm">-/-</p>
              <div class="row"></div>
              <!-- <hr class="horizontal dark" /> -->
            </div>
          </div>
        </div>
      </div>
    </template>

    <template #modals> </template>

    <template #loader>
      <Loader :isLoading="isLoading" />
    </template>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/layouts/AdminLayout.vue'
import axios from 'axios'
import { ref, onMounted, defineEmits } from 'vue'
import Loader from '@/components/main/Loader.vue'
import { useRoute } from 'vue-router'
import ImageNotFound from '@/src/assets/img/empty-state-images/image-not-found.png'

// import { emitter, CLEAR_LISTING_REJECT_FIELDS } from '@/event-bus.js'
const BASE_IMAGE_URL = import.meta.env.VITE_BASE_IMAGE_URL
const VITE_BASE_URL = import.meta.env.VITE_BASE_URL

const listingData = ref([])
const isLoading = ref(false)
const emit = defineEmits(['clear-validation'])
const route = useRoute()
const totalRows = ref(0)
const listing_id = route.params.listing_id
const modalImageSrc = ref('')
const selectedIdSide = ref('')
const listingVerificationDetailsId = ref(0)
const host_id = ref(0)

// const showImageModal = (imageSrc, side) => {
//   isLoading.value = true
//   try {
//     selectedIdSide.value = side
//     modalImageSrc.value = imageSrc
//     $('#image-modal').modal('show')
//     isLoading.value = false
//   } catch {
//     isLoading.value = false
//   }
// }

const getListingData = async () => {
  isLoading.value = true
  try {
    const response = await axios.post(`${VITE_BASE_URL}api/v1/host/listing/admin/more/details`, {
      listing_id: listing_id,
    })
    // console.log('profile', response)
    listingData.value = response.data.data
    host_id.value = response.data.data.host_id
    getHostData(host_id.value)
    listingVerificationDetailsId.value = response.data.data?.verification_details?.id
  } catch (error) {
    console.error('Error fetching listing data:', error)
  } finally {
    isLoading.value = false
  }
}

const getHostData = async (host_id) => {
  isLoading.value = true
  try {
    const response = await axios.post(`${VITE_BASE_URL}api/v1/host/listing/admin/host/listing`, {
      host_id: host_id,
    })
    // console.log('host', response)
  } catch (error) {
    console.error('Error fetching host data:', error)
  } finally {
    isLoading.value = false
  }
}

onMounted(() => {
  getListingData()
})

// const verifyModal = {
//   title: 'Verify Listing Identity Card',
//   content: 'Are you sure you want to verify this listing identity card?',
// }

// const rejectModal = {
//   title: 'Reject Listing Identity Card',
//   content: 'Are you sure you want to reject this listing identity card?',
// }
</script>

<style scoped></style>
