<template>
  <form action="">
    <div class="flex flex-wrap gap-2 mt-4 mb-4">
      <div class="flex items-center gap-4 flex-nowrap">
        <input id="deleted" v-model="filterForm.deleted" type="checkbox" class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500" />
        <label for="deleted">Deleted</label>
      </div>

      <div>
        <select v-model="filterForm.by" class="w-24 input-filter-l">
          <option value="created_at">Added</option>
          <option value="price">Price</option>
        </select>
        <select v-model="filterForm.order" class="w-32 input-filter-r">
          <option
            v-for="option in sortOptions" 
            :key="option.value" :value="option.value"
          >
            {{ option.label }}
          </option>
        </select>
      </div>
    </div>
  </form>
</template>

<script setup>
import { reactive,watch,computed } from 'vue'
import { Inertia } from '@inertiajs/inertia'
import { debounce } from 'lodash'

const sortLabels = {
  created_at: [
    {
      label: 'Latest',
      value: 'desc',
    },
    {
      label: 'Oldest',
      value: 'asc',
    },
  ],
  price: [
    {
      label: 'Pricey',
      value: 'desc',
    },
    {
      label: 'Cheapest',
      value: 'asc',
    },
  ],
}

const sortOptions = computed(() => sortLabels[filterForm.by])

const props = defineProps({ 
  filters:Object,
})

const filterForm = reactive({
  deleted: props.filters.deleted ?? false,
  by: props.filters.by ?? 'created_at',
  order: props.filters.order ?? 'desc',
})

// watch(
//   filterForm, (newValue, oldValue) => console.log(newValue,oldValue),
// )

watch(
  filterForm, debounce(() => Inertia.get(
    route('realtor.listing.index'),
    filterForm,
    { preserveState: true, preserveScroll: true },
  ), 1000),
)

// reactice / ref / computed

// if multiple value and want to get old value
// watch(
//   [() => filterForm.deleted, () => filterForm.xxx], (newValue, oldValue) => console.log(newValue,oldValue),
// )
</script>
