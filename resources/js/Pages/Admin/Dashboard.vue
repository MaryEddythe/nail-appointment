<!-- resources/js/Pages/Admin/Dashboard.vue -->
<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { ref, onMounted } from 'vue'
import { router } from '@inertiajs/vue3'

const props = defineProps({
  appointments: Array,
  services: Array
})

const newService = ref({
  name: '',
  description: '',
  duration: '',
  price: ''
})

const addService = async () => {
  try {
    await axios.post('/services', newService.value)
    router.reload()
    newService.value = { name: '', description: '', duration: '', price: '' }
  } catch (error) {
    console.error('Error adding service:', error)
  }
}
</script>

<template>
  <AppLayout>
    <div class="space-y-8">
      <!-- Appointments Section -->
      <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Upcoming Appointments</h2>
        
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date & Time</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="appointment in appointments" :key="appointment.id">
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm font-medium text-gray-900">{{ appointment.customer_name }}</div>
                  <div class="text-sm text-gray-500">{{ appointment.customer_email }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-gray-900">{{ appointment.service?.name }}</div>
                  <div class="text-sm text-gray-500">${{ appointment.service?.price.toFixed(2) }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-gray-900">
                    {{ new Date(appointment.start_time).toLocaleDateString() }}
                  </div>
                  <div class="text-sm text-gray-500">
                    {{ new Date(appointment.start_time).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }) }} - 
                    {{ new Date(appointment.end_time).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }) }}
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                    {{ appointment.status }}
                  </span>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      
      <!-- Services Management -->
      <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Manage Services</h2>
        
        <div class="mb-6">
          <h3 class="text-lg font-medium text-gray-800 mb-2">Add New Service</h3>
          <form @submit.prevent="addService" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
              <input v-model="newService.name" type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md" required>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
              <input v-model="newService.description" type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md" required>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Duration (min)</label>
              <input v-model="newService.duration" type="number" min="1" class="w-full px-3 py-2 border border-gray-300 rounded-md" required>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Price ($)</label>
              <input v-model="newService.price" type="number" min="0" step="0.01" class="w-full px-3 py-2 border border-gray-300 rounded-md" required>
            </div>
            <div class="md:col-span-4">
              <button type="submit" class="bg-pink-600 text-white py-2 px-4 rounded-md hover:bg-pink-700">
                Add Service
              </button>
            </div>
          </form>
        </div>
        
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Duration</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="service in services" :key="service.id">
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ service.name }}</td>
                <td class="px-6 py-4 text-sm text-gray-500">{{ service.description }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ service.duration }} min</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${{ service.price.toFixed(2) }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                  <button class="text-pink-600 hover:text-pink-900 mr-3">Edit</button>
                  <button class="text-red-600 hover:text-red-900">Delete</button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </AppLayout>
</template>