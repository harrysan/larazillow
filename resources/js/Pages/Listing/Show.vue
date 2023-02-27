<template>
  <div class="mb-4">
    <Link 
      :href="route('listing.index')"
    >
      ← Go back to Listings
    </Link>
  </div>
  <div class="flex flex-col-reverse gap-4 md:grid md:grid-cols-12">
    <Box v-if="listing.images.length" class="flex items-center w-full md:col-span-7">
      <div class="grid grid-cols-2 gap-1">
        <img
          v-for="image in listing.images" :key="image.id"
          :src="image.src"
        />
      </div>
    </Box>

    <EmptyState v-else class="flex items-center md:col-span-7">No images</EmptyState>

    <div class="flex flex-col gap-4 md:col-span-5">
      <Box>
        <template #header>
          Basic info
        </template>
        <Price :price="listing.price" class="text-2xl font-bold" />
        <ListingSpace :listing="listing" class="text-lg" />
        <ListingAddress :listing="listing" class="text-gray-500" />
      </Box>

      <Box>
        <template #header>
          Monthly Payment
        </template>
        <div>
          <label class="label">Interest rate ({{ interestRate }})
          </label>
          <input v-model.number="interestRate" type="range" min="0.1" max="30" step="0.1" class="w-full h-4 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700" />

          <label class="label">Duration ({{ duration }} years)
          </label>
          <input v-model.number="duration" type="range" min="3" max="35" step="1" class="w-full h-4 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700" />

          <div class="mt-2 text-gray-600 dark:text-gray-300">
            <div class="text-gray-400">Your monthly payment</div>
            <Price :price="monthlyPayment" class="text-3xl" />
          </div>
          <div class="mt-2 text-gray-500">
            <div class="flex justify-between">
              <div>Total paid</div>
              <div>
                <Price :price="totalPaid" class="font-medium" />
              </div>
            </div>
            <div class="flex justify-between">
              <div>Principal paid</div>
              <div>
                <Price :price="listing.price" class="font-medium" />
              </div>
            </div>
            <div class="flex justify-between">
              <div>Interest paid</div>
              <div>
                <Price :price="totalInterest" class="font-medium" />
              </div>
            </div>
          </div>
        </div>
      </Box>

      <MakeOffer 
        v-if="user && !offerMade"
        :listing-id="listing.id"
        :price="listing.price" 
        @offer-updated="offer = $event"
      />
      <OfferMade v-if="user && offerMade" :offer="offerMade" />
    </div>
  </div>
</template>

<script setup>
import ListingAddress from '@/Components/ListingAddress.vue'
import ListingSpace from '@/Components/ListingSpace.vue'
import Price from '@/Components/Price.vue'
import Box from '@/Components/UI/Box.vue'
import { ref } from 'vue'
import { Link } from '@inertiajs/vue3'

import { useMonthlyPayment } from '@/Composables/useMonthlyPayment'
import MakeOffer from '@/Pages/listing/Show/Components/MakeOffer.vue'
import { usePage } from '@inertiajs/vue3'
import { computed } from 'vue'
import OfferMade from '@/Pages/Listing/Show/Components/OfferMade.vue'
import EmptyState from '@/Components/UI/EmptyState.vue'

const interestRate = ref(2.5)
const duration = ref(25)

const props = defineProps({
  listing: Object,
  offerMade: Object,
})

const offer = ref(props.listing.price)

const { monthlyPayment, totalPaid, totalInterest } =  useMonthlyPayment(offer, interestRate, duration)

// const monthlyPayment = computed(() => {
//   const principle = props.listing.price
//   const monthlyInterest = interestRate.value / 100 / 12
//   const numberOfPaymentMonths = duration.value * 12
  
//   return principle * monthlyInterest * (Math.pow(1 + monthlyInterest, numberOfPaymentMonths)) / (Math.pow(1 + monthlyInterest, numberOfPaymentMonths) - 1)
// })

const user = computed(() => usePage().props.user)
</script>