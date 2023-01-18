<template>
  <div class="bg-light min-vh-100 d-flex flex-row align-items-center">
    <CContainer>
      <CRow class="justify-content-center">
        <CCol :md="9" :lg="7" :xl="6">
          <CCard class="mx-4">
            <CCardBody class="p-4">
              <CForm @submit.prevent="register">
                <h1>Register</h1>
                <p class="text-medium-emphasis">Silahkan isi form untuk register!</p>
                <CInputGroup class="mb-3">
                  <CInputGroupText>
                    <CIcon icon="cil-user" />
                  </CInputGroupText>
                  <CFormInput placeholder="Username" autocomplete="username" v-model="user.name" />
                </CInputGroup>
                <CInputGroup class="mb-3">
                  <CInputGroupText>@</CInputGroupText>
                  <CFormInput placeholder="Email" autocomplete="email" v-model="user.email" />
                </CInputGroup>
                <CInputGroup class="mb-3">
                  <CInputGroupText>
                    <CIcon icon="cil-lock-locked" />
                  </CInputGroupText>
                  <CFormInput
                    type="password"
                    placeholder="Password"
                    autocomplete="new-password"
                    v-model="user.password"
                  />
                </CInputGroup>
                <CInputGroup class="mb-4">
                  <CInputGroupText>
                    <CIcon icon="cil-lock-locked" />
                  </CInputGroupText>
                  <CFormInput
                    type="password"
                    placeholder="Repeat password"
                    autocomplete="new-password"
                    v-model="user.password_confirmation"
                  />
                </CInputGroup>
                <div class="d-grid">
                  <CButton color="primary" type="submit">Create Account</CButton>
                </div>
                <div class="small text-medium-emphasis mt-1 align-items-lg-center">Sudah memiliki akun ? <router-link :to="{name: 'Login'}">Sign In</router-link></div>
              </CForm>
            </CCardBody>
          </CCard>
        </CCol>
      </CRow>
    </CContainer>
  </div>
</template>

<script>
  import { reactive, ref } from 'vue'
  import { useRouter } from 'vue-router'
  import axios from 'axios'

  export default {
    name: 'Register',
    setup(){
      const router = useRouter()
      const user = reactive({
          name: '',
          email: '',
          password: '',
          password_confirmation: ''
      })
      const validation = ref([])

      function register() {
        let name = user.name
        let email = user.email
        let password = user.password
        let password_confirmation = user.password_confirmation
        axios.post('http://localhost:8000/api/register', {
                name,
                email,
                password,
                password_confirmation
        })
        .then(() => {
            return router.push({
                name: 'Login'
            })
        }).catch(error => {
            validation.value = error.response.data
        })
      }
      return{
        user,
        validation,
        register
      }
    }
  }
</script>