<script setup>
import { Link } from '@inertiajs/vue3'
import { HomeIcon, CalendarIcon, CogIcon } from '@heroicons/vue/24/outline'
</script>

<template>
  <nav class="bg-white shadow">
    <div class="container mx-auto px-4 py-3 flex justify-between items-center">
      <Link href="/" class="text-xl font-bold text-pink-600">Nail Salon</Link>
      
      <div class="flex space-x-4">
        <Link href="/" class="flex items-center space-x-1 text-gray-700 hover:text-pink-600">
          <HomeIcon class="h-5 w-5" />
          <span>Home</span>
        </Link>
        <Link href="/book" class="flex items-center space-x-1 text-gray-700 hover:text-pink-600">
          <CalendarIcon class="h-5 w-5" />
          <span>Book Appointment</span>
        </Link>
        <Link v-if="$page.props.auth.user" href="/admin" class="flex items-center space-x-1 text-gray-700 hover:text-pink-600">
          <CogIcon class="h-5 w-5" />
          <span>Admin</span>
        </Link>
        <Link v-if="!$page.props.auth.user" href="/login" class="text-gray-700 hover:text-pink-600">Login</Link>
      </div>
    </div>
  </nav>
</template>