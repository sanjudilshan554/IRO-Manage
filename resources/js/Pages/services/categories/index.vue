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
                  placeholder="Search Type, Name, Description"
                />
              </div>
              <div class="col-4 col-md-9">
                <button class="btn btn-primary"><i class="bi bi-eraser-fill"></i></button>
              </div>
            </div>

            <MainTable
              :tableName="tableName"
              :headers="tableHeaders"
              :rows="categoryData"
              showActions
              @page-change="handlePageChange"
            >
              <template #statusSlot="{ row }">
                <div class="text-center">
                  <h6 class="mb-0 text-sm text-center">
                    <div class="" v-if="row.status == 'active'">
                      <span class="badge bg-success">Success</span>
                    </div>
                    <div class="" v-else>
                      <span class="badge bg-danger">Pending</span>
                    </div>
                  </h6>
                </div>
              </template>

              <template #imageSlot="{ row }">
                <div class="image-text-container p-1">
                  <div class="table-image-container">
                    <img :src="row.image" alt="Perfect Square Image" />
                  </div>
                </div>
              </template>

              <template>
                <button class="btn btn-link text-secondary mb-0 text-center">
                  <i class="bi bi-pencil"></i>
                </button>
              </template>
            </MainTable>
          </div>
        </div>
      </div>
    </template>

    <template #modals>
      <CreateModal
        :title="createModal.title"
        :formType="'category'"
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
const VITE_BASE_URL = import.meta.env.VITE_BASE_URL
import { emitter, CLEAR_CREATE_CATEGORY_VALIDATION } from '@/event-bus.js'

const categoryData = ref([])
const isLoading = ref(false)

const handlePageChange = (page) => {
  currentPage.value = page
  getTableData()
}

const getTableData = async () => {
  isLoading.value = true
  try {
    const { data } = await axios.get(`${VITE_BASE_URL}api/v1/categories`)
    categoryData.value = data.data
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
  { label: 'Type', key: 'type_name', alignClass: 'text-left' },
  { label: 'Name', key: 'name', alignClass: 'text-left' },
  { label: 'Description', key: 'description', alignClass: 'text-left' },
  {
    label: 'Image',
    key: 'image',
    slotName: 'imageSlot',
    alignClass: 'text-center',
    header_position: 'center',
  },
]

const createModal = {
  title: 'Create New Category',
  content: 'Please fill out the form to create a category',
}

const tableName = {
  name: 'Category List',
}

const resetValidation = () => {
  emitter.emit(CLEAR_CREATE_CATEGORY_VALIDATION)
}
</script>
