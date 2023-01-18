<template>
    <div>
        <CRow>
            <CCol :md="16">
            <CCard class="mb-4">
                <CCardBody>
                <CRow>
                    <CCol :sm="5">
                    <h4 id="traffic" class="card-title mb-0">Data Matakuliah</h4>
                    </CCol>
                    <CCol :sm="7" class="d-none d-md-block">
                    <CButton color="primary" class="float-end" @click="() => { visibleLiveDemoCreate = true }">
                        Tambah Data <CIcon icon="cil-plus" />
                    </CButton>
                    </CCol>
                </CRow>
                <CRow>
                    <div style="margin-top: 60px">
                    <CTable>
                        <CTableHead>
                        <CTableRow>
                            <CTableHeaderCell scope="col">Kode</CTableHeaderCell>
                            <CTableHeaderCell scope="col">Nama</CTableHeaderCell>
                            <CTableHeaderCell scope="col">Kode Matakuliah</CTableHeaderCell>
                            <CTableHeaderCell scope="col">SKS</CTableHeaderCell>
                            <CTableHeaderCell scope="col">Semester</CTableHeaderCell>
                            <CTableHeaderCell scope="col">Jenis</CTableHeaderCell>
                            <CTableHeaderCell scope="col" style="color:blue">Edit</CTableHeaderCell>
                            <CTableHeaderCell scope="col" style="color:red">Delete</CTableHeaderCell>
                        </CTableRow>
                        </CTableHead>
                        <CTableBody>
                        <CTableRow v-for="(data, index) in data" :key="index">
                            <CTableDataCell>{{ data.kode }}</CTableDataCell>
                            <CTableDataCell>{{ data.nama }}</CTableDataCell>
                            <CTableDataCell>{{ data.kode_mk }}</CTableDataCell>
                            <CTableDataCell>{{ data.sks }}</CTableDataCell>
                            <CTableDataCell>{{ data.semester }}</CTableDataCell>
                            <CTableDataCell>{{ data.jenis }}</CTableDataCell>
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
    <!-- MODAL -->
    <CModal :visible="visibleLiveDemoCreate" @close="() => { visibleLiveDemoCreate = false }">
        <CModalHeader>      
        <CModalTitle>Tambah Matakuliah</CModalTitle>
        </CModalHeader>
        <CModalBody>
            <CForm class="row g-3" @submit.prevent="create">
                <CCol md="12">
                    <CFormLabel for="nama">Nama Matakuliah</CFormLabel>
                    <CFormInput id="nama" v-model="post.nama" required placeholder="Matematika Murni"/>
                </CCol>
                <CCol md="12">
                    <CFormLabel for="nama">Kode Matakuliah</CFormLabel>
                    <CFormInput id="nama" v-model="post.kode_mk" required placeholder="MTKMRN"/>
                </CCol>
                <CCol md="12">
                    <CFormLabel for="nama">SKS</CFormLabel>
                    <CFormInput id="sks" v-model="post.sks" required placeholder="3"/>
                </CCol>
                <CCol md="12">
                    <CFormLabel for="nama">Semester</CFormLabel>
                    <CFormInput id="semester" v-model="post.semester" required placeholder="2"/>
                </CCol>
                <CCol md="12">
                    <CFormLabel for="inputState">Jenis</CFormLabel>
                    <CFormSelect id="inputState" v-model="post.jenis" required placeholder="">
                        <option>Jenis</option>
                        <option value="PRAKTIKUM">Praktikum</option>
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
        <CModalTitle>Edit Matakuliah</CModalTitle>
        </CModalHeader>
        <CModalBody>
            <CForm class="row g-3" @submit.prevent="submitEdit">
                <CCol md="12" style="display:none">
                    <CFormLabel for="nama">kode</CFormLabel>
                    <CFormInput  v-model="edit.kode" required  />
                </CCol>
                <CCol md="12">
                    <CFormLabel for="nama">Kode Matakuliah</CFormLabel>
                    <CFormInput id="nama" v-model="edit.kode_mk" required placeholder="MTKMRN"/>
                </CCol>
                <CCol md="12">
                    <CFormLabel for="nama">Nama Matakuliah</CFormLabel>
                    <CFormInput  v-model="edit.nama" required />
                </CCol>
                <CCol md="12">
                    <CFormLabel for="sks">SKS</CFormLabel>
                    <CFormInput id="sks" v-model="edit.sks" required/>
                </CCol>
                <CCol md="12">
                    <CFormLabel for="semester">Semester</CFormLabel>
                    <CFormInput id="semester" v-model="edit.semester" required/>
                </CCol>
                <CCol md="12">
                    <CFormLabel for="inputState">Jenis</CFormLabel>
                        <CFormSelect id="inputState" v-model="edit.jenis" required>
                            <option value="PRAKTIKUM">Praktikum</option>
                            <option value="TEORI">Teori</option>
                    </CFormSelect>
                </CCol>
                <CCol md="12" style="display:none">
                    <CFormLabel for="inputState">Aktif</CFormLabel>
                    <CFormSelect id="inputState" v-model="edit.aktif" required>
                    <option value="True">True</option>
                    <option value="False">False</option>
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
    <!-- END MODAL -->
