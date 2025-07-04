<!-- resources/js/Pages/Book.vue -->
<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { ref, onMounted, computed } from 'vue'
import { router } from '@inertiajs/vue3'
import { format, parseISO, addMinutes } from 'date-fns'

const props = defineProps({
  services: Array,
  serviceId: String,
  availableSlots: Array,
  errors: Object
})

const selectedService = ref(props.serviceId || '')
const selectedDate = ref('')
const selectedTime = ref('')
const customerName = ref('')
const customerEmail = ref('')
const customerPhone = ref('')
const notes = ref('')
const availableSlots = ref(props.availableSlots || [])
const loadingSlots = ref(false)

const filteredServices = computed(() => {
  return props.services.filter(service => service.id == selectedService.value)
})

const fetchAvailableSlots = async () => {
  if (!selectedService.value || !selectedDate.value) return
  
  loadingSlots.value = true
  try {
    const response = await axios.get('/appointments/available-slots', {
      params: {
        service_id: selectedService.value,
        date: selectedDate.value
      }
    })
    availableSlots.value = response.data
  } catch (error) {
    console.error('Error fetching slots:', error)
  } finally {
    loadingSlots.value = false
  }
}

const submitAppointment = () => {
  const startTime = `${selectedDate.value} ${selectedTime.value}`
  
  router.post('/appointments', {
    customer_name: customerName.value,
    customer_email: customerEmail.value,
    customer_phone: customerPhone.value,
    start_time: startTime,
    service_id: selectedService.value,
    notes: notes.value
  })
}

onMounted(() => {
  if (selectedService.value && selectedDate.value) {
    fetchAvailableSlots()
  }
})
</script>

<template>
  <AppLayout>
    <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow">
      <h1 class="text-2xl font-bold text-gray-800 mb-6">Book Your Appointment</h1>
      
      <form @submit.prevent="submitAppointment">
        <div class="mb-4">
          <label class="block text-gray-700 mb-2" for="service">Service</label>
          <select
            id="service"
            v-model="selectedService"
            @change="fetchAvailableSlots"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-pink-500"
            required
          >
            <option value="">Select a service</option>
            <option v-for="service in services" :key="service.id" :value="service.id">
              {{ service.name }} ({{ service.duration }} min) - ${{ service.price.toFixed(2) }}
            </option>
          </select>
        </div>
        
        <div class="mb-4">
          <label class="block text-gray-700 mb-2" for="date">Date</label>
          <input
            type="date"
            id="date"
            v-model="selectedDate"
            @change="fetchAvailableSlots"
            :min="new Date().toISOString().split('T')[0]"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-pink-500"
            required
          />
        </div>
        
        <div class="mb-4" v-if="availableSlots.length > 0">
          <label class="block text-gray-700 mb-2">Available Time Slots</label>
          <div class="grid grid-cols-3 gap-2">
            <button
              v-for="slot in availableSlots"
              :key="slot"
              type="button"
              @click="selectedTime = slot.split(' ')[1]"
              :class="{
                'bg-pink-600 text-white': selectedTime === slot.split(' ')[1],
                'bg-gray-100 text-gray-800': selectedTime !== slot.split(' ')[1]
              }"
              class="py-2 px-3 rounded-md text-sm font-medium"
            >
              {{ slot.split(' ')[1].substring(0, 5) }}
            </button>
          </div>
        </div>
        
        <div v-else-if="loadingSlots" class="mb-4 text-center py-4">
          <p>Loading available slots...</p>
        </div>
        
        <div v-else-if="selectedService && selectedDate" class="mb-4 text-center py-4">
          <p>No available slots for this date. Please try another date.</p>
        </div>
        
        <div class="mb-4">
          <label class="block text-gray-700 mb-2" for="name">Your Name</label>
          <input
            type="text"
            id="name"
            v-model="customerName"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-pink-500"
            required
          />
        </div>
        
        <div class="mb-4">
          <label class="block text-gray-700 mb-2" for="email">Email</label>
          <input
            type="email"
            id="email"
            v-model="customerEmail"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-pink-500"
            required
          />
        </div>
        
        <div class="mb-4">
          <label class="block text-gray-700 mb-2" for="phone">Phone Number</label>
          <input
            type="tel"
            id="phone"
            v-model="customerPhone"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-pink-500"
            required
          />
        </div>
        
        <div class="mb-6">
          <label class="block text-gray-700 mb-2" for="notes">Additional Notes (Optional)</label>
          <textarea
            id="notes"
            v-model="notes"
            rows="3"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-pink-500"
          ></textarea>
        </div>
        
        <button
          type="submit"
          :disabled="!selectedTime"
          class="w-full bg-pink-600 text-white py-2 px-4 rounded-md hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:ring-offset-2 disabled:opacity-50"
        >
          Confirm Appointment
        </button>
      </form>
    </div>
  </AppLayout>
</template>