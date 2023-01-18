<!-- <template>
  <div>
  <CRow>
      <CCol :md="16">
      <CCard class="mb-4">
          <CCardBody>

            <CRow>
              
            </CRow>
          </CCardBody>
      </CCard>
      </CCol>
  </CRow>
  </div>
</template>

<script>
import { onMounted, ref } from 'vue'
import { useRouter } from 'vue-router'
import axios from 'axios'

export default {
  name: 'Dashboard',
  
  setup(){
  let data = ref([]) 
  let countDosen = ref([]) 
  const token = localStorage.getItem('token')
  const router = useRouter()
  onMounted(() =>{
          if(!token) {
              return router.push({
              name: 'Login'
              })
          }
          axios.defaults.headers.common.Authorization = `Bearer ${token}`
          axios.get('http://localhost:8000/api/jam')
          .then(response => {
          //assign state posts with response data
          data.value = response.data.data         
          }).catch(error => {
              console.log(error.response.data)
          })
        get()
      })

  function get(){
    axios.defaults.headers.common.Authorization = `Bearer ${token}`
    axios.get('http://localhost:8000/api/dosen')
    .then(response => {
    //assign state posts with response data
    data.value = response.data.data   
    countDosen = response.data.count
    console.log(countDosen)      
    }).catch(error => {
        console.log(error.response.data)
    })
  }
  
  return{
      data,
      token,
      router,
      countDosen,
      get
  }
      
  }
}
</script>
   -->