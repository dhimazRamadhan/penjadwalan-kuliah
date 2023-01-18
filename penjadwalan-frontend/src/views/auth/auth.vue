<script>
  import { onMounted } from 'vue'
  import { useRouter } from 'vue-router'

  export default{
    name: 'Auth',
    setup(){
      const token = localStorage.getItem('token')
      const router = useRouter()
      onMounted(() =>{
                //check Token exist
                if(!token) {
                return router.push({
                name: 'Login'
                })
            }
        })
    }
  }
</script>