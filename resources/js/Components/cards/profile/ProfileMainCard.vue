<template>
  <div class="col-md-8">
    <div class="card">
      <!-- Top Cards Section -->
      <div class="d-flex flex-wrap justify-content-between p-3">
        <div class="card m-2 flex-grow-1" v-for="card in cards" :key="card.title">
          <ProfileCard
            :title="card.title"
            :value="card.value"
            :percentage="card.percentage"
            :subtitle="card.subtitle"
            :icon-class="card.iconClass"
            :percentage-class="card.percentageClass"
          />
        </div>
      </div>
      <!-- End of Top Cards Section -->
      <div class="card-header pb-0">
        <div class="d-flex align-items-center">
          <p class="mb-0">Edit Profile</p>
          <!-- <button class="btn btn-primary btn-sm ms-auto">Settings</button> -->
        </div>
      </div>
      <div class="card-body">
        <p class="text-uppercase text-sm">User Information</p>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="example-text-input" class="form-control-label">Mobile Number</label>
              <input class="form-control" type="text" value="lucky.jesse" />
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="example-text-input" class="form-control-label">Email address</label>
              <input class="form-control" type="email" value="jesse@example.com" />
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="example-text-input" class="form-control-label">First name</label>
              <input class="form-control" type="text" value="Jesse" />
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="example-text-input" class="form-control-label">Last name</label>
              <input class="form-control" type="text" value="Lucky" />
            </div>
          </div>
        </div>
        <hr class="horizontal dark" />
        <p class="text-uppercase text-sm">Contact Information</p>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="example-text-input" class="form-control-label">Address</label>
              <input
                class="form-control"
                type="text"
                value="Bld Mihail Kogalniceanu, nr. 8 Bl 1, Sc 1, Ap 09"
              />
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="example-text-input" class="form-control-label">City</label>
              <input class="form-control" type="text" value="New York" />
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="example-text-input" class="form-control-label">Country</label>
              <input class="form-control" type="text" value="United States" />
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="example-text-input" class="form-control-label">Postal code</label>
              <input class="form-control" type="text" value="437300" />
            </div>
          </div>
        </div>
        <hr class="horizontal dark" />
        <p class="text-uppercase text-sm">About host</p>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="example-text-input" class="form-control-label">About host</label>
              <input class="form-control" type="text" value="Hi." />
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
defineProps({
  title: { type: String, required: true },
  value: { type: String, required: true },
  percentage: { type: String, required: true },
  subtitle: { type: String, required: true },
  iconClass: { type: String, required: true },
  percentageClass: { type: String, default: 'text-success text-sm font-weight-bolder' },
})
</script>