</template>

<script>
import { onMounted, ref, reactive } from 'vue'
import { useRouter } from 'vue-router'
import axios from 'axios'
import Swal from 'sweetalert2'

export default {
    name: 'Matakuliah',
    
    setup(){
        let data = ref([]) 
        const token = localStorage.getItem('token')
        const router = useRouter()
        const visibleLiveDemoCreate = ref(false)
        const visibleLiveDemoEdit = ref(false)
        const validation = ref([])
        const edit = reactive({
            aktif:'',
            kode:'',
            kode_mk:'',
            nama: '',
            sks: '',
            semester: '',
            jenis: ''
        })
        const post = reactive({
            kode_mk:'',
            nama: '',
            sks: '',
            semester: '',
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
            axios.get('http://localhost:8000/api/matakuliah/')
            .then(response => {
                data.value = response.data.data         
            }).catch(error => {
                console.log(error.response.data)
            })
        }

        function create(){
            let kode_mk  = post.kode_mk
            let nama     = post.nama
            let sks      = post.sks
            let semester = post.semester
            let jenis    = post.jenis
            let aktif    = 'True'

            axios.defaults.headers.common.Authorization = `Bearer ${token}`
            axios.post('http://localhost:8000/api/matakuliah' , {
                kode_mk: kode_mk,
                nama: nama,
                sks: sks,
                semester: semester,
                aktif: aktif,
                jenis: jenis
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

        function submitEdit(){
            let kode     = edit.kode
            let kode_mk  = edit.kode_mk
            let nama     = edit.nama
            let sks      = edit.sks
            let semester = edit.semester
            let jenis    = edit.jenis
            let aktif    = edit.aktif
            axios.defaults.headers.common.Authorization = `Bearer ${token}`
            axios.put(`http://localhost:8000/api/matakuliah/${kode}`, {
                kode: kode,
                kode_mk: kode_mk,
                nama: nama,
                sks: sks,
                semester: semester,
                aktif: aktif,
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

        function editForm(kode) {
            axios.defaults.headers.common.Authorization = `Bearer ${token}`
            axios.get(`http://localhost:8000/api/matakuliah/${kode}`) 
            .then(response => {      
                edit.kode      = response.data.data[0].kode
                edit.kode_mk   = response.data.data[0].kode_mk
                edit.nama      = response.data.data[0].nama
                edit.sks       = response.data.data[0].sks
                edit.semester  = response.data.data[0].semester
                edit.jenis     = response.data.data[0].jenis   
                edit.aktif     = response.data.data[0].aktif   
            }).catch(error => {
                console.log(error.response.data)
            }).then(() => { 
                this.visibleLiveDemoEdit = true      
                get()      
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
                    axios.delete(`http://localhost:8000/api/matakuliah/${kode}`)
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
    