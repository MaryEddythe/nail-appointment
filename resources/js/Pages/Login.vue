<!-- resources/js/Pages/Login.vue -->
<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'

const form = ref({
  email: '',
  password: '',
  remember: false
})

const submit = () => {
  router.post('/login', form.value, {
    onSuccess: () => {
      localStorage.setItem('auth_token', 'true') // In a real app, you'd store the actual token
      window.location.href = '/admin'
    }
  })
}
</script>

<template>
  <AppLayout>
    <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow">
      <h1 class="text-2xl font-bold text-gray-800 mb-6">Admin Login</h1>
      
      <form @submit.prevent="submit">
        <div class="mb-4">
          <label class="block text-gray-700 mb-2" for="email">Email</label>
          <input
            type="email"
            id="email"
            v-model="form.email"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-pink-500"
            required
          />
        </div>
        
        <div class="mb-4">
          <label class="block text-gray-700 mb-2" for="password">Password</label>
          <input
            type="password"
            id="password"
            v-model="form.password"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-pink-500"
            required
          />
        </div>
        
        <div class="mb-6 flex items-center">
          <input
            type="checkbox"
            id="remember"
            v-model="form.remember"
            class="h-4 w-4 text-pink-600 focus:ring-pink-500 border-gray-300 rounded"
          />
          <label for="remember" class="ml-2 block text-gray-700">Remember me</label>
        </div>
        
        <button
          type="submit"
          class="w-full bg-pink-600 text-white py-2 px-4 rounded-md hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:ring-offset-2"
        >
          Login
        </button>
      </form>
    </div>
  </AppLayout>
</template>