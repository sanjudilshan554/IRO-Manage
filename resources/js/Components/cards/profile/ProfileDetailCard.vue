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
          <h5>{{ name }}</h5>
        </div>

        <!-- Details Section -->
        <div class="details mt-3">
          <div class="row mb-2"  >
            <div class="col-6 text-left"><i class="bi bi-circle pe-2"></i>SLBFE Reg No</div>
            <div class="col-6 text-right" v-if="email">{{ slbfe_reg_code }}</div>
            <div class="col-6 text-right" v-else> not configured </div>
          </div>
          <div class="row mb-2"  >
            <div class="col-6 text-left"><i class="bi bi-envelope pe-2"></i>Email</div>
            <div class="col-6 text-right" v-if="email">{{ email }}</div>
            <div class="col-6 text-right" v-else> not configured </div>
          </div>
          <div class="row mb-2" >
            <div class="col-6 text-left"><i class="bi bi-telephone pe-2"></i>Phone</div>
            <div class="col-6 text-right" v-if="phone">
                {{ phone }}
                <span v-if="phone_2">/ {{ phone_2 }}</span>
            </div>
            <div class="col-6 text-right" v-else> not configured </div>
          </div>
          <div class="row mb-2">
            <div class="col-6 text-left"><i class="bi bi-calendar pe-2"></i>Joined</div>
            <div class="col-6 text-right"  v-if="created_at">{{ formatDate(created_at) }}</div>
            <div class="col-6 text-right" v-else> not assigned </div>
          </div>
          <div class="row mb-2">
            <div class="col-6 text-left"><i class="bi bi-geo-alt-fill pe-2"></i>City</div>
            <div class="col-6 text-right" v-if="city">{{ city }}</div>
            <div class="col-6 text-right" v-else> not configured </div>
          </div>
          <div class="row mb-2">
            <div class="col-6 text-left"><i class="bi bi-cash pe-2"></i>Base Currency</div>
            <div class="col-6 text-right" v-if="currency">{{ currency }}</div>
            <div class="col-6 text-right" v-else> not configured </div>
          </div>
          <h6 class="text-center">{{ about_you }}</h6>
        </div>

        <hr class="horizontal dark" />

        <h6 class="text-left gray-6">Business Profile Status</h6>

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
import default_user from '@/src/assets/img/user-image/default_business2.png'
const BASE_IMAGE_URL = import.meta.env.VITE_BASE_IMAGE_URL

defineProps([ 'name', 'email', 'phone', 'phone_2', 'created_at', 'city', 'industry', 'slbfe_reg_code', 'currency'])

const formatDate = (date) => {
  const options = {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
  };
  return new Date(date).toLocaleString('en-US', options);
};
</script>

<style scoped>
.rounded-circle {
  box-shadow: 1px 5px 10px rgb(201, 198, 198);
}
</style>
