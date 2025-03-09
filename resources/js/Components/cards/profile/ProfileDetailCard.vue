<template>
  <div class="col-md-4">
    <div class="card card-profile">
      <div class="row justify-content-center mt-4">
        <div class="text-center col-4 col-lg-4 order-lg-2">
          <img
            v-if="image && image != 'storage/default/invalid.jpg'"
            :src="`${BASE_IMAGE_URL}${image}`"
            class="rounded-circle img-fluid border border-2 border-white"
          />
          <img
            v-else
            :src="default_user"
            class="rounded-circle img-fluid border border-2 border-white"
          />
        </div>
      </div>
      <div class="card-body pt-0">
        <!-- Header Section -->
        <div class="text-center mt-4">
          <h5>{{ first_name }} {{ last_name }}</h5>
        </div>

        <!-- Details Section -->
        <div class="details mt-3">
          <div class="row mb-2">
            <div class="col-6 text-left"><i class="bi bi-envelope pe-2"></i>Email</div>
            <div class="col-6 text-right">{{ email }}</div>
          </div>
          <div class="row mb-2">
            <div class="col-6 text-left"><i class="bi bi-telephone pe-2"></i>Mobile</div>
            <div class="col-6 text-right">{{ mobile_number }}</div>
          </div>

          <div class="row mb-2">
            <div class="col-6 text-left"><i class="bi bi-translate pe-2"></i>Speaks</div>
            <div class="col-6 text-right">
              {{ Array.isArray(language) ? language.join(', ') : language }}
            </div>
          </div>

          <div class="row mb-2">
            <div class="col-6 text-left"><i class="bi bi-calendar pe-2"></i>Joined</div>
            <div class="col-6 text-right">{{ joined_date }}</div>
          </div>
          <div class="row mb-2">
            <div class="col-6 text-left"><i class="bi bi-geo-alt-fill pe-2"></i>Lives in</div>
            <div class="col-6 text-right">{{ address?.city }}</div>
          </div>

          <h6 class="text-center">{{ about_you }}</h6>
        </div>

        <hr class="horizontal dark" />

        <h6 class="text-left gray-6">Host Confirmed Information</h6>

        <!-- Verification Section -->
        <div class="details mt-3 text-left">
          <div class="row mb-2">
            <div class="col-1 text-left">
              <i class="bi bi-check-circle-fill text-success" v-if="id_verification_verfied"></i>
              <i class="bi bi-check-circle-fill" v-else></i>
            </div>
            <div class="col-6 text-left">identity</div>
          </div>
          <div class="row mb-2">
            <div class="col-1 text-left">
              <i class="bi bi-check-circle-fill text-success" v-if="email_verified"></i>
              <i class="bi bi-check-circle-fill" v-else></i>
            </div>
            <div class="col-6 text-left">Email Address</div>
          </div>
          <div class="row mb-2">
            <div class="col-1 text-left">
              <i class="bi bi-check-circle-fill text-success" v-if="mobile_number_verfied"></i>
              <i class="bi bi-check-circle-fill" v-else></i>
            </div>
            <div class="col-6 text-left">Phone Number</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import default_user from '@/src/assets/img/user-image/default_user.png'
const BASE_IMAGE_URL = import.meta.env.VITE_BASE_IMAGE_URL
defineProps({
  user_name: { type: String, required: true },
  first_name: { type: String, required: true },
  last_name: { type: String, required: true },
  email: { type: String, required: true },
  image: { type: String, required: true },
  language: { type: String, required: true },
  mobile_number: { type: String, required: true },
  address: { type: String, required: true },
  language: { type: String, required: true },
  joined_date: { type: String, required: true },
  unique_id: { type: String, required: true },
  status: { type: String, required: true },
  about_you: { type: String, required: true },

  email_verified: { type: String, required: true },
  id_verification_verfied: { type: String, required: true },
  mobile_number_verfied: { type: String, required: true },
})
</script>

<style scoped>
.rounded-circle {
  box-shadow: 1px 5px 10px rgb(201, 198, 198);
}
</style>
