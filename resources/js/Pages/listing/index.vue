<template>
  <AdminLayout>
    <template #content>
      <div class="text-right justify-content-end d-flex">
        <CreateButton @click.prevent="resetValidation" />
      </div>
      <div class="row mt-4 card pt-3">
        <div class="col-12 p-0 m-0">
          <div class="ps-3">
            <h6>{{ tableName.name }}</h6>
          </div>

          <div class="mb-4">
            <div class="row ps-3">
              <div class="col-8 col-md-3">
                <input
                  type="text"
                  v-model="searchQuery"
                  @input="debouncedSearch"
                  class="form-control"
                  placeholder="Search Unique ID, email, mobile"
                />
              </div>
              <div class="col-4 col-md-9">
                <button class="btn btn-primary"><i class="bi bi-eraser-fill"></i></button>
              </div>
            </div>

            <div class="tab-content mt-3" id="stateTabContent">
              <!-- Under Review Tab -->
              <ul class="nav nav-tabs ps-3" id="stateTab" role="tablist">
                <li class="nav-item" role="presentation">
                  <a
                    style="border-radius: 8px 10px 0px 0px !important"
                    class="nav-link text-sm fw-bold"
                    id="underReviewTab"
                    data-bs-toggle="tab"
                    href="#underReview"
                    role="tab"
                    aria-controls="underReview"
                    :class="{
                      'text-primary ': activeTab === 'all',
                      'text-secondary ': activeTab !== 'all',
                      active: activeTab === 'all',
                    }"
                    @click="setActiveTab('all')"
                  >
                    <i class="bi bi-server"></i>
                    All Listing
                  </a>
                </li>
                <li class="nav-item" role="presentation">
                  <a
                    class="nav-link text-sm fw-bold"
                    id="completedTab"
                    data-bs-toggle="tab"
                    href="#verified"
                    role="tab"
                    aria-controls="verified"
                    :class="{
                      'text-primary ': activeTab === 'verified',
                      'text-secondary ': activeTab !== 'verified',
                      active: activeTab === 'verified',
                    }"
                    @click="setActiveTab('verified')"
                  >
                    <i class="bi bi-check-circle-fill"></i>
                    Verified
                  </a>
                </li>
                <li class="nav-item" role="presentation">
                  <a
                    class="nav-link text-sm fw-bold"
                    id="rejectTab"
                    data-bs-toggle="tab"
                    href="#reject"
                    role="tab"
                    aria-controls="reject"
                    :class="{
                      'text-primary ': activeTab === 'reject',
                      'text-secondary ': activeTab !== 'reject',
                      active: activeTab === 'reject',
                    }"
                    @click="setActiveTab('reject')"
                  >
                    <i class="bi bi-x-circle-fill"></i>
                    Unverified
                  </a>
                </li>
              </ul>

              <div
                class="tab-pane fade show"
                :class="{ 'active show': activeTab === 'all' }"
                id="underReview"
                role="tabpanel"
                aria-labelledby="underReviewTab"
              >
                <MainTable
                  class="main-table"
                  :tableName="tableName"
                  :rows="listingData"
                  :headers="tableHeaders"
                  showActions
                  @page-change="handlePageChange"
                >
                  <template #statusSlot="{ row }">
                    <div class="text-center" v-if="row.status == 'under_review'">
                      <span class="badge bg-warning">Under Review</span>
                    </div>
                    <div class="text-center" v-if="row.status == 'approved'">
                      <span class="badge bg-success">Approved</span>
                    </div>
                  </template>
                  <template #secondStepStatus="{ row }">
                    <div class="text-center" v-if="row.secound_step_status == 'in_progress'">
                      <span class="badge bg-secondary">In Progress</span>
                    </div>
                    <div class="text-center" v-if="row.secound_step_status == 'completed'">
                      <span class="badge bg-success">Completed</span>
                    </div>
                  </template>
                  <template #thirdStepStatus="{ row }">
                    <div class="text-center" v-if="row.third_step_status == 'in_progress'">
                      <span class="badge bg-secondary">In Progress</span>
                    </div>
                    <div class="text-center" v-if="row.third_step_status == 'completed'">
                      <span class="badge bg-success">Completed</span>
                    </div>
                  </template>
                  <template #documentStepStatus="{ row }">
                    <div class="text-center" v-if="row.document_step_status == 'completed'">
                      <span class="badge bg-success">Completed</span>
                    </div>
                    <div class="text-center" v-if="row.document_step_status == 'pending'">
                      <span class="badge bg-info">Pending</span>
                    </div>
                    <div
                      class="text-center"
                      v-if="row.document_step_status == '' || row.document_step_status == null"
                    >
                      <span class="badge bg-dark">Not Assign</span>
                    </div>
                  </template>
                  <template #coverImage="{ row }">
                    <div class="image-text-container p-1" v-if="row.cover_image_url">
                      <div class="table-image-container">
                        <img
                          :src="BASE_IMAGE_URL + row.cover_image_url"
                          alt="Perfect Square Image"
                        />
                      </div>
                    </div>
                    <div class="image-text-container p-1" v-else>
                      <div class="table-image-container">
                        <img :src="ImageNotFound" alt="Perfect Square Image" />
                      </div>
                    </div>
                  </template>
                  <template #actions="{ row }">
                    <button
                      class="btn btn-link text-secondary mb-0 p-0 text-center"
                      @click.prevent="editListing(row.listing_id)"
                    >
                      <i class="bi bi-menu-button-wide-fill fs-6"></i>
                    </button>
                  </template>
                </MainTable>
              </div>

              <!-- Reject Tab -->
              <div class="tab-pane fade" id="reject" role="tabpanel" aria-labelledby="rejectTab">
                <MainTable
                  class="main-table"
                  :tableName="tableName"
                  :headers="tableHeaders"
                  :perPage="perPage"
                  :currentPage="currentPage"
                  showActions
                  @page-change="handlePageChange"
                >
                  <template #isVerifiedSlot="{ row }">
                    <div class="text-center">
                      <h6 class="mb-0 text-sm text-center">
                        <div class="" v-if="row.is_verfied == 1">
                          <span class="badge bg-success">Verified</span>
                        </div>
                        <div class="" v-else>
                          <span class="badge bg-danger">Unverified</span>
                        </div>
                      </h6>
                    </div>
                  </template>
                  <template #statusSlot="{ row }">
                    <div class="text-center" v-if="row.status == 'under_review'">
                      <span class="badge bg-warning">Under Review</span>
                    </div>
                    <div class="text-center" v-if="row.status == 'approved'">
                      <span class="badge bg-success">Approved</span>
                    </div>
                  </template>
                  <template #actions="{ row }">
                    <button
                      class="btn btn-link text-secondary mb-0 p-0 text-center"
                      @click.prevent="editListing(row.listing_id)"
                    >
                      <i class="bi bi-menu-button-wide-fill fs-6"></i>
                    </button>
                  </template>
                </MainTable>
              </div>

              <!-- Completed Tab -->
              <div
                class="tab-pane fade"
                id="verified"
                role="tabpanel"
                aria-labelledby="completedTab"
              >
                <MainTable
                  class="main-table"
                  :tableName="tableName"
                  :headers="tableHeaders"
                  :perPage="perPage"
                  :currentPage="currentPage"
                  showActions
                  @page-change="handlePageChange"
                >
                  <template #isVerifiedSlot="{ row }">
                    <div class="text-center">
                      <h6 class="mb-0 text-sm text-center">
                        <div class="" v-if="row.is_verfied == 1">
                          <span class="badge bg-success">Verified</span>
                        </div>
                        <div class="" v-else>
                          <span class="badge bg-danger">Unverified</span>
                        </div>
                      </h6>
                    </div>
                  </template>
                  <template #statusSlot="{ row }">
                    <div class="text-center" v-if="row.status == 'under_review'">
                      <span class="badge bg-warning">Under Review</span>
                    </div>
                    <div class="text-center" v-if="row.status == 'approved'">
                      <span class="badge bg-success">Approved</span>
                    </div>
                  </template>
                  <template #actions="{ row }">
                    <button
                      class="btn btn-link text-secondary mb-0 p-0 text-center"
                      @click.prevent="editListing(row.listing_id)"
                    >
                      <i class="bi bi-menu-button-wide-fill fs-6"></i>
                    </button>
                  </template>
                </MainTable>
              </div>
            </div>
          </div>
        </div>
      </div>
    </template>

    <template #modals>
      <CreateModal
        :title="createModal.title"
        :formType="'listing'"
        @create-listing="handleCreateListing"
      />
      <ConfirmModal
        :title="deleteModal.title"
        :deleteId="deleteListingId"
        :content="deleteModal.content"
        :formType="'listing'"
        @create-listing="handleDeleteType"
      />
    </template>

    <template #loader>
      <Loader :isLoading="isLoading" />
    </template>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/layouts/AdminLayout.vue'
