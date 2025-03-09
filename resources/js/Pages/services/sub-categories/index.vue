<template>
  <AdminLayout>
    <template #content>
      <div class="text-right justify-content-end d-flex">
        <CreateButton @click.prevent="resetValidation" />
      </div>
      <div class="row mt-4">
        <div class="col-12 p-0 m-0">
          <div v-if="!isLoading" class="card">
            <div class="row ps-3 pt-3">
              <div class="ps-3">
                <h6>{{ tableName.name }}</h6>
              </div>
              <div class="col-8 col-md-3">
                <input
                  type="text"
                  class="form-control"
                  placeholder="Search Name, Description, Category"
                />
              </div>
              <div class="col-4 col-md-9">
                <button class="btn btn-primary"><i class="bi bi-eraser-fill"></i></button>
              </div>
            </div>

            <MainTable
              :tableName="tableName"
              :headers="tableHeaders"
              :rows="subCategoryData"
              showActions
              @page-change="handlePageChange"
            >
              <template #statusSlot="{ row }">
                <div class="text-center">
                  <h6 class="mb-0 text-sm text-center">
                    <div class="" v-if="row.status == 1">
                      <span class="badge bg-success">Success</span>
                    </div>
                    <div class="" v-else>
                      <span class="badge bg-danger">Pending</span>
                    </div>
                  </h6>
                </div>
              </template>
            </MainTable>
          </div>
        </div>
      </div>
    </template>

    <template #modals>
      <CreateModal
        :title="createModal.title"
        :formType="'sub-category'"
        @create-category="handleCreateCategory"
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
import CreateButton from '@/components/common/buttons/CreateButton.vue'
import axios from 'axios'
import { ref, onMounted } from 'vue'
import Loader from '@/components/main/Loader.vue'
import { emitter, CLEAR_CREATE_SUB_CATEGORY_VALIDATION } from '@/event-bus.js'

const subCategoryData = ref([])
const isLoading = ref(false)

const handlePageChange = (page) => {
  currentPage.value = page
  getTableData()
}

const VITE_BASE_URL = import.meta.env.VITE_BASE_URL

const getTableData = async () => {
  isLoading.value = true
  try {
    const { data } = await axios.get(`${VITE_BASE_URL}api/v1/sub-categories`)
    subCategoryData.value = data.data
  } catch (error) {
    console.error('Error fetching task data:', error)
  } finally {
    isLoading.value = false
  }
}

const handleCreateCategory = async () => {
  await getTableData()
}
onMounted(() => {
  getTableData()
})

const tableHeaders = [
  {
    label: 'Status',
    key: 'status',
    slotName: 'statusSlot',
    alignClass: 'text-center',
    header_position: 'center',
  },
  { label: 'Name', key: 'name', alignClass: 'text-left' },
  { label: 'Description', key: 'description', alignClass: 'text-left' },
  { label: 'Category', key: 'category_name', alignClass: 'text-left' },
]

const createModal = {
  title: 'Create New Sub Category',
  content: 'Please fill out the form to create a category',
}

const tableName = {
  name: 'Sub Category List',
}

const resetValidation = () => {
  emitter.emit(CLEAR_CREATE_SUB_CATEGORY_VALIDATION)
}
</script>
