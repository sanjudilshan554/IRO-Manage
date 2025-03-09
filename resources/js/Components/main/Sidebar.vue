<template>
    <aside
      :class="{ 'sidebar-open': sidebarOpen }"
      class="sidebar bg-white navbar navbar-vertical navbar-expand-xs border-0 my-0 fixed-start ms-0"
    >
      <div class="align-item-center justify-content-center d-flex pt-4 pb-4">
        <span class="font-weight-bold">IRO - Management</span>
      </div>

      <hr class="horizontal dark mt-0" />
      <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav">
          <li class="nav-item">

          </li>

          <li class="nav-item mt-3">
            <h6 class="ps-3 text-uppercase text-sm fw-bold opacity-8">Applications</h6>
          </li>

          <!-- Listing Dropdown -->
          <li class="nav-item mt-1">
            <a
              class="nav-link cursor-pointer"
              data-bs-toggle="collapse"
              href="#listingMenu"
              role="button"
              :aria-expanded="isCompanyActive()"
              :class="{ 'active': $page.url.startsWith('/company') }"
            >
              <div
                class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center"
              >
                <i class="bi bi-view-stacked text-primary text-lg opacity-10"></i>
              </div>
              <span class="nav-link-text ms-1 pt-1">Company</span>
            </a>
            <div class="collapse" id="listingMenu" :class="{ show: isCompanyActive() }">
              <ul class="nav flex-column ms-3">
                <li class="nav-item">
                  <router-link
                    to="/company"
                    class="nav-link cursor-pointer sub-link mt-1"
                    :class="{ 'active': $page.url.startsWith('/company') }"
                  >
                    <i class="bi bi-list text-primary text-lg opacity-10"></i>Company view
                  </router-link>
                </li>
              </ul>
            </div>
          </li>

          <li class="nav-item mt-3">
            <h6 class="ps-3 text-uppercase text-sm fw-bold opacity-8 mt-2">Account</h6>
          </li>
          <li class="nav-item">
            <!-- Sign In -->
            <div
              class="nav-link cursor-pointer d-flex align-items-center"
              @click.prevent="viewSignIn"
              v-if="!user"
            >
              <div
                class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center"
              >
                <i class="bi bi-person text-success text-lg opacity-10"></i>
              </div>
              <span class="nav-link-text">Sign In</span>
            </div>

            <!-- Logout -->
            <div
              class="nav-link cursor-pointer d-flex align-items-center"
              @click.prevent="viewLogoutModal"
              v-else
            >
              <div
                class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center"
              >
                <i class="bi bi-box-arrow-right text-danger text-lg opacity-10"></i>
              </div>
              <span class="nav-link-text">Logout</span>
            </div>
          </li>
        </ul>
      </div>
    </aside>

    <ConfirmModal :title="confirmModal.title" :content="confirmModal.content" :formType="formType" />
  </template>

  <script setup>
  import { useRoute } from 'vue-router'
  import { useRouter } from 'vue-router'
  import ConfirmModal from '@/components/common/modals/ConfirmModal.vue'

  const router = useRouter()
  const route = useRoute()

  const viewSignIn = () => {
    router.push({ name: 'login' })
  }
  const formType = 'logout'
  const user = localStorage.getItem('user')

  const viewLogoutModal = () => {
    $('#confirmModal').modal('show')
  }

  const confirmModal = {
    title: 'Confirm Modal',
    content: 'Are you sure you want to logout from the system?',
  }

  defineProps({
    sidebarOpen: {
      type: Boolean,
      required: true,
    },
  })

  // Check if route is available before accessing its properties
  const isActive = (path) => route?.path?.startsWith(path)

  const isCompanyActive = () => {
    return ['/company', '/company/create'].some((path) => route?.path?.startsWith(path))
  }
  </script>

  <style scoped>
  .active {
    background-color: rgb(231, 240, 255) !important;
  }

  .sub-link:hover {
    background-color: rgb(236, 244, 255) !important;
    border-radius: 10px !important;
  }
  .sidebar:hover {
    overflow-y: auto;
    scrollbar-width: thin;
    scrollbar-color: #c1c1c1 transparent;
  }

  .sidebar::-webkit-scrollbar {
    width: 2px;
  }

  .sidebar::-webkit-scrollbar-thumb:hover {
    background-color: #c1c1c1;
    border-radius: 3px;
  }

  .sidebar::-webkit-scrollbar-track {
    background: transparent;
  }

  .navbar-vertical.navbar-expand-xs .navbar-collapse {
    height: auto !important;
  }

  .nav-link:hover {
    background-color: rgb(234, 241, 255);
    border-radius: 10px;
  }
  </style>
