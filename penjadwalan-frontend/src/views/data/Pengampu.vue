<template>
    <div>
    <CRow>
        <CCol :md="16">
        <CCard class="mb-4">
            <CCardBody>
            <CRow>
                <CCol :sm="5">
                <h4 id="traffic" class="card-title mb-0">Data Pengampu</h4>
                </CCol>
                <CCol :sm="7" class="d-none d-md-block">
                <CButton color="primary" class="float-end" @click="() => { visibleLiveDemoCreate = true }">
                    Tambah Data <CIcon icon="cil-plus" />
                </CButton>
                </CCol>
            </CRow>
            <CRow>
                <div style="margin-top: 40px">
                <CTable>
                    <CTableHead>
                    <CTableRow>
                        <CTableHeaderCell scope="col">Kode</CTableHeaderCell>
                        <CTableHeaderCell scope="col">Matakuliah</CTableHeaderCell>
                        <CTableHeaderCell scope="col">Dosen</CTableHeaderCell>
                        <CTableHeaderCell scope="col">Kelas</CTableHeaderCell>
                        <CTableHeaderCell scope="col">Tahun Akadmik</CTableHeaderCell>
                        <CTableHeaderCell scope="col" style="color:blue">Edit</CTableHeaderCell>
                        <CTableHeaderCell scope="col" style="color:red">Delete</CTableHeaderCell>
                    </CTableRow>
                    </CTableHead>
                    <CTableBody>
                    <CTableRow v-for="(data, index) in data" :key="index">
                        <CTableDataCell>{{ data.kode }}</CTableDataCell>
                        <CTableDataCell>{{ data.matakuliah }}</CTableDataCell>
                        <CTableDataCell>{{ data.dosen }}</CTableDataCell>
                        <CTableDataCell>{{ data.kelas }}</CTableDataCell>
                        <CTableDataCell>{{ data.tahun_akademik }}</CTableDataCell>
                        <CTableDataCell>
                            <CButton class="me-2" @click.prevent="editForm(data.kode)">
                                <CIcon icon="cil-pencil" style="color:blue" />
                            </CButton>
                        </CTableDataCell>
                        <CTableDataCell>
                            <CButton @click="dataDelete(data.kode)">
                                <CIcon icon="cil-trash" style="color:red" />
                            </CButton>
                        </CTableDataCell>
                    </CTableRow>
                    </CTableBody>
                </CTable>
                </div>          
            </CRow>
            </CCardBody>
        </CCard>
        </CCol>
    </CRow>
    </div>

    <!-- modal -->
    <CModal :visible="visibleLiveDemoCreate" @close="() => { visibleLiveDemoCreate = false }">
        <CModalHeader>      
        <CModalTitle>Tambah Pengampu</CModalTitle>
        </CModalHeader>
        <CModalBody>
            <CForm class="row g-3" @submit.prevent="create">
                <CCol md="12">
                    <CFormLabel for="nama">Matakuliah</CFormLabel>
                    <CFormSelect v-model="post.kode_mk" >
                        <option></option>
                        <option v-for="(matakuliah, index) in matakuliah" :key="index" :value="matakuliah.kode">{{matakuliah.nama}} ( {{matakuliah.kode}} )</option>
                    </CFormSelect>
                </CCol>
                <CCol md="12">
                    <CFormLabel for="nama">Dosen</CFormLabel>
                    <CFormSelect v-model="post.kode_dosen" >
                        <option></option>
                        <option v-for="(dosen, index) in dosen" :key="index" :value="dosen.kode">{{dosen.nama}} ( {{dosen.kode}} )</option>
                    </CFormSelect>
                </CCol>
                <CCol md="12">
                    <CFormLabel for="nama">Kelas</CFormLabel>
                    <CFormInput id="alamat" v-model="post.kelas" required placeholder=""/>
                </CCol>
                <CCol md="12">
                    <CFormLabel for="inputState">Tahun Akademik</CFormLabel>
                    <CFormInput id="telp" v-model="post.tahun_akademik" required placeholder=""/>
                </CCol>
                <CCol xs="12" class="float-end mt-4">
                    <CButton  color="primary" type="submit" class="ms-2 float-end">Simpan</CButton>
                    <CButton class="float-end" color="secondary" @click="() => { visibleLiveDemoCreata = false }">
                        Kembali
                    </CButton>
                </CCol>  
            </CForm>
            </CModalBody>
    </CModal>

    <!-- modal edit -->
    <CModal :visible="visibleLiveDemoEdit" @close="() => { visibleLiveDemoEdit = false }">
        <CModalHeader>      
        <CModalTitle>Edit Pengampu</CModalTitle>
        </CModalHeader>
        <CModalBody>
            <CForm class="row g-3" @submit.prevent="submitEdit">
                <CCol md="12" style="display:none">
                    <CFormLabel for="nama">kode</CFormLabel>
                    <CFormInput  v-model="edit.kode" required  />
                </CCol>
                <CCol md="12">
                    <CFormLabel for="Matakuliah">Matakuliah</CFormLabel>
                    <CFormSelect v-model="edit.kode_mk">
                        <option></option>
                        <option v-for="(matakuliah, index) in matakuliah" :key="index" :value="matakuliah.kode">{{matakuliah.nama}} ( {{matakuliah.kode}} )</option>
                    </CFormSelect>
                </CCol>
                <CCol md="12">
                    <CFormLabel for="nama">Dosen</CFormLabel>
                    <CFormSelect v-model="edit.kode_dosen" >
                        <option v-for="(dosen, index) in dosen" :key="index" :value="dosen.kode">{{dosen.nama}} ( {{dosen.kode}} )</option>
                    </CFormSelect>
                </CCol>
                <CCol md="12">
                    <CFormLabel for="nama">Kelas</CFormLabel>
                    <CFormInput id="alamat" v-model="edit.kelas" required placeholder=""/>
                </CCol>
                <CCol md="12">
                    <CFormLabel for="inputState">Tahun Akademik</CFormLabel>
                    <CFormInput id="telp" v-model="edit.tahun_akademik" required placeholder=""/>
                </CCol>
                <CCol xs="12" class="float-end mt-4">
                    <CButton  color="primary" type="submit" class="ms-2 float-end">Simpan</CButton>
                    <CButton class="float-end" color="secondary" @click="() => { visibleLiveDemoEdit = false }">
                        Kembali
                    </CButton>
                </CCol>  
            </CForm>
            </CModalBody>
    </CModal>
