<template>
<div>
    <CRow>
    <CCol>
        <CCard class="mb-4">
        <CCardBody>
            <CRow>
            <CCol :sm="5">
                <h4 id="traffic" class="card-title mb-0">View Jadwal</h4>
                <p class="text-medium-emphasis small">
                    Memudahkan melihat jadwal dari sudut pandang yang diinginkan!
                </p>
            </CCol>
            <!-- <CCol :sm="7" class="d-none d-md-block">
                <CButtonGroup
                class="float-end me-3"
                role="group"
                aria-label="Basic outlined example"
                >
                <CButton color="primary" variant="outline" @click="() => { fullscreenDemo = true }"><CIcon icon="cil-people"/> Dosen</CButton>
                <CButton color="primary" variant="outline" @click="() => { fullscreenDemoRuang = true }"><CIcon icon="cil-door"/> Ruang</CButton>
                </CButtonGroup>
            </CCol> -->
            </CRow>
            <div style="margin-top: 20px;margin-bottom: 20px">
                <CRow>
                    <CCol :xs="12"  @click="() => { fullscreenDemo = true }">
                        <div class="a">
                            <CWidgetStatsC class="mb-3" value="Dosen" inverse color="info" :progres="{ value:100 }" title="Lihat data jadwal berdasarkan dosen!">
                            <template #icon><CIcon icon="cil-people" height="50" style="color:white"/></template>
                            </CWidgetStatsC>
                        </div>
                    </CCol>
                    <CCol :xs="12"  @click="() => { fullscreenDemoRuang = true }" class="mt-3">
                        <div class="a">
                            <CWidgetStatsC class="mb-3" value="Ruang" inverse color="success" :progres="{ value:100 }" title="Lihat data jadwal berdasarkan ruang!">
                            <template #icon><CIcon icon="cil-door" height="50" style="color:white"/></template>
                            </CWidgetStatsC>
                        </div>
                    </CCol>
                </CRow>
            </div>
        </CCardBody>
        </CCard>
    </CCol>
    </CRow>
    </div>
    <!-- modal -->
    <CModal fullscreen :visible="fullscreenDemo" @close="() => { fullscreenDemo = false }" color="light">
        <CModalHeader>
            <CModalTitle>Detail Jadwal</CModalTitle>
        </CModalHeader>
        <CModalBody>
            <CRow>
                <div style="margin-top: 40px">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col" rowspan="2" colspan="30"></th>
                                <th scope="col" colspan="66" v-for="(hari, index) in hari" :key="index">{{hari.nama}}</th>
                            </tr>
                            <tr>
                                <template v-for="i in hari.length" :key="i">
                                    <th scope="col" colspan="6" v-for="(jam, index) in jam" :key="index">{{jam.kode}}</th>
                                </template> 
                            </tr>   
                        </thead>
                        <tbody>
                            <tr v-for="(dosen, index) in dosen" :key="index" >
                                <th colspan="30">
                                    <div style="width: 220px;height: 60px;">
                                        {{dosen.nama}}
                                    </div>
                                </th>
                                <template v-for="(hari, index) in hari" :key="index">
                                    <template v-for="(jam, index) in jam" :key="index">
                                        <td colspan="6">    
                                            <div style="width: 90px;">                   
                                                <template v-for="(dosenV, index) in dosenView" :key="index">
                                                    <template  v-if="dosenV.kode_dosen == dosen.kode && dosenV.kode_hari == hari.kode && dosenV.kode_jam == jam.kode">
                                                        {{dosenV.kode_mk}}
                                                    </template>
                                                </template>
                                            </div>
                                        </td>
                                    </template>
                                </template>
                            </tr>
                        </tbody>
                    </table>
                </div>          
            </CRow>
        </CModalBody>
    </CModal>

    <!-- modal ruang -->
    <CModal fullscreen :visible="fullscreenDemoRuang" @close="() => { fullscreenDemo = false }" color="light">
        <CModalHeader>
            <CModalTitle>Detail Jadwal</CModalTitle>
        </CModalHeader>
        <CModalBody>
            <CRow>
                <div style="margin-top: 40px">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col" rowspan="2" colspan="30"></th>
                                <th scope="col" colspan="66" v-for="(hari, index) in hari" :key="index">{{hari.nama}}</th>
                            </tr>
                            <tr>
                                <template v-for="i in hari.length" :key="i">
                                    <th scope="col" colspan="6" v-for="(jam, index) in jam" :key="index">{{jam.kode}}</th>
                                </template> 
                            </tr>   
                        </thead>
                        <tbody>
                            <tr v-for="(ruang, index) in ruang" :key="index" >
                                <th colspan="30">
                                    <div style="width: 220px;height: 60px;">
                                        {{ruang.nama}}
                                    </div>
                                </th>
                                <template v-for="(hari, index) in hari" :key="index">
                                    <template v-for="(jam, index) in jam" :key="index">
                                        <td colspan="6">    
                                            <div style="width: 90px;">                   
                                                <template v-for="(ruangV, index) in ruangView" :key="index">
                                                    <template  v-if="ruangV.kode_ruang == ruang.kode && ruangV.kode_hari == hari.kode && ruangV.kode_jam == jam.kode">
                                                        {{ruangV.kode_mk}}
                                                    </template>
                                                </template>
                                            </div>
                                        </td>
                                    </template>
                                </template>
                            </tr>
                        </tbody>
                    </table>
                </div>          
            </CRow>
        </CModalBody>
    </CModal>
