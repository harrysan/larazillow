<template>
  <!-- <Link href="/listing">Listings</Link>&nbsp;
  <Link href="/listing/create">New Listing</Link> -->
  <!-- <div>The page with time {{ timer }}</div> -->

  <header class="w-full bg-white border-b border-gray-200 dark:border-gray-700 dark:bg-gray-900">
    <div class="container mx-auto">
      <nav class="flex items-center justify-between p-4">
        <div class="text-lg font-medium">
          <Link :href="route('listing.index')">Listings</Link>
        </div>
        <div class="text-xl font-bold text-center text-indigo-600 dark:text-indigo-300">
          <Link :href="route('listing.index')">LaraZillow</Link>
        </div>
        <div v-if="user" class="flex items-center gap-4">
          <Link
            class="relative py-2 pr-2 text-lg text-gray-500"
            :href="route('notification.index')"
          >
            🔔
            <div v-if="notificationCount" class="absolute top-0 right-0 w-5 h-5 text-xs font-medium text-center text-white bg-red-700 border border-white rounded-full dark:bg-red-400 dark:border-gray-900">
              {{ notificationCount }}
            </div>
          </Link>

          <Link class="text-sm text-gray-500" :href="route('realtor.listing.index')">{{ user.name }}</Link>
          
          <Link :href="route('realtor.listing.create')" class="btn-primary">+ New Listing</Link>
          <div>
            <Link :href="route('logout')">Logout</Link>
          </div>
        </div>
        <div v-else class="flex items-center gap-2">
          <Link :href="route('user-account.create')">Register</Link>
          <Link :href="route('login')">Sign-In</Link>
        </div>
      </nav>
    </div>
  </header>

  <main class="container w-full p-4 mx-auto">
    <div v-if="flashSuccess" class="p-2 mb-4 border border-green-200 rounded-md shadow-sm dark:border-green-800 bg-green-50 dark:bg-green-900">
      {{ flashSuccess }}
    </div>
    <slot>Default</slot>
  </main>
</template>

<script setup>
import { Link, usePage } from '@inertiajs/vue3'
import { computed } from 'vue'
// import { ref } from 'vue'

const page = usePage()

// page.props.value.flash.success
// const page = usePage()
// const flashSuccess = computed(() => page.props.flash.success)
const flashSuccess = computed(() => usePage().props.flash.success )

const user = computed(() => usePage().props.user)

// const timer = ref(0)
// setInterval(() => timer.value++, 1000)

const notificationCount = computed(
  () => Math.min(usePage().props.user.notificationCount, 9),
)
</script>
