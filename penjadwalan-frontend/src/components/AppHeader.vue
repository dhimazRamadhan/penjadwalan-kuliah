<template>
  <CHeader position="sticky" class="mb-4">
    <CContainer fluid>
      <CHeaderToggler class="ps-1" @click="$store.commit('toggleSidebar')">
        <CIcon icon="cil-menu" size="lg" />
      </CHeaderToggler>
      <CHeaderBrand class="mx-auto d-lg-none" to="/">
        <CIcon :icon="logo" height="48" alt="Logo" />
      </CHeaderBrand>
      <CHeaderNav class="d-none d-md-flex me-auto">
        <!-- <CNavItem>
          <CNavLink href="/dashboard"> Dashboard </CNavLink>
        </CNavItem>
        <CNavItem>
          <CNavLink href="#">Users</CNavLink>
        </CNavItem>
        <CNavItem>
          <CNavLink href="#">Settings</CNavLink>
        </CNavItem> -->
      </CHeaderNav>
      <CHeaderNav>
        <!-- <CNavItem> -->
            <!-- <CButton type="submit" @click.prevent="logout">
              <CIcon class="mx-2" icon="cil-account-logout" size="lg" />
              
            </CButton>
            <p class="fs-6 text-muted -p-0">Logout</p>
        </CNavItem> -->
        <CNavItem>
          <!-- <CNavLink href="#">
            <CIcon class="mx-2" icon="cil-envelope-open" size="lg" />
          </CNavLink> -->
        </CNavItem>
        <!-- <AppHeaderDropdownAccnt /> -->
      </CHeaderNav>
    </CContainer>
    <CHeaderDivider />
    <CContainer fluid>
      <AppBreadcrumb />
    </CContainer>
  </CHeader>
</template>

<script>
import AppBreadcrumb from './AppBreadcrumb'
// import AppHeaderDropdownAccnt from './AppHeaderDropdownAccnt'
import { logo } from '@/assets/brand/logo'
import { useRouter } from 'vue-router'
import axios from 'axios'

export default {
  name: 'AppHeader',
  components: {
    AppBreadcrumb,
    // AppHeaderDropdownAccnt,
  },
  setup() {
    const token = localStorage.getItem('token')
    const router = useRouter()

    //method logout
    function logout() {
        axios.defaults.headers.common.Authorization = `Bearer ${token}`
        axios.post('http://localhost:8000/api/logout')
        .then(response => {
          if(response.data.success){
              //remove localStorage
              localStorage.removeItem('token')
              //redirect ke halaman login
              return router.push({
                  name : 'Login'
              })
          }
      })
      .catch(error => {
          console.log(error.response.data)
      })
    }
    return {
      logo,
      token,
      logout
    }
  },
}
</script>