</template>

<script>
    import { onMounted,reactive, ref } from 'vue'
    import { useRouter } from 'vue-router'
    import axios from 'axios'
    // import {authVue} from './auth/auth.vue'
    

export default {
name: 'View Jadwal',  
setup(){
    const token = localStorage.getItem('token')
    const router = useRouter()
    const input = reactive({
            semester: '',
            tahun_akademik: ''
        })
    const fullscreenDemo = ref(false)
    const fullscreenDemoRuang = ref(false)
    const validation = ref([])
    let jadwal = ref([]) 
    let hari = ref([]) 
    let jam = ref([]) 
    let dosen = ref([]) 
    let ruang = ref([]) 
    let count = ref([]) 
    let dosenView = ref([]) 
    let ruangView = ref([]) 

    onMounted(() =>{
        if(!token) {
            return router.push({
            name: 'Login'
            })
        }

        //get hari
        axios.defaults.headers.common.Authorization = `Bearer ${token}`
        axios.get('http://localhost:8000/api/hari')
        .then(response => {
        //assign state posts with response data
        hari.value = response.data.data
        // console.log(count)
        }).catch(error => {
            console.log(error.response.data)
        })

        //get jam
        axios.defaults.headers.common.Authorization = `Bearer ${token}`
        axios.get('http://localhost:8000/api/jam')
        .then(response => {
        //assign state posts with response data
        jam.value = response.data.data         
        }).catch(error => {
            console.log(error.response.data)
        })

        //get dosen
        axios.defaults.headers.common.Authorization = `Bearer ${token}`
        axios.get('http://localhost:8000/api/dosen')
        .then(response => {
        //assign state posts with response data
        dosen.value = response.data.data         
        }).catch(error => {
            console.log(error.response.data)
        })

         //get ruang
        axios.defaults.headers.common.Authorization = `Bearer ${token}`
        axios.get('http://localhost:8000/api/ruang')
        .then(response => {
        //assign state posts with response data
        ruang.value = response.data.data         
        }).catch(error => {
            console.log(error.response.data)
        })

        axios.defaults.headers.common.Authorization = `Bearer ${token}`
        axios.get('http://localhost:8000/api/dosenView')
        .then(response => {
        //assign state posts with response data
        dosenView.value = response.data.data         
        }).catch(error => {
            console.log(error.response.data)
        })

        axios.defaults.headers.common.Authorization = `Bearer ${token}`
        axios.get('http://localhost:8000/api/ruangView')
        .then(response => {
        //assign state posts with response data
        ruangView.value = response.data.data         
        }).catch(error => {
            console.log(error.response.data)
        })
    })
    

    //return
    return{
    jadwal,
    input,
    validation,
    token,
    router,
    hari,
    jam,
    dosen,
    ruang,
    fullscreenDemo,
    fullscreenDemoRuang,
    count,
    dosenView,
    ruangView
    }
        
}
}
</script>

<style>
    .a:hover{
        box-shadow: -1px 26px 34px -13px rgba(115,115,115,0.71);
-webkit-box-shadow: -1px 26px 34px -13px rgba(115,115,115,0.71);
-moz-box-shadow: -1px 26px 34px -13px rgba(115,115,115,0.71);
    }
</style>