</template>

<script>
import { onMounted, ref, reactive } from 'vue'
import { useRouter } from 'vue-router'
import axios from 'axios'
import Swal from 'sweetalert2'

export default {
    name: 'Pengampu',
    
    setup(){
        let data = ref([]) 
        let dosen = ref([]) 
        let matakuliah = ref([]) 
        const token = localStorage.getItem('token')
        const router = useRouter()
        const visibleLiveDemoCreate = ref(false)
        const visibleLiveDemoEdit = ref(false)
        const validation = ref([])
        const post = reactive({
            kode_mk: '',
            kode_dosen: '',
            kelas: '',
            tahun_akademik: ''
        })
        const edit = reactive({
            kode: '',
            kode_mk: '',
            kode_dosen: '',
            kelas: '',
            tahun_akademik: ''
        })
        onMounted(() =>{
            if(!token) {
                return router.push({
                name: 'Login'
                })
            }
            get()       
        })

        function get(){
            axios.defaults.headers.common.Authorization = `Bearer ${token}`
            axios.get('http://localhost:8000/api/pengampu')
            .then(response => {
            //assign state posts with response data
            data.value = response.data.data         
            }).catch(error => {
                console.log(error.response.data)
            })

            axios.defaults.headers.common.Authorization = `Bearer ${token}`
            axios.get('http://localhost:8000/api/dosen')
            .then(response => {
            //assign state posts with response data
            dosen.value = response.data.data         
            }).catch(error => {
                console.log(error.response.data)
            })

            axios.defaults.headers.common.Authorization = `Bearer ${token}`
            axios.get('http://localhost:8000/api/matakuliah')
            .then(response => {
            //assign state posts with response data
            matakuliah.value = response.data.data         
            }).catch(error => {
                console.log(error.response.data)
            })
        }

        function create(){
            let kode_mk         = post.kode_mk
            let kode_dosen      = post.kode_dosen
            let kelas           = post.kelas
            let tahun_akademik  = post.tahun_akademik

            axios.defaults.headers.common.Authorization = `Bearer ${token}`
            axios.post('http://localhost:8000/api/pengampu' , {
                kode_mk: kode_mk,
                kode_dosen: kode_dosen,
                kelas: kelas,
                tahun_akademik: tahun_akademik
            })
            .then(() => {
                Swal.fire(
                    'Berhasil!',
                    'Data berhasil dibuat.',
                    'success'
                )
                .then(() => { 
                    this.visibleLiveDemoCreate = false 
                })           
                get()
            }).catch(error => {
                validation.value = error.response.data
            })
        }

        function submitEdit(){
            let kode     = edit.kode
            let kode_mk  = edit.kode_mk
            let kode_dosen     = edit.kode_dosen
            let kelas      = edit.kelas
            let tahun_akademik = edit.tahun_akademik

            console.log(kode)
            console.log(kode_mk)
            console.log(kode_dosen)
            console.log(kelas)
            console.log(tahun_akademik)
            axios.defaults.headers.common.Authorization = `Bearer ${token}`
            axios.put(`http://localhost:8000/api/pengampu/${kode}`, {
                kode_mk: kode_mk,
                kode_dosen: kode_dosen,
                kelas: kelas,
                tahun_akademik: tahun_akademik,
            }).then(() => {
                Swal.fire(
                    'Berhasil!',
                    'Data berhasil diupdate.',
                    'success'
                    )
                    .then(() => { this.visibleLiveDemoEdit = false })
                    get()
                }).catch(error => {
                validation.value = error.response.data
            })
        }

        function editForm(kode){
            console.log(kode)
            axios.defaults.headers.common.Authorization = `Bearer ${token}`
            axios.get(`http://localhost:8000/api/pengampu/${kode}`) 
            .then(response => {      
                edit.kode            = response.data.data[0].kode
                edit.kode_mk         = response.data.data[0].kode_mk
                edit.kode_dosen      = response.data.data[0].kode_dosen
                edit.kelas           = response.data.data[0].kelas
                edit.tahun_akademik  = response.data.data[0].tahun_akademik   
            }).catch(error => {
                console.log(error.response.data)
            }).then(() => { 
                this.visibleLiveDemoEdit = true            
            })
        }

        function dataDelete(kode) {    
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Anda tidak bisa mengembalikan, jika telah dihapus!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Iya',
                cancelButtonText: 'Batal'
            }).then((result) => {   
                if (result.isConfirmed) { 
                    axios.defaults.headers.common.Authorization = `Bearer ${token}`
                    axios.delete(`http://localhost:8000/api/pengampu/${kode}`)
                    data.value.splice(data.value.indexOf(kode), 1);
                    Swal.fire(
                        'Terhapus!',
                        'Data berhasil dihapus.',
                        'success'
                    )
                }
            }).catch(error => {
                console.log(error.response.data)
            })
        }

        return{
            visibleLiveDemoCreate,
            visibleLiveDemoEdit,
            data,
            token,
            router,
            post,
            edit,
            dosen,
            matakuliah,
            get,
            editForm,
            submitEdit,
            dataDelete,
            create
        }       
    }
}
</script>
