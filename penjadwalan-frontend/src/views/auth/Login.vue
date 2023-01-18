<template>
  <div class="bg-light min-vh-100 d-flex flex-row align-items-center">
    <CContainer>
      <CRow class="justify-content-center">
        <CCol :md="8">
          <div v-if="loginFailed" class="alert alert-danger">
                Email atau password anda salah.
          </div>
          <CCardGroup>
            <CCard class="p-4">
              <CCardBody>
                <CForm @submit.prevent="login">
                  <h1>Sign In</h1>
                  <p class="text-medium-emphasis">Silahkan isi form untuk login!</p>
                  <CInputGroup class="mb-3">
                    <CInputGroupText>
                      <CIcon icon="cil-user" />
                    </CInputGroupText>
                    <CFormInput v-model="user.email"
                      placeholder="Email"
                      autocomplete="email"
                      required
                    />
                  </CInputGroup>
                  <CInputGroup class="mb-4">
                    <CInputGroupText>
                      <CIcon icon="cil-lock-locked" />
                    </CInputGroupText>
                    <CFormInput v-model="user.password"
                      type="password"
                      placeholder="Password"
                      autocomplete="current-password"
                      required
                    />
                  </CInputGroup>
                  <CRow>
                    <CCol :xs="6">
                      <CButton color="primary" class="px-4" type="submit"> Login </CButton>
                    </CCol>
                  </CRow>
                </CForm>
              </CCardBody>
            </CCard>
            <CCard class="text-white bg-primary py-5" style="width: 44%">
              <CCardBody class="text-center">
                <div>
                  <h2>Sign Up</h2>
                  <p>
                    SIlahkan register terlebih dahulu untuk menjalankan aplikasi penjadwalan, jika anda tidak mempunyai akun.
                  </p>
                  <router-link :to="{name: 'Register'}">
                  <CButton color="light" variant="outline" class="mt-3">
                    Register Now!
                  </CButton>
                </router-link>
                </div>
              </CCardBody>
            </CCard>
          </CCardGroup>
        </CCol>
      </CRow>
    </CContainer>
  </div>
</template>

<script>
  import { reactive, ref, onMounted } from 'vue'
  import { useRouter } from 'vue-router'
  import axios from 'axios'
  import Swal from 'sweetalert2'
  
  export default {
      name: 'Login',
      
      setup(){
      const router = useRouter()
      const user = reactive({
          email: '',
          password: '',
      })
      const validation = ref([])
      const loginFailed = ref(null)
      const token = localStorage.getItem('token')

      onMounted(() =>{
        if(token) {
          axios.defaults.headers.common.Authorization = `Bearer ${token}`
          axios.post('http://localhost:8000/api/logout')
          .then(response => {
          if(response.data.success){
            //remove localStorage
            localStorage.removeItem('token')
            Swal.fire(
              'Berhasil!',
              'Berhasil Logout.',
              'success'
              )
            } 
          })
        }
      })

      function login() {
        let email = user.email
        let password = user.password

        axios.post('http://localhost:8000/api/login', {
        email,
        password,
        })

        .then(response => {
        if(response.data.success){
            localStorage.setItem('token', response.data.token)
            return router.push({
            name: "Dashboard"
            })
        }
        loginFailed.value = true
        })
          .catch(error => {
            validation.value = error.response.data
          })
        }
        return{
          user,
          validation,
          loginFailed,
          login
        }
      }
  }
</script>