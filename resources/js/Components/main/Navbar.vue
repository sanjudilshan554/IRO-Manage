<template>
  <nav class="navbar navbar-expand-lg navbar-main shadow-none bg-dark pe-0" id="navbarBlur">
    <div class="container-fluid py-1 px-3">
      <!-- <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
          <li class="breadcrumb-item text-sm">
            <a class="opacity-5 text-white" href="javascript:;">Pages</a>
          </li>
          <li class="breadcrumb-item text-sm text-white active" aria-current="page">Dashboard</li>
        </ol>
        <h6 class="font-weight-bolder text-white mb-0">Dashboard</h6>
      </nav> -->

      <!-- Navbar items -->
      <div
        class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4 justify-content-end"
        id="navbar"
      >
        <ul class="navbar-nav justify-content-end">
          <!-- Sign In Button -->
          <li class="nav-item d-flex align-items-center">
            <a href="javascript:;" class="nav-link text-white font-weight-bold px-3">
              <i class="fa fa-user me-sm-1"></i>

              <span>
  <Link class="text-white" :href="route('profile.edit')">Profile</Link>
</span>


              <span class="d-sm-inline d-none" @click.prevent="viewSignIn" v-if="!user"
                >Sign In</span
              >
              <span class="d-sm-inline d-none" @click.prevent="viewLogoutModal" v-else>Logout</span>


            </a>
          </li>

          <!-- Hamburger icon for mobile -->
          <a
            href="javascript:;"
            class="nav-link text-white d-md-none align-items-center d-flex"
            @click="$emit('toggle-sidebar')"
          >
            <div class="sidenav-toggler-inner">
              <i class="sidenav-toggler-line bg-white"></i>
              <i class="sidenav-toggler-line bg-white"></i>
              <i class="sidenav-toggler-line bg-white"></i>
            </div>
          </a>
        </ul>
      </div>
    </div>
  </nav>

  <ConfirmModal :title="confirmModal.title" :content="confirmModal.content" :formType="formType" />
  <!-- End Navbar -->
</template>

<script setup>
import { useRouter } from 'vue-router'
import ConfirmModal from '@/components/common/modals/ConfirmModal.vue'
import { Link } from '@inertiajs/vue3'

const router = useRouter()


// const viewSignIn = () => {
//   router.push({ name: 'login' })
// }
const formType = 'logout'
const user = localStorage.getItem('user')

const viewLogoutModal = () => {
  $('#confirmModal').modal('show')
}

const confirmModal = {
  title: 'Confirm Modal',
  content: 'Are you sure you want to logout from the system?',
}
</script>
