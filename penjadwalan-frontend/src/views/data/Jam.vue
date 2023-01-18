<template>
    <div>
    <CRow>
        <CCol :md="16">
        <CCard class="mb-4">
            <CCardBody>
            <CRow>
                <CCol :sm="5">
                <h4 id="traffic" class="card-title mb-0">Data Jam</h4>
                </CCol>
                <CCol :sm="7" class="d-none d-md-block">
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
                        <CTableHeaderCell scope="col">Range Jam</CTableHeaderCell>
                        <CTableHeaderCell scope="col">Aktif</CTableHeaderCell>
                    </CTableRow>
                    </CTableHead>
                    <CTableBody>
                    <CTableRow v-for="(data, index) in data" :key="index">
                        <CTableDataCell>{{ data.kode }}</CTableDataCell>
                        <CTableDataCell>{{ data.range_jam }}</CTableDataCell>
                        <CTableDataCell>{{ data.aktif }}</CTableDataCell>
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
</template>

<script>
import { onMounted, ref } from 'vue'
import { useRouter } from 'vue-router'
import axios from 'axios'

export default {
    name: 'Jam',
    
    setup(){
    let data = ref([]) 
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
        })
    return{
        data,
        token,
        router
    }
        
    }
    // components: { Cards },
}
</script>
    