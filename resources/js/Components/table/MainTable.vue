<template>
  <div class="mb-4">
    <div class="pb-0">
      <!-- <h5>{{ tableName.name }}</h5> -->
    </div>
    <div class="px-0 pt-0 pb-2">
      <div class="table-responsive d-none d-md-block">
        <table class="table mb-0">
          <thead>
            <tr>
              <th
                :style="{
                  textAlign: header.header_position + ' !important',
                  fontSize: '1rem',
                  padding: '8px 16px 8px 16px' + '!important',
                }"
                v-for="(header, index) in headers"
                :key="index"
                :class="[
                  'text-uppercase text-secondary text-sm font-weight-bolder opacity-7  ',
                  header.alignClass,
                ]"
              >
                {{ header.label }}
              </th>
              <th v-if="showActions"></th>
            </tr>
          </thead>

          <tbody v-if="rows.length > 0">
            <tr v-for="(row, rowIndex) in rows" :key="rowIndex" class="table-row-cursor">
              <td
                v-for="(header, colIndex) in headers"
                :key="colIndex"
                :class="[' ', header.alignClass]"
              >
                <div v-if="header.slotName" :class="['py-0 ps-2', header.alignClass]">
                  <slot :name="header.slotName" :row="row" />
                </div>
                <span v-else :class="['py-0 p-3', header.alignClass]">{{ row[header.key] }}</span>
              </td>
              <td v-if="showActions" class="text-center">
                <slot name="actions" :row="row" />
              </td>
            </tr>
          </tbody>

          <tbody v-else>
            <tr>
              <td colspan="100%" class="text-center">
                <div>
                  <!-- Animated Image -->
                  <img
                    :src="tableEmptyState"
                    alt="No Data"
                    width="200"
                    class="mx-auto d-block mt-5"
                  />

                  <!-- Text -->
                  <h4 class="mt-3 text-muted pb-5 text-center">No data available!</h4>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Mobile View -->
      <div class="d-block d-md-none">
        <div v-if="rows.length > 0">
          <div v-for="(row, index) in rows" :key="index" class="border rounded p-3 mb-2">
            <div v-for="(header, colIndex) in headers" :key="colIndex" class="row py-0">
              <div class="col-4 left-side text-uppercase text-sm text-secondary fw-bold">
                {{ header.label }}
              </div>

              <div
                class="col-8 text-end d-flex align-items-center justify-content-end text-sm right-side"
              >
                <span v-if="!header.slotName && !header.isBadge && !header.isImage">
                  {{ row[header.key] }}
                </span>
                <slot v-else :name="header.slotName" :row="row" />
              </div>
            </div>

            <div v-if="showActions" class="row py-0">
              <div class="col-4 left-side text-sm text-secondary fw-bold"></div>
              <div class="col-8 text-end text-sm right-side">
                <slot name="actions" :row="row" />
              </div>
            </div>
          </div>
        </div>

        <!-- Empty State -->
        <div v-else class="text-center">
          <img :src="tableEmptyState" alt="No Data" width="200" />
          <h4 class="mt-3 text-muted">No data available!</h4>
        </div>
      </div>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-3" v-if="rows.length > 0 && totalRows > 0">
      <nav aria-label="Page navigation">
        <ul class="pagination">
          <li class="page-item" :class="{ disabled: currentPage === 1 }">
            <button
              class="page-link text-secondary"
              @click="goToPage(currentPage - 1)"
              aria-label="Previous"
            >
              <span aria-hidden="true">&laquo;</span>
            </button>
          </li>

          <li
            class="page-item"
            v-for="page in totalPages"
            :key="page"
            :class="{ active: currentPage === page }"
          >
            <button class="page-link" @click="goToPage(page)">{{ page }}</button>
          </li>

          <li class="page-item" :class="{ disabled: currentPage === totalPages }">
            <button
              class="page-link text-secondary"
              @click="goToPage(currentPage + 1)"
              aria-label="Next"
            >
              <span aria-hidden="true">&raquo;</span>
            </button>
          </li>
        </ul>
      </nav>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useRouter } from 'vue-router'
import tableEmptyState from '@/src/assets/img/empty-state-images/empty-state-3.gif'

const props = defineProps({
  tableName: { type: Object, required: true },
  headers: { type: Array, required: true, default: () => [] },
  rows: { type: Array, required: true, default: () => [] },
  showActions: { type: Boolean, default: false },
  totalRows: { type: Number, required: true, default: 0 },
  perPage: { type: Number, default: 10 },
  currentPage: { type: Number, default: 1 },
})

const emit = defineEmits(['page-change'])

const goToPage = (page) => {
  if (page >= 1 && page <= totalPages.value) {
    emit('page-change', page)
  }
}

const totalPages = computed(() => Math.ceil(props.totalRows / props.perPage))

const router = useRouter()
</script>

<style scoped>
table {
  border-collapse: collapse !important;
}

td {
  padding: 0 !important;
}

.table th,
.table td {
  padding-right: 10px !important;
  text-align: left !important;
  vertical-align: middle !important;
}

.table td {
  font-size: 0.875rem !important;
}

.left-side {
  background-color: rgb(245, 245, 245);
  color: white;
  font-weight: bold;
  padding: 5px 10px;
  white-space: normal;
}

.right-side {
  background-color: rgb(250, 250, 250);
  color: rgb(126, 121, 121);
  padding: 5px 10px;
  white-space: normal;
}
</style>
