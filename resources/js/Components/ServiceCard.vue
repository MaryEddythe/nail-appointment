<script setup>
defineProps({
  service: Object
})

const emit = defineEmits(['book'])
</script>

<template>
  <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
    <div class="p-6">
      <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ service.name }}</h3>
      <p class="text-gray-600 mb-4">{{ service.description }}</p>
      <div class="flex justify-between items-center">
        <span class="text-pink-600 font-bold">${{ service.price.toFixed(2) }}</span>
        <span class="text-gray-500">{{ service.duration }} min</span>
      </div>
    </div>
    <div class="bg-gray-50 px-6 py-4">
      <button 
        @click="emit('book', service.id)"
        class="w-full bg-pink-600 text-white py-2 px-4 rounded hover:bg-pink-700 transition-colors"
      >
        Book Now
      </button>
    </div>
  </div>
</template>