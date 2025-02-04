import { defineRouter } from '#q-app/wrappers'
import {
  createMemoryHistory,
  createRouter,
  createWebHashHistory,
  createWebHistory,
} from 'vue-router'
import routes from './routes'
import { useTokenStore } from 'src/stores/tokenStore'

/*
 * If not building with SSR mode, you can
 * directly export the Router instantiation;
 *
 * The function below can be async too; either use
 * async/await or return a Promise which resolves
 * with the Router instance.
 */

export default defineRouter(function (/* { store, ssrContext } */) {
  const createHistory = process.env.SERVER
    ? createMemoryHistory
    : process.env.VUE_ROUTER_MODE === 'history'
      ? createWebHistory
      : createWebHashHistory

  const Router = createRouter({
    scrollBehavior: () => ({ left: 0, top: 0 }),
    routes,

    // Leave this as is and make changes in quasar.conf.js instead!
    // quasar.conf.js -> build -> vueRouterMode
    // quasar.conf.js -> build -> publicPath
    history: createHistory(process.env.VUE_ROUTER_BASE),
  })

  Router.beforeEach((to, from, next) => {
    const tokenStore = useTokenStore() // Usa lo store per ottenere il token
    const token = tokenStore.token // Ottieni il token dal store

    // Se la route richiede autenticazione e non c'è il token, reindirizza al login
    if (to.meta.requiresAuth && token === '') {
      next({ path: '/login' }) // Assicurati che 'login' sia il nome della tua route di login
    } else {
      next() // Permetti l'accesso alla route
    }
  })

  return Router
})
