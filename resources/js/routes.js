// resources/js/routes.js
import { createRouter } from '@inertiajs/vue3'

export default createRouter([
  {
    path: '/',
    component: () => import('./Pages/Home.vue'),
    name: 'home',
    props: route => ({
      services: route.data.services
    })
  },
  {
    path: '/book',
    component: () => import('./Pages/Book.vue'),
    name: 'book',
    props: route => ({
      services: route.data.services,
      serviceId: route.query.service,
      availableSlots: route.data.availableSlots,
      errors: route.data.errors
    })
  },
  {
    path: '/login',
    component: () => import('./Pages/Login.vue'),
    name: 'login'
  },
  {
    path: '/admin',
    component: () => import('./Pages/Admin/Dashboard.vue'),
    name: 'admin.dashboard',
    props: route => ({
      appointments: route.data.appointments,
      services: route.data.services
    })
  }
])