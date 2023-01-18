<template>
    <div>
        <CRow>
            <CCol :md="16">
            <CCard class="mb-4">
                <CCardBody>
                <CRow>
                    <CCol :sm="5">
                    <h4 id="traffic" class="card-title mb-0">Data Ruang</h4>
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
                            <CTableHeaderCell scope="col">Nama</CTableHeaderCell>
                            <CTableHeaderCell scope="col">Kapasitas</CTableHeaderCell>
                            <CTableHeaderCell scope="col">Jenis</CTableHeaderCell>
                            <CTableHeaderCell scope="col" style="color:blue">Edit</CTableHeaderCell>
                            <CTableHeaderCell scope="col" style="color:red">Delete</CTableHeaderCell>
                        </CTableRow>
                        </CTableHead>
                        <CTableBody>
                        <CTableRow v-for="(data, index) in data" :key="index">
                            <CTableDataCell>{{ data.kode }}</CTableDataCell>
                            <CTableDataCell>{{ data.nama }}</CTableDataCell>
                            <CTableDataCell>{{ data.kapasitas }}</CTableDataCell>
                            <CTableDataCell>{{ data.jenis }}</CTableDataCell>
                            <CTableDataCell>
                                <CButton class="me-2" @click="editForm(data.kode)">
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
        <CModalTitle>Tambah Ruang</CModalTitle>
        </CModalHeader>
        <CModalBody>
            <CForm class="row g-3" @submit.prevent="create">
                <CCol md="12">
                    <CFormLabel for="nama">Nama Ruang</CFormLabel>
                    <CFormInput v-model="post.nama" required placeholder=""/>
                </CCol>
                <CCol md="12">
                    <CFormLabel for="nama">Kapasitas</CFormLabel>
                    <CFormInput v-model="post.kapasitas" required placeholder="" type="number"/>
                </CCol>
                <CCol md="12">
                    <CFormLabel for="inputState">Jenis</CFormLabel>
                    <CFormSelect v-model="post.jenis" required placeholder="">
                        <option></option>
                        <option value="LABORATORIUM">Laboratorium</option>
                        <option value="TEORI">Teori</option>
                    </CFormSelect>
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
        <CModalTitle>Edit Ruang</CModalTitle>
        </CModalHeader>
        <CModalBody>
            <CForm class="row g-3" @submit.prevent="submitEdit">
                <CCol md="12" style="display:none">
                    <CFormLabel for="nama">kode</CFormLabel>
                    <CFormInput v-model="edit.kode" required placeholder=""/>
                </CCol>
                <CCol md="12">
                    <CFormLabel for="nama">Nama Ruang</CFormLabel>
                    <CFormInput v-model="edit.nama" required placeholder=""/>
                </CCol>
                <CCol md="12">
                    <CFormLabel for="nama">Kapasitas</CFormLabel>
                    <CFormInput v-model="edit.kapasitas" required placeholder="" type="number"/>
                </CCol>
                <CCol md="12">
                    <CFormLabel for="inputState">Jenis</CFormLabel>
                    <CFormSelect v-model="edit.jenis" required placeholder="">
                        <option></option>
                        <option value="LABORATORIUM">Laboratorium</option>
                        <option value="TEORI">Teori</option>
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
    name: 'Ruang',
    
    setup(){
        let data = ref([]) 
        const token = localStorage.getItem('token')
        const router = useRouter()
        const visibleLiveDemoCreate = ref(false)
        const visibleLiveDemoEdit = ref(false)
        const validation = ref([])
        const edit = reactive({
            kode:'',
            nama:'',
            kapasitas:'',
            jenis: ''
        })
        const post = reactive({
            nama:'',
            kapasitas:'',
            jenis: ''
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
            axios.get('http://localhost:8000/api/ruang')
            .then(response => {
                data.value = response.data.data         
            }).catch(error => {
                console.log(error.response.data)
            })
        }

        function create(){
            let nama        = post.nama
            let kapasitas   = post.kapasitas
            let jenis       = post.jenis

            axios.defaults.headers.common.Authorization = `Bearer ${token}`
            axios.post('http://localhost:8000/api/ruang' , {
                nama: nama,
                kapasitas: kapasitas,
                jenis: jenis,
            })
            .then(() => {
                Swal.fire(
                    'Berhasil!',
                    'Data berhasil dibuat.',
                    'success'
                )
                .then(() => { this.visibleLiveDemoCreate = false })
                get()
            }).catch(error => {
                validation.value = error.response.data
            })
        }

        function editForm(kode) {
            axios.defaults.headers.common.Authorization = `Bearer ${token}`
            axios.get(`http://localhost:8000/api/ruang/${kode}`) 
            .then(response => {      
                edit.kode        = response.data.data[0].kode
                edit.nama        = response.data.data[0].nama
                edit.kapasitas   = response.data.data[0].kapasitas
                edit.jenis       = response.data.data[0].jenis   
            }).catch(error => {
                console.log(error.response.data)
            }).then(() => { 
                this.visibleLiveDemoEdit = true      
            })
        }

        function submitEdit(){
            let kode       = edit.kode
            let nama       = edit.nama
            let kapasitas  = edit.kapasitas
            let jenis      = edit.jenis   
            axios.defaults.headers.common.Authorization = `Bearer ${token}`
            axios.put(`http://localhost:8000/api/ruang/${kode}`, {
                nama: nama,
                kapasitas: kapasitas,
                jenis: jenis
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
                    axios.delete(`http://localhost:8000/api/ruang/${kode}`)
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
            token,
            router,
            visibleLiveDemoCreate,
            visibleLiveDemoEdit,
            edit,
            post,
            get,
            create,
            editForm,
            submitEdit,
            dataDelete

        }     
    }
}
</script>