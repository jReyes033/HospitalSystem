import { createRouter, createWebHashHistory } from 'vue-router'

const routes = [
  {
    path: '/login',
    name: 'login',
    component: () => import('../views/LoginView.vue')
  },
  {
    path: '/register',
    name: 'register',
    component: () => import('../views/RegisterView.vue')
  },
  {
    path: '/doctors',
    name: 'doctors',
    component: () => import('../views/DoctorView.vue'),
    meta: { requiresAuth: true }
  },
  // Add other protected routes here
]

const router = createRouter({
  history: createWebHashHistory(),
  routes
})

// Navigation Guard
router.beforeEach((to, from, next) => {
  const token = localStorage.getItem('token')
  if (to.matched.some(record => record.meta.requiresAuth) && !token) {
    next({ name: 'login' }) // Redirect to login if no token is found
  } else {
    next() // Proceed to route
  }
})

export default router
