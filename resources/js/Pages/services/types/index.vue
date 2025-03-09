<template>
  <AdminLayout>
    <template #content>
      <div class="text-right justify-content-end d-flex">
        <CreateButton @click.prevent="resetValidation" />
      </div>
      <div class="card row mt-4">
        <div class="col-12">
          <div v-if="!isLoading">
            <MainTable
              :tableName="tableName"
              :headers="tableHeaders"
              :rows="typeData"
              showActions
              @page-change="handlePageChange"
            >
              <template #statusSlot="{ row }">
                <div class="text-center">
                  <h6 class="mb-0 text-sm text-center">
                    <div class="" v-if="row.status == 'active'">
                      <span class="badge bg-success">Active</span>
                    </div>
                    <div class="" v-else>
                      <span class="badge bg-danger">Inactive</span>
                    </div>
                  </h6>
                </div>
              </template>
              <template #actions="{ row }">
                <button
                  class="btn btn-link text-secondary mb-0 text-center"
                  @click.prevent="editType(row.id)"
                >
                  <i class="bi bi-pencil"></i>
                </button>

                <button
                  class="btn btn-link text-secondary mb-0 text-center"
                  @click.prevent="deleteType(row.id)"
                >
                  <i class="bi bi-trash text-danger"></i>
                </button>
              </template>
            </MainTable>
          </div>
        </div>
      </div>
    </template>

    <template #modals>
      <CreateModal :title="createModal.title" :formType="'type'" @create-type="handleCreateType" />

      <EditModal
        :title="editModal.title"
        :editId="editTypeId"
        :formType="'type'"
        @create-type="handleEditType"
      />

      <ConfirmModal
        :title="deleteModal.title"
        :deleteId="deleteTypeId"
        :content="deleteModal.content"
        :formType="'type'"
        @create-type="handleDeleteType"
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
import axios from 'axios'
import { ref, onMounted, defineEmits } from 'vue'
import Loader from '@/components/main/Loader.vue'
const VITE_BASE_URL = import.meta.env.VITE_BASE_URL
import { emitter, CLEAR_CREATE_TYPE_VALIDATION } from '@/event-bus.js'

const typeData = ref([])
const isLoading = ref(false)
const editTypeId = ref({})
const deleteTypeId = ref({})
const emit = defineEmits(['clear-validation'])

const handlePageChange = (page) => {
  currentPage.value = page
  getTableData()
}

const getTableData = async () => {
  isLoading.value = true
  try {
    const { data } = await axios.get(`${VITE_BASE_URL}api/v1/entity-types`)
    typeData.value = data.data
  } catch (error) {
    console.error('Error fetching task data:', error)
  } finally {
    isLoading.value = false
  }
}

const handleCreateType = async () => {
  await getTableData()
}

const handleEditType = async () => {
  await getTableData()
}

const handleDeleteType = async () => {
  await getTableData()
}

const editType = (id) => {
  try {
    $('#editModal').modal('show')
    editTypeId.value = id
  } catch (error) {
    console.log('error', error)
  }
}

const deleteType = (id) => {
  try {
    $('#confirmModal').modal('show')
    deleteTypeId.value = id
  } catch (error) {
    console.log('error', error)
  }
}

onMounted(() => {
  getTableData()
})

const tableHeaders = [
  { label: 'Status', key: 'status', slotName: 'statusSlot', alignClass: 'text-center' },
  { label: 'Name', key: 'name', alignClass: 'text-left' },
  { label: 'Description', key: 'description', alignClass: 'text-left' },
]

const createModal = {
  title: 'Create New Type',
  content: 'Please fill out the form to create a type',
}

const editModal = {
  title: 'Edit Type',
}

const deleteModal = {
  title: 'Delete Type',
  content: 'Are you sure you want to delete this type?',
}

const tableName = {
  name: 'Types table',
}

const resetValidation = () => {
  emitter.emit(CLEAR_CREATE_TYPE_VALIDATION)
}
</script>

<style scoped></style>