import MainTable from '@/components/table/MainTable.vue'
import CreateModal from '@/components/common/modals/CreateModal.vue'
import ConfirmModal from '@/components/common/modals/ConfirmModal.vue'
import EditModal from '@/components/common/modals/EditModal.vue'
import CreateButton from '@/components/common/buttons/CreateButton.vue'
import ImageNotFound from '@/src/assets/img/empty-state-images/image-not-found.png'

import axios from 'axios'
import { ref, onMounted, defineEmits } from 'vue'
import Loader from '@/components/main/Loader.vue'
const VITE_BASE_URL = import.meta.env.VITE_BASE_URL
import { emitter, CLEAR_CREATE_LISTING_VALIDATION, UPDATE_LISTING_TABLE } from '@/event-bus.js'
import { useRouter } from 'vue-router'
import debounce from 'lodash/debounce'
const BASE_IMAGE_URL = import.meta.env.VITE_BASE_IMAGE_URL

const listingData = ref([])
const isLoading = ref(false)
const editListingId = ref(0)
const deleteListingId = ref({})
const emit = defineEmits(['clear-validation'])

const currentPage = ref(1)
const perPage = 10
const totalRows = ref(0)
const searchQuery = ref('')
const activeTab = ref('all')

onMounted(() => {
  setActiveTab('all')
  getTableData()
  emitter.on(UPDATE_LISTING_TABLE, getTableData)
})

