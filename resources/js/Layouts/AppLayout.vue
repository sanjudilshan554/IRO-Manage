<template>
    <div class="g-sidenav-show bg-gray-100 d-flex flex-column min-vh-100 bg-image">
      <!-- Sidebar -->
      <Sidebar :sidebar-open="sidebarOpen" @toggle-sidebar="toggleSidebar" />

      <!-- Main Content -->
      <main
        class="main-content position-relative border-radius-lg flex-grow-1"
        :class="{ 'content-expanded': sidebarOpen }"
      >
        <Navbar @toggle-sidebar="toggleSidebar" />
        <div class="container-fluid py-4">
          <slot name="content" />

          <slot name="modals" />

          <slot name="loader" />
        </div>
      </main>
      <Footer />
    </div>
  </template>

  <script setup>
  import { ref } from 'vue'
  import Footer from '@/Components/main/Footer.vue'
  import Navbar from '@/Components/main/Navbar.vue'
  import Sidebar from '@/Components/main/Sidebar.vue'

  const sidebarOpen = ref(false)

  const toggleSidebar = () => {
    sidebarOpen.value = !sidebarOpen.value
  }
  </script>

  <style scoped>
  .content-expanded {
    margin-left: 250px;
  }

  @media (max-width: 768px) {
    .content-expanded {
      margin-left: 0;
    }
  }

  .bg-image {
    width: 100%;
    background-image: url('@/src/assets/img/background/background.png');
    background-size: cover;
    background-position: center;
  }
  </style>
