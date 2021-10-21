<template>
  <page-template>

    <div class="login">
    <b-container  v-if="verifiedAuthenticated" class="h-100">
      <b-row class="justify-content-center align-content-center h-100">
        <b-col  md="5">
            <b-card class="pt3">
                
                <h5>Login</h5>
                <b-button class="mt-3" @click="login">
                  Fazer login com a Huggy
                </b-button>
                
            </b-card>
        </b-col>
      </b-row>
    </b-container>

    <div  v-else class="loader">
      <div class="c-loader"></div>
    </div>

  </div>
  </page-template>
</template>

<script>
import PageTemplate from "@/components/templates/PageTemplate";

import axios from "axios";

export default {
  name: "Login",
  components:{
    PageTemplate
  },
  data: () => {
    return {
      verifiedAuthenticated: false
    };
  },

  methods: {
    login() {
      window.location.replace('https://auth.huggy.app/oauth/authorize?scope=install_app%20read_agent_profile&response_type=code&redirect_uri=http://desafio.com:8000/auth/callback&client_id=APP-e54dd0fb-1909-498e-ba58-e1d98ecf4505')
    },
  },

  async mounted(){

    var access_token = localStorage.getItem('access_token')
    if(access_token){
      var access_token = localStorage.getItem('access_token')
      var BASE_URL = "http://localhost:8000/api";

      var config = {
          headers: {
              Authorization: `Bearer ${access_token}`,
          },
      };

      var responseData = await axios.get(`${BASE_URL}/user`, config).then( (response) => { return response.data } );
      console.log("ResponserData",responseData.status);

      if(responseData.status == "success"){
        this.$router.push({ path: '/' })
      }
      else{
        localStorage.removeItem('access_token')
        this.verifiedAuthenticated = true;
      }
    }
    else{
       this.verifiedAuthenticated = true;
    }
      
    }
};
</script>

<style lang="scss">
  .login{

    height: 100%;
    .card {
      border: none;
      text-align: center;
      background-color: #F8F8F8;

      h4{
        font-family: $headings-font-family;
        font-style: normal;
        font-weight: normal;
        font-size: 24px;
        line-height: 32px;
        color: #262626;
      }

      button{
        background-color: $primary;
        border: none;
        
      }
    }

    .loader {
      align-items: center;
      display: flex;
      justify-content: center;
      height: 100%;
    }

    .c-loader {
      animation: is-rotating 1s infinite;
      border: 6px solid #e5e5e5;
      border-radius: 50%;
      border-top-color: $primary;
      height: 100px;
      width: 100px;
    }

    @keyframes is-rotating {
      to {
          transform: rotate(1turn);
      }
    }
  }
  
</style>
