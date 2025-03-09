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
            <!-- Tab panel for state filtering -->
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
                    All Hosts
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
                  :headers="tableHeaders"
                  :rows="filteredRows(3)"
                  :totalRows="filteredRows(3).length"
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
                      @click.prevent="editHost(row.id)"
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
                  :rows="filteredRows(0)"
                  :totalRows="filteredRows(0).length"
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
                      @click.prevent="editHost(row.id)"
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
                  :rows="filteredRows(1)"
                  :totalRows="filteredRows(1).length"
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
                      @click.prevent="editHost(row.id)"
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
      <CreateModal :title="createModal.title" :formType="'host'" @create-host="handleCreateType" />
      <EditModal
        :title="editModal.title"
        :editId="editHostId"
        :formType="'host'"
        @edit-host="handleEditHost"
      />
      <ConfirmModal
        :title="deleteModal.title"
        :deleteId="deleteHostId"
        :content="deleteModal.content"
        :formType="'host'"
        @create-host="handleDeleteType"
      />
    </template>

    <template #loader>
      <Loader :isLoading="isLoading" />
    </template>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '../../layouts/AppLayout.vue'
import MainTable from '@/Components/table/MainTable.vue'
import CreateModal from '@/Components/common/modals/CreateModal.vue'
import ConfirmModal from '@/Components/common/modals/ConfirmModal.vue'
import EditModal from '@/Components/common/modals/EditModal.vue'
import CreateButton from '@/Components/common/buttons/CreateButton.vue'
import axios from 'axios'
import { ref, onMounted, defineEmits } from 'vue'
import Loader from '@/components/main/Loader.vue'
const VITE_BASE_URL = import.meta.env.VITE_BASE_URL
import { emitter, CLEAR_CREATE_HOST_VALIDATION, UPDATE_HOST_TABLE } from '@/event-bus.js'
import { useRouter } from 'vue-router'
import debounce from 'lodash/debounce'

const hostData = ref([])
const isLoading = ref(false)
const editHostId = ref(0)
const deleteHostId = ref({})
const emit = defineEmits(['clear-validation'])

const currentPage = ref(1)
const perPage = 10
const totalRows = ref(0)
const searchQuery = ref('')
const activeTab = ref('all')

onMounted(() => {
  setActiveTab('all')
  getTableData()
  emitter.on(UPDATE_HOST_TABLE, getTableData)
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
    const response = await axios.get(`${VITE_BASE_URL}api/v1/host/admin/details/all`, {
      params: { page: currentPage.value, per_page: perPage },
    })
    hostData.value = response.data.data.data
    totalRows.value = response.data.data.total
  } catch (error) {
    console.error('Error fetching host data:', error)
  } finally {
    isLoading.value = false
  }
}

const filteredRows = (status) => {
  if (status == 3) {
    return hostData.value
  } else {
    return hostData.value.filter((row) => row.is_verfied === status)
  }
}

onMounted(() => {
  getTableData()
  emitter.on(UPDATE_HOST_TABLE, getTableData)
})

const handleCreateType = async () => {
  await getTableData()
}

const handleEditHost = async () => {
  await getTableData()
}

const handleDeleteType = async () => {
  await getTableData()
}

const editHost = (host_id) => {
  try {
    router.push({ name: 'editHost', params: { host_id } })
  } catch (error) {
    console.log('error', error)
  }
}

const tableHeaders = [
  { label: 'Unique ID', key: 'unique_id', alignClass: 'text-left' },
  {
    label: 'Status',
    key: 'status',
    slotName: 'statusSlot',
    alignClass: 'text-center',
    header_position: 'center',
  },
  {
    label: 'Is Verified',
    key: 'is_verfied',
    slotName: 'isVerifiedSlot',
    alignClass: 'text-center',
    header_position: 'center',
  },
  { label: 'First Name', key: 'first_name', alignClass: 'text-left' },
  { label: 'Last Name', key: 'last_name', alignClass: 'text-left' },
  { label: 'Email', key: 'email', alignClass: 'text-left' },
  { label: 'Mobile', key: 'mobile_number', alignClass: 'text-left' },
  { label: 'REG Type', key: 'register_type', alignClass: 'text-left' },
]

const createModal = {
  title: 'Create New Host',
  content: 'Please fill out the form to create a host',
}

const editModal = {
  title: 'Edit Host',
}

const deleteModal = {
  title: 'Delete Host',
  content: 'Are you sure you want to delete this host?',
}

const tableName = {
  name: 'Host List',
}

const resetValidation = () => {
  emitter.emit(CLEAR_CREATE_HOST_VALIDATION)
}
</script>
