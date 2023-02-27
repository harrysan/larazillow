<template>
  <!-- if you want component accept additional style use oe single route element -->
  <div>
    <span class="font-bold">{{ listing.beds }}</span> bds <span class="text-gray-400">| </span>  
    <span class="font-bold">{{ listing.baths }}</span> ba <span
      class="text-gray-400"
    >| </span>
    <span class="font-bold">{{ listing.area }}</span> m²
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useMonthlyPayment } from '@/Composables/useMonthlyPayment'


defineProps({
  listing: Object,
})
</script>