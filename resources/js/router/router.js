import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

import CategoriesPage from '../pages/CategoriesPage'
import CategoryProductsPage from '../pages/CategoryProductsPage'
import CartPage from '../pages/CartPage'
import ProfilePage from '../pages/ProfilePage'
import LoginPage from '../pages/auth/LoginPage'
import RegisterPage from '../pages/auth/RegisterPage'

const Component404 = { template: '<div>СТРАНИЦА НЕ НАЙДЕНА</div>' }

const routes = [
    { path: '*', component: Component404 },
    { path: '/', component: CategoriesPage },
    { path: '/category/:id', component: CategoryProductsPage },
    { path: '/cart', component: CartPage },
    { path: '/profile', component: ProfilePage },
    { path: '/auth/login', component: LoginPage },
    { path: '/auth/register', component: RegisterPage },
  ]

const router = new VueRouter({
  mode: 'history',
  routes
})

export default router