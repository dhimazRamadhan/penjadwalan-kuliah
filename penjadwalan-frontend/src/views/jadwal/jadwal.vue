<template>
  <div>
    <CRow>
      <CCol :md="16">
        <CCard class="mb-4">
          <CCardBody>
            <CRow>
              <CCol :sm="5">
                <h4 id="traffic" class="card-title mb-0">Jadwal</h4>
              </CCol>
              <CCol :sm="7" class="d-none d-md-block">
              </CCol>
            </CRow>
            <CForm @submit.prevent="generate">
              <CRow class="mt-3 form-group">
                <CCol :sm="3">
                  <CFormSelect v-model="input.semester" size="sm" class="mb-3 form-control">
                    <option class="small text-medium-emphasis">Semester</option>
                    <option value="0">Genap</option>
                    <option value="1">Ganjil</option>
                  </CFormSelect>
                  <div v-if="validation.semester" class="alert alert-danger">
                    {{validation.jenis[0]}}
                  </div>
                </CCol>
                <CCol :sm="3" class="d-none d-md-block">
                  <CFormSelect v-model="input.tahun_akademik" size="sm" class="mb-3 form-control">
                    <option class="small text-medium-emphasis">Tahun Akademik</option>
                    <option value="2011-2012">2011 - 2012</option>
                    <option value="2012-2013">2012 - 2013</option>
                  </CFormSelect>
                  <div v-if="validation.tahun_akademik" class="alert alert-danger">
                    {{validation.jenis[0]}}
                  </div>
                </CCol>
                <CCol :sm="2" class="d-none d-md-block">
                  <CButton color="primary" type="submit">
                    Buat Jadwal
                    <CIcon icon="cil-calendar" class="ms-2"/>
                  </CButton>
                </CCol>
              </CRow>
            </CForm>
            <CRow>
              <div style="margin-top: 40px">
                <CTable>
                  <CTableHead>
                    <CTableRow>
                      <CTableHeaderCell scope="col">Hari</CTableHeaderCell>
                      <CTableHeaderCell scope="col">Sesi</CTableHeaderCell>
                      <CTableHeaderCell scope="col">Jam</CTableHeaderCell>
                      <CTableHeaderCell scope="col">Mata Kuliah</CTableHeaderCell>
                      <CTableHeaderCell scope="col">SKS</CTableHeaderCell>
                      <CTableHeaderCell scope="col">Semester</CTableHeaderCell>
                      <CTableHeaderCell scope="col">Kelas</CTableHeaderCell>
                      <CTableHeaderCell scope="col">Dosen</CTableHeaderCell>
                      <CTableHeaderCell scope="col">Ruang</CTableHeaderCell>
                    </CTableRow>
                  </CTableHead>
                  <CTableBody>
                    <CTableRow v-for="(data, index) in jadwal" :key="index">
                      <CTableDataCell>{{ data.hari }}</CTableDataCell>
                      <CTableDataCell>{{ data.sesi }}</CTableDataCell>
                      <CTableDataCell>{{ data.jam_kuliah }}</CTableDataCell>
                      <CTableDataCell>{{ data.nama_mk }}</CTableDataCell>
                      <CTableDataCell>{{ data.sks }}</CTableDataCell>
                      <CTableDataCell>{{ data.semester }}</CTableDataCell>
                      <CTableDataCell>{{ data.kelas }}</CTableDataCell>
                      <CTableDataCell>{{ data.dosen }}</CTableDataCell>
                      <CTableDataCell>{{ data.ruang }}</CTableDataCell>
                    </CTableRow>
                  </CTableBody>
                </CTable>
              </div>          
            </CRow>
          </CCardBody>
          <!-- <CCardFooter>
            <CRow :xs="{ cols: 1 }" :md="{ cols: 5 }" class="text-center">
              <CCol class="mb-sm-2 mb-0">
                <div class="text-medium-emphasis">Visits</div>
                <strong>29.703 Users (40%)</strong>
                <CProgress
                  class="mt-2"
                  color="success"
                  thin
                  :precision="1"
                  :value="40"
                />
              </CCol>
              <CCol class="mb-sm-2 mb-0 d-md-down-none">
                <div class="text-medium-emphasis">Unique</div>
                <strong>24.093 Users (20%)</strong>
                <CProgress
                  class="mt-2"
                  color="info"
                  thin
                  :precision="1"
                  :value="20"
                />
              </CCol>
              <CCol class="mb-sm-2 mb-0">
                <div class="text-medium-emphasis">Pageviews</div>
                <strong>78.706 Views (60%)</strong>
                <CProgress
                  class="mt-2"
                  color="warning"
                  thin
                  :precision="1"
                  :value="60"
                />
              </CCol>
              <CCol class="mb-sm-2 mb-0">
                <div class="text-medium-emphasis">New Users</div>
                <strong>22.123 Users (80%)</strong>
                <CProgress
                  class="mt-2"
                  color="danger"
                  thin
                  :precision="1"
                  :value="80"
                />
              </CCol>
              <CCol class="mb-sm-2 mb-0 d-md-down-none">
                <div class="text-medium-emphasis">Bounce Rate</div>
                <strong>Average Rate (40.15%)</strong>
                <CProgress class="mt-2" :value="40" thin :precision="1" />
              </CCol>
            </CRow>
          </CCardFooter> -->
        </CCard>
      </CCol>
    </CRow>
  </div>
</template>

<script>
    import { onMounted,reactive, ref } from 'vue'
    import { useRouter } from 'vue-router'
    import axios from 'axios'
    import Swal from 'sweetalert2'
    

export default {
  name: 'Jadwal',  
  setup(){
    const token = localStorage.getItem('token')
    const router = useRouter()
    const input = reactive({
            semester: '',
            tahun_akademik: ''
        })
    const validation = ref([])
    let jadwal = ref([]) 

    onMounted(() =>{
            if(!token) {
                return router.push({
                name: 'Login'
                })
            }
            axios.defaults.headers.common.Authorization = `Bearer ${token}`
            axios.get('http://localhost:8000/api/getjadwal')
            .then(response => {
           //assign state posts with response data
            jadwal.value = response.data.data         
            }).catch(error => {
                console.log(error.response.data)
            })
        })
        
    function generate(){
      let semester = input.semester
      let tahun_akademik = input.tahun_akademik

      axios.defaults.headers.common.Authorization = `Bearer ${token}`
      axios.post('http://localhost:8000/api/penjadwalan', {
            semester: semester,
            tahun_akademik: tahun_akademik
        })
        .then(() => {   
            Swal.fire(
              'Berhasil!',
              'Jadwal berhasil dibuat.',
              'success'
            )      
        window.location.reload();
        })
        .catch(error => {
          Swal.fire(
            'Gagal!',
            'Tidak Ada Data Semester Atau Tahun Akademik Yang Sesuai.',
            'error'
          )
          //assign state validation with error 
          validation.value = error.response.data
        })
      }
    
    //return
    return{
      jadwal,
      input,
      validation,
      token,
      router,
      generate,
    }
  }
}
</script>
