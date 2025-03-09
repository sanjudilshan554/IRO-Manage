<template>
  <div class="card">
    <div class="card-body p-3">
      <div class="row">
        <div class="col-8">
          <div class="numbers">
            <p class="text-sm mb-0 text-uppercase font-weight-bold">{{ title }}</p>
            <h5 class="font-weight-bolder">{{ value }}</h5>
            <p class="mb-0">
              <span :class="percentageClass">{{ percentage }}</span>
              {{ subtitle }}
            </p>
          </div>
        </div>
        <div class="col-4 text-end">
          <div
            class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle"
          >
            <i :class="iconClass" aria-hidden="true"></i>
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
