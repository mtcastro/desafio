<template>
    <page-template>
      <div class="home">
        <b-container v-if="user_data" class="h-100" >
            <div class="row justify-content-center mt-3 h-100">
              <b-col lg='10' md='12'>
                <div class="nav-pefil d-flex align-items-center mb-4">
                  <h5>Contatos</h5>
                  <div class="nav-perfil-right d-flex align-items-center">
                    <div class="perfil d-flex align-items-center" @click="sowKeyFlow">
                      <img v-if="user_data.photo" :src="user_data.photo" alt="..." class="rounded-circle ml-3 align-items-center">
                      <img v-else src="/padrao.jpg" alt="..." class="rounded-circle ml-3 align-items-center">
                      <p class="ml-2">{{user_data.name.split(' ')[0]}}</p>
                    </div>
                    <a  class="mr-4 ml-4" @click="logout">sair</a>
                  </div>
                </div>
                <b-card>
                  <template #header>
                      <b-row class="search-session">
                        <b-col >
                          <b-input-group class="w-75" >
                              <b-input-group-append>
                                <b-button class="icon-search" >
                                  <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12.9167 11.6666H12.2584L12.025 11.4416C13.025 10.275 13.5417 8.68331 13.2584 6.99164C12.8667 4.67497 10.9334 2.82497 8.60003 2.54164C5.07503 2.10831 2.10837 5.07497 2.5417 8.59997C2.82503 10.9333 4.67503 12.8666 6.9917 13.2583C8.68337 13.5416 10.275 13.025 11.4417 12.025L11.6667 12.2583V12.9166L15.2084 16.4583C15.55 16.8 16.1084 16.8 16.45 16.4583C16.7917 16.1166 16.7917 15.5583 16.45 15.2166L12.9167 11.6666ZM7.9167 11.6666C5.8417 11.6666 4.1667 9.99164 4.1667 7.91664C4.1667 5.84164 5.8417 4.16664 7.9167 4.16664C9.9917 4.16664 11.6667 5.84164 11.6667 7.91664C11.6667 9.99164 9.9917 11.6666 7.9167 11.6666Z" fill="#757575"/>
                                  </svg>

                                </b-button>
                              </b-input-group-append>
                              <b-form-input placeholder="Buscar contato" id="searchInput" 
                                @keyup='searchContact'
                                v-model="searchImputValue"
                                >
                              </b-form-input>
                          </b-input-group>	
                        </b-col>

                        <b-col class="d-flex">
                          <add-Contact-button 
                              :keyModalContactForm="keyModalContactForm"
                              @key-modal-contact-form="getCode"
                            />
                        </b-col>
                      </b-row>

                      <b-row class="tr-contact mt-4 ml-0">
                        <b-col class="col-name"><h6>Nome</h6></b-col>
                        <b-col class="col-email"><h6>Email</h6></b-col>
                        <b-col class="col-phone col-op"><h6>Telefone</h6></b-col>
                      </b-row>
                  </template>
              
                  <b-card-text>
                    <div class="no-contacts text-center" v-if="contactList.length < 1 && searchImputValue.length == 0">
                      <img src="/image_1.png" alt="">
                      <p class="mt-3 mb-4">Ainda não há contatos</p>
                      <add-Contact-button 
                        :keyModalContactForm="keyModalContactForm"
                        @key-modal-contact-form="getCode"
                      />
                    </div>

                    <contact-list 
                      v-else-if="contactList.length > 0"
                      :base_url="base_url"
                      :contactList="contactList"
                      :keyModalContactForm="keyModalContactForm"
                      @key-modal-contact-form="getCode"
                    />

                    <p v-else>Nenhum contato foi encontrado</p>

                  </b-card-text>
                </b-card>
              </b-col >
            </div>

            <b-modal id="modal-contact-form"   v-model="keyModalContactForm" centered :title="this.modalTitle">
                  <form-group label="Nome" label-for="contactName" :error="formErrors.name">
                      <input type="text" id="contactName" placeholder="Nome completo" class="form-control w-75"  v-model="contactData.name">
                  </form-group>

                  <form-group label="Email" label-for="contactPhone" :error="formErrors.email">
                      <input type="email" id="contactPhone" placeholder="Email" class="form-control w-75"  v-model="contactData.email">
                  </form-group>

                  <form-group label="Telefone" label-for="contactPhone" :error="formErrors.phone" v-mask='"+55 (##) #####-####"' >
                      <input type="text" id="contactPhone" placeholder="Telefone" class="form-control w-50"  v-model="contactData.phone">
                  </form-group>

                  <form-group label="Endereço" label-for="contactAddress" :error="formErrors.address">
                      <input type="text" id="contactAddress" placeholder="Endereço" class="form-control w-75"  v-model="contactData.address">
                  </form-group>

                  <form-group label="Bairro" label-for="contactDistrict" :error="formErrors.district">
                      <input type="text" id="contactDistrict" placeholder="Bairro" class="form-control w-50"  v-model="contactData.district">
                  </form-group>

                  <b-row>
                      <b-col>
                          <form-group label="Cidade" label-for="contactCity" :error="formErrors.City">
                              <input type="text" id="contactCity" placeholder="Cidade" class="form-control"  v-model="contactData.city">
                          </form-group>

                      </b-col>

                      <b-col>
                          <form-group label="Estado" label-for="contactState" :error="formErrors.state">
                              <input type="text" id="contactState" placeholder="Estado" class="form-control"  v-model="contactData.state">
                          </form-group>
                      </b-col>
                  </b-row>

                  <template #modal-footer>
                          <b-button variant="light"  @click="keyModalContactForm = !keyModalContactForm">Cancelar</b-button>
                          <b-button v-if="!isUpdate" class="save" @click="addContact">Salvar</b-button>
                          <b-button v-else class="save" @click="updateContact">Atualizar</b-button>
                  </template>

            </b-modal>
        </b-container>

        <div class="loader" v-else>
            <div class="c-loader"></div>
        </div>

      </div>
    </page-template>
