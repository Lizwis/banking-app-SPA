import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/Home.vue'
import TransasctionsView from '../views/transactions.vue'


const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView
    },
    {
      path: '/transactions/:id',
      name: 'transactions',
      component: TransasctionsView
    },
  ]
})

export default router
