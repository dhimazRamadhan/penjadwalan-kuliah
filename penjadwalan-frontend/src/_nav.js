
export default [
  // {
  //   component: 'CNavItem',
  //   name: 'Dashboard',
  //   to: '/dashboard',
  //   icon: 'cil-speedometer',
  //   badge: {
  //     color: 'primary',
  //     text: 'NEW',
  //   },
  // },
  {
    component: 'CNavTitle',
    name: 'Data',
  },
  {
    component: 'CNavItem',
    name: 'Dosen',
    to: '/data/dosen',
    icon: 'cil-people',
  },
  {
    component: 'CNavItem',
    name: 'Matakuliah',
    to: '/data/matakuliah',
    icon: 'cil-school',
  },
  {
    component: 'CNavItem',
    name: 'Pengampu',
    to: '/data/pengampu',
    icon: 'cil-file',
  },
  {
    component: 'CNavItem',
    name: 'Ruang',
    to: '/data/ruang',
    icon: 'cil-door',
  },
  {
    component: 'CNavItem',
    name: 'Jam',
    to: '/data/jam',
    icon: 'cil-clock',
  },
  {
    component: 'CNavItem',
    name: 'Hari',
    to: '/data/hari',
    icon: 'cil-sun',
  },
  {
    component: 'CNavItem',
    name: 'Waktu Tidak Bersedia',
    to: '/data/waktu_tidak_bersedia',
    icon: 'cil-ban',
  },
  //header
  {
    component: 'CNavTitle',
    name: 'Penjadwalan',
  },
  {
    component: 'CNavItem',
    name: 'Buat Jadwal',
    to: '/jadwal/jadwal',
    icon: 'cil-calendar',
  },
  {
    component: 'CNavItem',
    name: 'View Jadwal',
    to: '/jadwal/viewjadwal',
    icon: 'cil-calendar-check',
  },
  {
    component: 'CNavTitle',
    name: 'Lainya',
  },
  {
    component: 'CNavItem',
    name: 'Logout',
    to :'/pages/Login',
    icon: 'cil-account-logout',
  }

]
