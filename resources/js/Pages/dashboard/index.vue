<template>
  <AppLayout>
    <template #content>
      <div class="row">
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4" v-for="card in cards" :key="card.title">
          <DashboardPrimaryCard
            :title="card.title"
            :value="card.value"
            :percentage="card.percentage"
            :subtitle="card.subtitle"
            :icon-class="card.iconClass"
            :percentage-class="card.percentageClass"
          />
        </div>
      </div>
    </template>

    <template #modals>
      <ConfirmModal :title="confirmModal.title" :content="confirmModal.content" />
    </template>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/layouts/AppLayout.vue'
import DashboardPrimaryCard from '@/components/cards/DashboardPrimaryCard.vue'
import ConfirmModal from '@/components/common/modals/ConfirmModal.vue'

const cards = [
  {
    title: "Today's Money",
    value: '$53,000',
    percentage: '+55%',
    subtitle: 'since yesterday',
    iconClass: 'ni ni-money-coins text-lg opacity-10',
  },
  {
    title: 'New Users',
    value: '2,300',
    percentage: '+5%',
    subtitle: 'since last week',
    iconClass: 'ni ni-money-coins text-lg opacity-10',
  },
  {
    title: 'Sales',
    value: '$103,000',
    percentage: '+10%',
    subtitle: 'since last month',
    iconClass: 'ni ni-cart text-lg opacity-10',
  },
  {
    title: 'Expenses',
    value: '$23,000',
    percentage: '-8%',
    subtitle: 'since yesterday',
    iconClass: 'ni ni-chart-bar-32 text-lg opacity-10',
    percentageClass: 'text-danger text-sm font-weight-bolder',
  },
]

const confirmModal = {
  title: 'Confirm Modal',
  content: 'Are you agree with terms & conditions',
}
</script>

<style scoped></style>
