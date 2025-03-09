<template></template>

<script setup>
import Swal from 'sweetalert2'

const props = defineProps({
  alertTitle: { type: String, required: true },
})

const Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.onmouseenter = Swal.stopTimer
    toast.onmouseleave = Swal.resumeTimer
  },
})

function showToast(message, icon = 'success') {
  Toast.fire({
    icon: icon,
    title: message,
  })
}

showToast(props.alertTitle)
</script>
