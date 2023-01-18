<template>
    <div>
        <CRow>
            <CCol :md="16">
            <CCard class="mb-4">
                <CCardBody>
                    <CRow>
                    <CCol :sm="5">
                    <h4 id="traffic" class="card-title mb-0">Data Dosen</h4>
                    </CCol>
                    <CCol :sm="7" class="d-none d-md-block">
                    <CButton color="primary" class="float-end" @click="() => { visibleLiveDemoCreate = true }">
                        Tambah Data <CIcon icon="cil-plus" />
                    </CButton>
                    </CCol>
                </CRow>
                <CRow>
                    <div style="margin-top: 40px">
                    <CTable small>
                        <CTableHead>
                        <CTableRow>
                            <CTableHeaderCell scope="col">Kode</CTableHeaderCell>
                            <CTableHeaderCell scope="col">NIDN</CTableHeaderCell>
                            <CTableHeaderCell scope="col">Nama</CTableHeaderCell>
                            <CTableHeaderCell scope="col">Alamat</CTableHeaderCell>
                            <CTableHeaderCell scope="col">Telp</CTableHeaderCell>
                            <CTableHeaderCell scope="col" style="color:blue">Edit</CTableHeaderCell>
                            <CTableHeaderCell scope="col" style="color:red">Delete</CTableHeaderCell>
                        </CTableRow>
                        </CTableHead>
                        <CTableBody>
                        <CTableRow v-for="(data, index) in data" :key="index">
                            <CTableDataCell>{{ data.kode }}</CTableDataCell>
                            <CTableDataCell>{{ data.nidn }}</CTableDataCell>
                            <CTableDataCell>{{ data.nama }}</CTableDataCell>
                            <CTableDataCell>{{ data.alamat }}</CTableDataCell>
                            <CTableDataCell>{{ data.telp }}</CTableDataCell>
                            <CTableDataCell>
                                <CButton class="me-2" @click.prevent="editForm(data.kode)">
                                    <CIcon icon="cil-pencil" style="color:blue"  />
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
        <CModalTitle>Tambah Dosen</CModalTitle>
        </CModalHeader>
        <CModalBody>
            <CForm class="row g-3" @submit.prevent="create">
                <CCol md="12">
                    <CFormLabel for="nama">Nama Dosen</CFormLabel>
                    <CFormInput id="nama" v-model="post.nama" required placeholder=""/>
                </CCol>
                <CCol md="12">
                    <CFormLabel for="nama">NIDN</CFormLabel>
                    <CFormInput id="nidn" v-model="post.nidn" required placeholder=""/>
                </CCol>
                <CCol md="12">
                    <CFormLabel for="nama">Alamat</CFormLabel>
                    <CFormInput id="alamat" v-model="post.alamat" required placeholder=""/>
                </CCol>
                <CCol md="12">
                    <CFormLabel for="inputState">No Telp</CFormLabel>
                    <CFormInput id="telp" v-model="post.telp" required placeholder=""/>
                </CCol>
                <CCol xs="12" class="float-end mt-4">
                    <CButton  color="primary" type="submit" class="ms-2 float-end">Simpan</CButton>
                    <CButton class="float-end" color="secondary" @click="() => { visibleLiveDemoCreate = false }">
                        Kembali
                    </CButton>
                </CCol>  
            </CForm>
            </CModalBody>
    </CModal>
    <!-- modal edit -->
    <CModal :visible="visibleLiveDemoEdit" @close="() => { visibleLiveDemoEdit = false }">
        <CModalHeader>      
        <CModalTitle>Edit Dosen</CModalTitle>
        </CModalHeader>
        <CModalBody>
            <CForm class="row g-3" @submit.prevent="submitEdit">
                <CCol md="12" style="display:none">
                    <CFormLabel for="nama">kode</CFormLabel>
                    <CFormInput  v-model="edit.kode" required  />
                </CCol>
                <CCol md="12">
                    <CFormLabel for="nama">Nama Dosen</CFormLabel>
                    <CFormInput id="nama" v-model="edit.nama" required placeholder=""/>
                </CCol>
                <CCol md="12">
                    <CFormLabel for="nama">NIDN</CFormLabel>
                    <CFormInput id="nidn" v-model="edit.nidn" required placeholder=""/>
                </CCol>
                <CCol md="12">
                    <CFormLabel for="nama">Alamat</CFormLabel>
                    <CFormInput id="alamat" v-model="edit.alamat" required placeholder=""/>
                </CCol>
                <CCol md="12">
                    <CFormLabel for="inputState">No Telp</CFormLabel>
                    <CFormInput id="telp" v-model="edit.telp" required placeholder=""/>
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
import { onMounted, ref, reactive} from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'
import Swal from 'sweetalert2'

export default {
    name: 'Dosen',
    
    

    setup(){
        const post = reactive({
            nama: '',
            nidn: '',
            alamat: '',
            telp: ''
        })
        const edit = reactive({
            kode:'',
            nama: '',
            nidn: '',
            alamat: '',
            telp: ''
        })
        let data = ref([]) 
        // let filterDosen = ref([]) 
        const validation = ref([])
        const token = localStorage.getItem('token')
        const router = useRouter()
        const visibleLiveDemoCreate = ref(false, true)
        const visibleLiveDemoEdit = ref(false, true)
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
            axios.get('http://localhost:8000/api/dosen')
            .then(response => {
            //assign state posts with response data
            data.value = response.data.data         
            }).catch(error => {
                console.log(error.response.data)
            })
            // filterDosen = data.value.filter(data.nama.includes('Erlin'))
        }

        function create(){
            let nama    = post.nama
            let nidn    = post.nidn
            let alamat  = post.alamat
            let telp    = post.telp
            axios.defaults.headers.common.Authorization = `Bearer ${token}`
            axios.post('http://localhost:8000/api/dosen' , {
                nama: nama,
                nidn: nidn,
                alamat: alamat,
                telp: telp
            })
            .then(() => {
                Swal.fire(
                    'Berhasil!',
                    'Data berhasil dibuat.',
                    'success'
                )
                .then(() => { this.visibleStaticBackdropDemo = false })           
                get()
            }).catch(error => {
                validation.value = error.response.data
            })
        }

        function editForm(kode) {
            axios.defaults.headers.common.Authorization = `Bearer ${token}`
            axios.get(`http://localhost:8000/api/dosen/${kode}`) 
            .then(response => {      
                edit.kode       = response.data.data[0].kode
                edit.nama       = response.data.data[0].nama
                edit.nidn       = response.data.data[0].nidn
                edit.alamat     = response.data.data[0].alamat
                edit.telp       = response.data.data[0].telp      
            }).catch(error => {
                console.log(error.response.data)
            }).then(() => { 
                this.visibleLiveDemoEdit = true            
            })
        }

        function submitEdit(){
            let kode     = edit.kode
            let nama     = edit.nama
            let nidn     = edit.nidn
            let alamat   = edit.alamat
            let telp     = edit.telp
            axios.defaults.headers.common.Authorization = `Bearer ${token}`
            axios.put(`http://localhost:8000/api/dosen/${kode}`, {
                kode: kode,
                nama: nama,
                nidn: nidn,
                alamat: alamat,
                telp: telp
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
                    axios.delete(`http://localhost:8000/api/dosen/${kode}`)
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
            data,
            // filterDosen,
            token,
            router,
            post,
            edit,
            visibleLiveDemoCreate,
            visibleLiveDemoEdit,
            editForm,
            submitEdit,
            get,
            dataDelete,
            create
        }      
    }
}
</script>
    