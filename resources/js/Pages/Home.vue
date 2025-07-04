<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import ServiceCard from '@/Components/ServiceCard.vue'
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'

const props = defineProps({
  services: Array
})

const bookService = (serviceId) => {
  router.visit(`/book?service=${serviceId}`)
}
</script>

<template>
  <AppLayout>
    <div class="text-center mb-8">
      <h1 class="text-3xl font-bold text-gray-900 mb-2">Welcome to Our Nail Salon</h1>
      <p class="text-gray-600">Book your perfect nail appointment with ease</p>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <ServiceCard 
        v-for="service in services" 
        :key="service.id" 
        :service="service"
        @book="bookService(service.id)"
      />
    </div>
  </AppLayout>
</template>