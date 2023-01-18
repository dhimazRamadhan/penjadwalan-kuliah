<template>
  <router-view />
</template>

<script>
  import { onMounted } from 'vue'
  import { useRouter } from 'vue-router'

  export default{
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
      return{
        token,
        router
      }  
    }
  }
</script>

<style lang="scss">
// Import Main styles for this application
@import 'styles/style';
</style>