</template>

<script>
import PageTemplate from "@/components/templates/PageTemplate";
import FormGroup from "@/components/molecules/FormGroup";
import AddContactButton from "@/components/molecules/AddContactButton";
import ContactList from "@/components/organisms/ContactList";



import axios from "axios"
import { VueMaskDirective } from "v-mask";


export default {

  name: "Home",

  props: {
  },

  components: {
    PageTemplate,
    FormGroup,
    AddContactButton,
    ContactList
  },

  data() {
    return {
      keyModalContactForm: false,
      formErrors:{
        name:'',
        email:'',
        phone:''
      },
      user_data:null,
      contactList:[
        {}
      ],

      modalTitle: 'Adicionar novo contato',
      isUpdate: false,
      searchImputValue: '',

      contactData: {
          name:'',
          email:'',
          phone:'',
          address:'',
          district:'',
          city:'',
          state:''
      },
      base_url:''
    }
  },
  fetch(){
    this.base_url = process.env.BASE_URL;
  },
  
  methods: {
    async logout(){

      var access_token = localStorage.getItem('access_token')
      var BASE_URL = this.base_url;

      var config = {
        headers: {
          Authorization: `Bearer ${access_token}`,
        },
      };

      await axios.get(`${BASE_URL}/logout`,config).then( );
      localStorage.removeItem('access_token');
      this.$router.push({ path: '/login' });
    },

    async addContact(){
        var access_token = localStorage.getItem('access_token')
        var BASE_URL = this.base_url;

        var config = {
            headers: {
                Authorization: `Bearer ${access_token}`,
            },
        };

          var responseData = await axios.post(`${BASE_URL}/contact/register`,this.contactData ,config).then( 
            (response) => { return response.data },
            (error) =>{
              if( error.response.data.message == "The given data was invalid.")
                return {status: 'input required', errors: error.response.data.errors}
              else
                return {status: 'unexpected error', errors: error.response.data.errors}
            });

          if(responseData.status == "success"){
            this.keyModalContactForm = false;
            this.contactList = responseData.data.contactList;
            this.contactData = {
                name:'',
                email:'',
                phone:'',
                address:'',
                district:'',
                city:'',
                state:''
            }
            alert("Contato adicionado com sucesso");
          }
          else if(responseData.status == 'input required'){
          
            if(responseData.errors.name)
              this.formErrors.name = "Campo Obrigatório"
            if(responseData.errors.email)
              this.formErrors.email = "Campo Obrigatório"
            if(responseData.errors.phone)
              this.formErrors.phone = "Campo Obrigatório"

          }
          else if(responseData.status == 'Token is Expired'){
              alert("Sua sessão exprirou, faça login novamente e tente de novo.")
              localStorage.removeItem('access_token')
              this.$router.push({ path: '/login' })
          }
          else{
            localStorage.removeItem('access_token')
            alert('Erro inesperado, tente novamente mais tarde')
          }
        

    },

    async updateContact(){
      var access_token = localStorage.getItem('access_token')
      var BASE_URL = this.base_url;

      var config = {
          headers: {
              Authorization: `Bearer ${access_token}`,
          },
      };

      var responseData = await axios.post(`${BASE_URL}/contact/update/${this.contactData.id}`,this.contactData ,config).then( 
        (response) => { return response.data },
        (error) =>{
          if( error.response.data.message == "The given data was invalid.")
            return {status: 'input required', errors: error.response.data.errors}
          else
            return {status: 'unexpected error', errors: error.response.data.errors}
      });

      if(responseData.status == "success"){
          this.keyModalContactForm = false;
          this.contactList = responseData.data.contactList;
          this.contactData = {
              name:'',
              email:'',
              phone:'',
              address:'',
              district:'',
              city:'',
              state:''
          }
          alert("Contato adicionado com sucesso");
      }
      else if(responseData.status == 'input required'){
          
        if(responseData.errors.name)
          this.formErrors.name = "Campo Obrigatório"
        if(responseData.errors.email)
          this.formErrors.email = "Campo Obrigatório"
        if(responseData.errors.phone)
          this.formErrors.phone = "Campo Obrigatório"

      }
      else if(responseData.status == 'Token is Expired'){
          localStorage.removeItem('access_token')
          alert("Sua sessão exprirou, faça login novamente e tente de novo.")
          this.$router.push({ path: '/login' })
      }
      else{
        localStorage.removeItem('access_token')
        alert('Erro inesperado, tente novamente mais tarde')
      }

    },

    async searchContact(){

      var search = document.getElementById('searchInput').value
      if(search == ''){
        search = '#'
      }


      var access_token = localStorage.getItem('access_token')
      var BASE_URL = this.base_url;

      var config = {
        headers: {
          Authorization: `Bearer ${access_token}`,
        },
      };

      var responseData = await axios.post(`${BASE_URL}/contact/search`,{search: search},config).then( (response) => { return response.data } );
      
      if(responseData.status == "success"){
            this.contactList = responseData.data.contactList;
            
      }
      else if(responseData.status == 'Token is Expired'){
          alert("Sua sessão exprirou, faça login novamente e tente de novo.")
          localStorage.removeItem('access_token')
          this.$router.push({ path: '/login' })
      }
      else{
        localStorage.removeItem('access_token')
        alert('Erro inesperado, tente novamente mais tarde')
        
      }
    },

    getCode(payload) {

      console.log('TESTE', payload.contactData)
      if(payload.contactList){ 
        this.contactList = payload.contactList;
      }else{
        this.keyModalContactForm = false;
        this.contactData = JSON.parse(payload.contactData);
        if(this.contactData.name != ''){
            this.modalTitle = 'Editar contato'
            this.isUpdate = true;
        }
        else{
          this.isUpdate = false;
        }

        this.keyModalContactForm = payload.keyModalContactForm;
        this.formErrors = {
          name:'',
          email:'',
          phone:''
        }
      }

    },

    sowKeyFlow(){
      alert(`key_flow: ${this.user_data.key_flow}`);
    }

  },

    async mounted(){

      if(this.$route.query.access_token){
        await localStorage.setItem('access_token', this.$route.query.access_token)
        await setTimeout(() => {
          window.location.replace('/')
        }, 2000);
      }
      else {
        var access_token = localStorage.getItem('access_token')
        if(access_token){
          var access_token = localStorage.getItem('access_token')
          var BASE_URL = this.base_url;

          var config = {
              headers: {
                  Authorization: `Bearer ${access_token}`,
              },
          };

          try{
            var responseData = await axios.get(`${BASE_URL}/user`, config).then( (response) => { return response.data } )
          }catch{
            localStorage.removeItem('access_token')
            this.$router.push({ path: '/login' })
          }
          console.log("ResponserData",responseData.status);

          if(responseData.status == "success"){
            this.user_data = responseData.data.user_data;
            this.contactList = responseData.data.contactList;
            console.log(this.user_data)
          }
          else {
            localStorage.removeItem('access_token')
            this.$router.push({ path: '/login' })
          }

        }
        else{
          this.$router.push({ path: '/login' })
        }
      }
    }
};
</script>

