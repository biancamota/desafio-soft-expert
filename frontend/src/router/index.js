import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import middleware from '../services/middleware'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/sales',
      name: 'sales',
      component: HomeView,
      beforeEnter: middleware.auth
    },
    {
      path: '/',
      name: 'login',
      component: () => import('../views/LoginView.vue')
    },
    {
      path: '/:pathMatch(.*)*',
      name: 'NotFound',
      component: () => import('../views/NotFoundView.vue')
    },
    {
      path: '/products',
      name: 'products',
      component: () => import('../views/ProductsView.vue'),
      beforeEnter: middleware.auth
    }
  ]
})

export default router
