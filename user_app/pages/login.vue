<template>
    <login />
</template>

<script>

import Login from '@/components/pages/Login';

  export default {
    components: {
        Login
    },

    data: () => {
      return {
        token:''
      }
    },

    beforeRouteEnter(to, from, next) {
   
      next((vm) => {
        vm.token = to.query.token
      });

    },
    
  };
</script>