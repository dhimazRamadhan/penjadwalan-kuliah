import axios from 'axios'
import { useRouter } from 'vue-router'
import Swal from 'sweetalert2'

export default {
    setup() {
        const token = localStorage.getItem('token')
        const router = useRouter()

        //method logout
        function logout() {
            axios.defaults.headers.common.Authorization = `Bearer ${token}`
            axios.post('http://localhost:8000/api/logout')
            .then(response => {
                if(response.data.success){
                    //remove localStorage
                    localStorage.removeItem('token')
                    //redirect ke halaman login
                    return router.push({
                        name : 'Login'
                    })
                }
            })
            .catch(error => {
                console.log(error.response.data)
            })
        }

        return {
            token,
            logout
            }
        }
}