<style lang="scss">
  .home{
    height: 100%!important;
    margin-bottom: 40px;

    .container-app{
      min-width: 720px;
    }

    .nav-pefil{
      img{
        width: 36px;
        height: 36px;
      }

      .nav-perfil-right{
        margin-left: auto;
      }

      p, a{
          font-family: $headings-font-family;
          font-style: normal;
          font-weight: 500;
          font-size: 15px;
          margin-bottom: 0px!important;
      }

      .perfil, a{
        cursor: pointer;
      }
    }
    h5{
      font-family: $headings-font-family;
      font-style: normal;
      font-weight: 500;
      font-size: 20px;
      line-height: 28px;
      color: $black;
      margin-bottom: 0px!important;
    }
    .card {
        border: none;
        border-radius: 16px;
        box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.2);
        min-height: 90%;
        

      .card-header{
        background-color: #ffffff!important;
        padding-bottom: 0;
        border-top-left-radius: 16px !important;
        border-top-right-radius: 16px !important;


      }

      .card-body{
        height: 100%;
      }

      .search-session{
        margin-top: 4px!important;
        .col{
          height: 36px !important;
        }
        .add-contact {
          margin-left: auto;
        }

        .input-group {
          border: 1px solid #E1E1E1;
          border-radius: 8px;
          button, input{
            background-color: #F8F8F8;
            border: none;
            box-shadow: none;
          }

          button{
            border-left: 1px solid #E1E1E1;
            border-top-left-radius: 8px !important;
            border-bottom-left-radius: 8px !important;
            cursor:default;
            
          }

          

          input{
            border-top-right-radius: 8px !important;
            border-bottom-right-radius: 8px !important;
          }
          
        }
        
      }

      .tr-contact{
        h6{
          font-family: $headings-font-family;
          font-style: normal;
          font-weight: 500;
          font-size: 12px;
          line-height: 16px;
        }
      }

      .no-contacts{
        margin-top: 9%;
        p{
          font-family: $headings-font-family;
          font-style: normal;
          font-weight: normal;
          font-size: 16px;
          line-height: 24px;
          color: #757575
        }

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
  
  #modal-contact-form{
    .modal-title{
        font-family: Roboto;
        font-style: normal;
        font-weight: 500;
        font-size: 20px;
        line-height: 28px;
        letter-spacing: 0.15px;
        color: #262626;
    }
    .modal-footer button{
        font-family: Roboto;
        font-style: normal;
        font-weight: 500;
        font-size: 14px;
        line-height: 18px;
        display: flex;
        align-items: center;
        letter-spacing: 1.25px;
    }
    .save{
        color: #FFFFFF;
        background-color: $primary;
        border: none;
    }
  }

  @media (max-width: 800px){
    .col-email{
      display: none !important;
    }
    
  }

   @media (max-width: 500px){
    .col-phone{
      display: none !important;
    }
    
  }
    
</style>
