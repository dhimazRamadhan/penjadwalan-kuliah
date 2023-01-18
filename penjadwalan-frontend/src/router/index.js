import { createRouter, createWebHashHistory } from 'vue-router'
import { h, resolveComponent } from 'vue'

import DefaultLayout from '@/layouts/DefaultLayout'

const routes = [
  {
    path: '/',
    name: 'Home',
    component: DefaultLayout,
    redirect: '/dashboard',
    children: [
      {
        path: '/dashboard',
        name: 'Dashboard',
        // route level code-splitting
        // this generates a separate chunk (about.[hash].js) for this route
        // which is lazy-loaded when the route is visited.
        component: () =>
          import(/* webpackChunkName: "dashboard" */ '@/views/Dashboard.vue'),
      },
      {
        path: '/jadwal/jadwal',
        name: 'Jadwal',
        component: () => import('@/views/jadwal/jadwal.vue'),
      },
      {
        path: '/jadwal/viewjadwal',
        name: 'View Jadwal',
        component: () => import('@/views/jadwal/ViewJadwal.vue'),
      },
      {
        path: '/data/dosen',
        name: 'Dosen',
        component: () => import('@/views/data/Dosen.vue'),
      },
      {
        path: '/data/matakuliah',
        name: 'Matakuliah',
        component: () => import('@/views/data/Matakuliah.vue'),
      },
      {
        path: '/data/ruang',
        name: 'Ruang',
        component: () => import('@/views/data/Ruang.vue'),
      },
      {
        path: '/data/jam',
        name: 'Jam',
        component: () => import('@/views/data/Jam.vue'),
      },
      {
        path: '/data/hari',
        name: 'Hari',
        component: () => import('@/views/data/Hari.vue'),
      },
      {
        path: '/data/waktu_tidak_bersedia',
        name: 'Waktu Tidak Bersedia',
        component: () => import('@/views/data/WaktuTidakBersedia.vue'),
      },
      {
        path: '/data/pengampu',
        name: 'Pengampu',
        component: () => import('@/views/data/Pengampu.vue'),
      },
    ],
  },
  {
    path: '/pages',
    redirect: '/pages/404',
    name: 'Pages',
    component: {
      render() {
        return h(resolveComponent('router-view'))
      },
    },
    children: [
      {
        path: 'login',
        name: 'Login',
        component: () => import('@/views/auth/Login'),
      },
      {
        path: 'register',
        name: 'Register',
        component: () => import('@/views/auth/Register'),
      },
    ],
  },
]

const router = createRouter({
  history: createWebHashHistory(process.env.BASE_URL),
  routes,
  scrollBehavior() {
    // always scroll to top
    return { top: 0 }
  },
})

// router.beforeEach(async(to, from, next )=>{
//   if (to.meta.requireAuth) {
//     const auth = useAuth();
//     await auth.getUser()
//     if(auth.user){
//       next()
//     } else {
//       next({
//         name:'Login'
//       })
//     }
//   }

//   if(to.meta.authPage){
//     const auth = usuAuth()
//     await auth.getUser()
//     if(!auth.user){
//       next()
//     } else {
//       next(from)
//     }
//   }
// });

export default router
