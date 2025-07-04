<script setup>
import { Head, Link } from '@inertiajs/vue3'
import NavBar from '@/Components/NavBar.vue'
</script>

<template>
  <Head title="Nail Appointment Booking" />
  
  <div class="min-h-screen bg-gray-50">
    <NavBar />
    
    <main class="container mx-auto py-8 px-4">
      <slot />
    </main>
  </div>
</template>