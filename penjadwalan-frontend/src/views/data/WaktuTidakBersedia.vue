<template>
    <div>
        <CRow>
            <CCol :md="16">
            <CCard class="mb-4">
                <CCardBody>
                <CRow>
                    <CCol :sm="5">
                    <h4 id="traffic" class="card-title mb-0">Data Waktu Tidak Bersedia</h4>
                    </CCol>
                    <CCol :sm="7" class="d-none d-md-block" @click="() => { visibleLiveDemoCreate = true }">
                    <CButton color="primary" class="float-end">
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
                            <CTableHeaderCell scope="col">Dosen</CTableHeaderCell>
                            <CTableHeaderCell scope="col">Hari</CTableHeaderCell>
                            <CTableHeaderCell scope="col">Jam</CTableHeaderCell>
                            <CTableHeaderCell scope="col" style="color:blue">Edit</CTableHeaderCell>
                            <CTableHeaderCell scope="col" style="color:red">Delete</CTableHeaderCell>
                        </CTableRow>
                        </CTableHead>
                        <CTableBody>
                        <CTableRow v-for="(data, index) in data" :key="index">
                            <CTableDataCell>{{ data.kode }}</CTableDataCell>
                            <CTableDataCell>{{ data.nama }}</CTableDataCell>
                            <CTableDataCell>{{ data.hari }}</CTableDataCell>
                            <CTableDataCell>{{ data.jam }}</CTableDataCell>
                            <CTableDataCell>
                                <CButton class="me-2" @click.prevent="editForm(data.kode)">
                                    <CIcon icon="cil-pencil" style="color:blue" />
                                </CButton>
                            </CTableDataCell>
                            <CTableDataCell>
                                <CButton @click.prevent="dataDelete(data.kode)">
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
        <CModalTitle>Tambah Waktu Tidak Bersedia</CModalTitle>
        </CModalHeader>
        <CModalBody>
            <CForm class="row g-3" @submit.prevent="create">
                <CCol md="12">
                    <CFormLabel for="nama">Dosen</CFormLabel>
                    <CFormSelect v-model="post.kode_dosen" >
                        <option></option>
                        <option v-for="(dosen, index) in dosen" :key="index" :value="dosen.kode">{{dosen.nama}} ( {{dosen.kode}} )</option>
                    </CFormSelect>
                </CCol>
                <CCol md="12">
                    <CFormLabel for="nama">Hari</CFormLabel>
                    <CFormSelect v-model="post.kode_hari" >
                        <option></option>
                        <option v-for="(hari, index) in hari" :key="index" :value="hari.kode">{{hari.nama}} ( {{hari.kode}} )</option>
                    </CFormSelect>
                </CCol>
                <CCol md="12">
                    <CFormLabel for="nama">Jam</CFormLabel>
                    <CFormSelect v-model="post.kode_jam" >
                        <option></option>
                        <option v-for="(jam, index) in jam" :key="index" :value="jam.kode">{{jam.range_jam}}</option>
                    </CFormSelect>
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
        <CModalTitle>Edit Waktu Tidak Bersedia</CModalTitle>
        </CModalHeader>
        <CModalBody>
            <CForm class="row g-3" @submit.prevent="submitEdit">
                <CCol md="12">
                    <CCol md="12">
                    <CFormLabel for="nama" style="display:none">kode</CFormLabel>
                    <CFormInput v-model="edit.kode" placeholder=""/>
                </CCol>
                    <CFormLabel for="nama">Dosen</CFormLabel>
                    <CFormSelect v-model="edit.kode_dosen" >
                        <option></option>
                        <option v-for="(dosen, index) in dosen" :key="index" :value="dosen.kode">{{dosen.nama}} ( {{dosen.kode}} )</option>
                    </CFormSelect>
                </CCol>
                <CCol md="12">
                    <CFormLabel for="nama">Hari</CFormLabel>
                    <CFormSelect v-model="edit.kode_hari" >
                        <option></option>
                        <option v-for="(hari, index) in hari" :key="index" :value="hari.kode">{{hari.nama}} ( {{hari.kode}} )</option>
                    </CFormSelect>
                </CCol>
                <CCol md="12">
                    <CFormLabel for="nama">Jam</CFormLabel>
                    <CFormSelect v-model="edit.kode_jam" >
                        <option></option>
                        <option v-for="(jam, index) in jam" :key="index" :value="jam.kode">{{jam.range_jam}}</option>
                    </CFormSelect>
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
    name: 'Waktu Tidak Bersedia',
    
    setup(){
        let data = ref([]) 
        let hari = ref([]) 
        let jam = ref([]) 
        let dosen = ref([]) 
        const token = localStorage.getItem('token')
        const router = useRouter()
        const visibleLiveDemoCreate = ref(false)
        const visibleLiveDemoEdit = ref(false)
        const validation = ref([])
        const post = reactive({
            kode_dosen: '',
            kode_hari: '',
            kode_jam: '',
        })
        const edit = reactive({
            kode: '',
            kode_dosen: '',
            kode_hari: '',
            kode_jam: '',
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
            axios.get('http://localhost:8000/api/waktu_tidak_bersedia')
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
            axios.get('http://localhost:8000/api/hari')
            .then(response => {
            //assign state posts with response data
            hari.value = response.data.data         
            }).catch(error => {
                console.log(error.response.data)
            })

            axios.defaults.headers.common.Authorization = `Bearer ${token}`
            axios.get('http://localhost:8000/api/jam')
            .then(response => {
            //assign state posts with response data
            jam.value = response.data.data         
            }).catch(error => {
                console.log(error.response.data)
            })
        }

        function create(){
            let kode_dosen     = post.kode_dosen
            let kode_hari      = post.kode_hari
            let kode_jam       = post.kode_jam

            axios.defaults.headers.common.Authorization = `Bearer ${token}`
            axios.post('http://localhost:8000/api/waktu_tidak_bersedia' , {
                kode_dosen: kode_dosen,
                kode_hari: kode_hari,
                kode_jam: kode_jam,
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

        function editForm(kode){
            axios.defaults.headers.common.Authorization = `Bearer ${token}`
            axios.get(`http://localhost:8000/api/waktu_tidak_bersedia/${kode}`) 
            .then(response => {      
                edit.kode            = response.data.data[0].kode
                edit.kode_dosen      = response.data.data[0].kode_dosen
                edit.kode_hari       = response.data.data[0].kode_hari
                edit.kode_jam        = response.data.data[0].kode_jam   
            }).catch(error => {
                console.log(error.response.data)
            }).then(() => { 
                this.visibleLiveDemoEdit = true            
            })
        }

        function submitEdit(){
            let kode           = edit.kode
            let kode_dosen     = edit.kode_dosen
            let kode_hari      = edit.kode_hari
            let kode_jam       = edit.kode_jam      
            console.log(kode)    
            axios.defaults.headers.common.Authorization = `Bearer ${token}`
            // axios.put(`http://localhost:8000/api/waktu_tidak_bersedia/${kode}`, {
            axios.put(`http://localhost:8000/api/waktu_tidak_bersedia/${kode}`, {
                kode_dosen: kode_dosen,
                kode_hari: kode_hari,
                kode_jam: kode_jam,
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
                    axios.delete(`http://localhost:8000/api/waktu_tidak_bersedia/${kode}`)
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
            hari,
            jam,
            get,
            editForm,
            submitEdit,
            dataDelete,
            create
        }       
    }
}
</script>