const setActiveTab = (tab) => {
  activeTab.value = tab
}

const search = () => {
  console.log('Search query:', searchQuery.value)
}

const debouncedSearch = debounce(() => {
  console.log('hello', searchQuery.value)
  search()
}, 300)

const router = useRouter()

const handlePageChange = (page) => {
  currentPage.value = page
  getTableData()
}

const getTableData = async () => {
  isLoading.value = true
  try {
    const response = await axios.get(`${VITE_BASE_URL}api/v1/host/listing/admin/all/listing`)

    listingData.value = response.data.data
  } catch (error) {
    console.error('Error fetching listing data:', error)
  } finally {
    isLoading.value = false
  }
}

const filteredRows = (status) => {
  if (status == 3) {
    return listingData.value
  } else {
    return listingData.value.filter((row) => row.is_verfied === status)
  }
}

onMounted(() => {
  getTableData()
  emitter.on(UPDATE_LISTING_TABLE, getTableData)
})

const handleCreateListing = async () => {
  await getTableData()
}

const handleEditListing = async () => {
  await getTableData()
}

const handleDeleteType = async () => {
  await getTableData()
}

const editListing = (listing_id) => {
  try {
    router.push({ name: 'editListing', params: { listing_id } })
  } catch (error) {
    console.log('error', error)
  }
}

const tableHeaders = [
  // { label: 'HOST ID', key: 'unique_id', alignClass: 'text-left' },
  {
    label: 'Status',
    key: 'status',
    slotName: 'statusSlot',
    alignClass: 'text-center',
    header_position: 'center',
  },
  {
    label: 'Second Step Status',
    key: 'secound_step_status',
    slotName: 'secondStepStatus',
    alignClass: 'text-center',
    header_position: 'center',
  },
  {
    label: 'Third Step Status',
    key: 'third_step_status',
    slotName: 'thirdStepStatus',
    alignClass: 'text-center',
    header_position: 'center',
  },
  {
    label: 'Document Step Status',
    key: 'document_step_status',
    slotName: 'documentStepStatus',
    alignClass: 'text-center',
    header_position: 'center',
  },
  // {
  //   label: 'Rating',
  //   key: 'rating',
  //   slotName: 'ratingSlot',
  //   alignClass: 'text-center',
  //   header_position: 'center',
  // },
  { label: 'Title', key: 'title', alignClass: 'text-left' },
  // { label: 'Location', key: 'location', alignClass: 'text-left' },
  // { label: 'Price', key: 'price', alignClass: 'text-left' },
  { label: 'Category', key: 'category', alignClass: 'text-left' },
  { label: 'Listing Date', key: 'listed_date', alignClass: 'text-left' },
  {
    label: 'Cover Image',
    key: 'cover_image_url',
    slotName: 'coverImage',
    alignClass: 'text-center',
    header_position: 'center',
  },
]

const createModal = {
  title: 'Create New Listing',
  content: 'Please fill out the form to create a listing',
}

const editModal = {
  title: 'Edit Listing',
}

const deleteModal = {
  title: 'Delete Listing',
  content: 'Are you sure you want to delete this listing?',
}

const tableName = {
  name: 'Listing List',
}

const resetValidation = () => {
  emitter.emit(CLEAR_CREATE_LISTING_VALIDATION)
}
</script>
