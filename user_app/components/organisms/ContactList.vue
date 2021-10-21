<template>
    <div  class="contact-list">
        
        <div v-for="(contact, index) in contactList">
            <b-card> 
                    <b-card-text>
                        <b-row  class="iten d-flex align-items-center">

                            <b-col  class="d-flex col-name" @click="detalheContactClick(index)">
                                <img class="mr-2 rounded-circle name" src="/padrao.jpg" alt="">
                                <span>{{contact.name}}</span> 
                            </b-col>

                            <b-col  class="col-email" @click="detalheContactClick(index)">
                                <span>{{contact.email}}</span> 
                            </b-col>

                            <b-col  class="d-flex col-op">
                                <span @click="detalheContactClick(index)" class="col-phone">{{contact.phone}}</span> 
                                <div class="option">
                                    <i  @click="editContactClick(index)">
                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M0.5 12.55V15.0833C0.5 15.3167 0.683333 15.5 0.916667 15.5H3.45C3.55833 15.5 3.66667 15.4583 3.74167 15.375L12.8417 6.28334L9.71667 3.15834L0.625 12.25C0.541667 12.3333 0.5 12.4333 0.5 12.55ZM15.2583 3.86667C15.5833 3.54167 15.5833 3.01667 15.2583 2.69167L13.3083 0.741675C12.9833 0.416675 12.4583 0.416675 12.1333 0.741675L10.6083 2.26667L13.7333 5.39167L15.2583 3.86667Z" fill="#505050"/>
                                        </svg>
                                    </i>
                                    <i class="ml-3"  @click="delectContactClick(index)">
                                        <svg width="12" height="16" viewBox="0 0 12 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1.00008 13.8333C1.00008 14.75 1.75008 15.5 2.66675 15.5H9.33342C10.2501 15.5 11.0001 14.75 11.0001 13.8333V5.5C11.0001 4.58333 10.2501 3.83333 9.33342 3.83333H2.66675C1.75008 3.83333 1.00008 4.58333 1.00008 5.5V13.8333ZM11.0001 1.33333H8.91675L8.32508 0.741667C8.17508 0.591667 7.95842 0.5 7.74175 0.5H4.25842C4.04175 0.5 3.82508 0.591667 3.67508 0.741667L3.08342 1.33333H1.00008C0.541748 1.33333 0.166748 1.70833 0.166748 2.16667C0.166748 2.625 0.541748 3 1.00008 3H11.0001C11.4584 3 11.8334 2.625 11.8334 2.16667C11.8334 1.70833 11.4584 1.33333 11.0001 1.33333Z" fill="#505050"/>
                                        </svg>
                                    </i>
                                </div>
                            </b-col>

                        </b-row>        
                </b-card-text>
            </b-card > 
        </div>

        <b-modal id="modal-contact-delete" v-model="modal_contact_delete" size="sm" centered hide-footer hide-header>
                <b-row class="title">
                    <h4>Excluir este contato?</h4>
                </b-row>
                <b-row class="footer">
                    <div class="options"> 
                        <a class="cancel" @click="modal_contact_delete=false">Cancelar</a>
                        <a class="ml-4 delete" @click="deletContact">Excluir</a>
                    </div>
                </b-row>
        </b-modal>

       <b-modal id="modal-contact" v-model="modal_contact" centered hide-footer>
            <template #modal-header>
                    <div class="modal-contact-name d-flex mt-1">
                        <img class="mr-3 rounded-circle" src="/padrao.jpg" alt="" width="32" height="32">
                        <h4> {{contactData.name}} </h4>
                    </div>

                    <div class="modal-contact-options mt-1">
                        <i @click="delectContactClick(index)">
                            <svg width="12" height="16" viewBox="0 0 12 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0.999959 13.8333C0.999959 14.75 1.74996 15.5 2.66663 15.5H9.33329C10.25 15.5 11 14.75 11 13.8333V5.5C11 4.58333 10.25 3.83333 9.33329 3.83333H2.66663C1.74996 3.83333 0.999959 4.58333 0.999959 5.5V13.8333ZM11 1.33333H8.91663L8.32496 0.741667C8.17496 0.591667 7.95829 0.5 7.74163 0.5H4.25829C4.04163 0.5 3.82496 0.591667 3.67496 0.741667L3.08329 1.33333H0.999959C0.541626 1.33333 0.166626 1.70833 0.166626 2.16667C0.166626 2.625 0.541626 3 0.999959 3H11C11.4583 3 11.8333 2.625 11.8333 2.16667C11.8333 1.70833 11.4583 1.33333 11 1.33333Z" fill="#505050"/>
                            </svg>
                        </i>

                        <i class="ml-4" @click="editContactClick(index)">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0.5 12.55V15.0833C0.5 15.3167 0.683333 15.5 0.916667 15.5H3.45C3.55833 15.5 3.66667 15.4583 3.74167 15.375L12.8417 6.28334L9.71667 3.15834L0.625 12.25C0.541667 12.3333 0.5 12.4333 0.5 12.55ZM15.2583 3.86667C15.5833 3.54167 15.5833 3.01667 15.2583 2.69167L13.3083 0.741675C12.9833 0.416675 12.4583 0.416675 12.1333 0.741675L10.6083 2.26667L13.7333 5.39167L15.2583 3.86667Z" fill="#505050"/>
                            </svg>
                        </i>

                        <i class="ml-4"  @click="modal_contact=false">
                            <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.25 0.758309C10.925 0.433309 10.4 0.433309 10.075 0.758309L5.99998 4.82498L1.92498 0.749976C1.59998 0.424976 1.07498 0.424976 0.749976 0.749976C0.424976 1.07498 0.424976 1.59998 0.749976 1.92498L4.82498 5.99998L0.749976 10.075C0.424976 10.4 0.424976 10.925 0.749976 11.25C1.07498 11.575 1.59998 11.575 1.92498 11.25L5.99998 7.17498L10.075 11.25C10.4 11.575 10.925 11.575 11.25 11.25C11.575 10.925 11.575 10.4 11.25 10.075L7.17498 5.99998L11.25 1.92498C11.5666 1.60831 11.5666 1.07498 11.25 0.758309Z" fill="#505050"/>
                            </svg>
                        </i>
                    </div>
            </template>

            <div class="contact-details row ml-5 mt-3">
                    <div class="text-right mr-3">
                        <p >Email:</p>
                        <p >Telefone:</p>
                        <p >Endereço:</p>
                        <p >Bairro:</p>
                        <p >Cidade:</p>
                        <p >Estado:</p>
                    </div>
                    <div>
                     <p ><span v-if="contactData.email">{{contactData.email}}</span> <span v-else>-</span> </p>
                     <p ><span v-if="contactData.email">{{contactData.phone}}</span> <span v-else>-</span> </p>
                     <p><span v-if="contactData.address">{{contactData.address}}</span> <span v-else>-</span></p>
                     <p><span v-if="contactData">{{contactData.district}}</span> <span v-else>-</span></p>
                     <p><span v-if="contactData" >{{contactData.city}}</span> <span v-else>-</span></p>
                     <p><span v-if="contactData" >{{contactData.state}}</span> <span v-else>-</span></p>
                     </div>
                
            </div>
        </b-modal>
    </div>
</template>

<script>
    import FormGroup from "@/components/molecules/FormGroup";

    import axios from "axios"


    export default {
        name: "ContactList",

        components: {
            FormGroup,
        },

        data() {
            return {
                modal_contact: false,
                modal_contact_delete: false,

                contactData: {
                    name:'',
                    email:'',
                    phone:'',
                    address:'',
                    district:'',
                    city:'',
                    state:''
                },
                index : -1 // identifica o contato no evendo dentro do modal
            }
        },
        
        props:{
            contactList: Array,
            base_url: String
        },

        methods:{
            editContactClick(index){
                this.contactData = this.contactList[index]
                this.$emit('key-modal-contact-form', { keyModalContactForm: true, contactData: JSON.stringify(this.contactData)});
            },

            delectContactClick(index){
                
                this.contactData = this.contactList[index]
                this.modal_contact = false
                this.modal_contact_delete = true
            },

            detalheContactClick(index){
                this.contactData = this.contactList[index];
                this.modal_contact = true
                this.index = index
            },

            async deletContact(){
                var access_token = localStorage.getItem('access_token')
                if(access_token){
                    var access_token = localStorage.getItem('access_token')
                    var BASE_URL = this.base_url;

                    var config = {
                        headers: {
                            Authorization: `Bearer ${access_token}`,
                        },
                    };

                    var responseData = await axios.get(`${BASE_URL}/contact/delete/${this.contactData.id}`, config).then( (response) => { return response.data } );
                    console.log("ResponserData",responseData.status);

                    if(responseData.status == "success"){
                        this.modal_contact_delete = false;
                        this.$emit('key-modal-contact-form', { contactList: responseData.data.contactList});
                        alert("Contato excluido com sucesso")
                    }
                    else if(responseData.status == 'Token is Expired'){
                        alert("Sua sessão exprirou, faça login novamente e tente de novo.")
                        this.$router.push({ path: '/login' })
                    }
                    else{
                        alert('Erro inesperado, tente novamente mais tarde')
                    }
                }
            },

            
        },

        mounted(){
            
        }
    }
    
</script>

<style lang="scss">

    .contact-list{
        margin-top: -10px;
        .card{
          height: 56px;
          border-radius: 16px;
          box-shadow: none!important;;
        }
        .card :hover{
            background-color: #F8F8F8;
            cursor: pointer;
        }

        .card-body{
            padding-top: 12px!important;
        }
        
        .iten{
            img {
                width: 32px;
                height: 32px;
            }
            
            span{
                font-family: $headings-font-family;
                font-style: normal;
                font-weight: normal;
                font-size: 14px;
                line-height: 18px;
                /* identical to box height, or 129% */

                display: flex;
                align-items: center;
                letter-spacing: 0.25px;
                color: #262626
            }

            .option{
                margin-left: auto;
            }
            .option  :hover{
                fill: $primary
            }
        }

        .col-name{
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            word-wrap: hyphenate;
            max-width: 300px;
            display: block;
        }
        .col-name  span{
            overflow: hidden;
        }

        
    }

    #modal-contact{
        .modal-content{
            border-radius: 12px;
            position: relative;
            border: 1px solid #E1E1E1;
            box-sizing: border-box;
            box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.15);
        }

        .modal-contact-name{
            h4{
                font-family: $headings-font-family;
                font-style: normal;
                font-weight: 500;
                font-size: 20px!important;
                line-height: 28px;
                /* identical to box height, or 140% */

                display: flex;
                align-items: center;
                letter-spacing: 0.15px;

                /* mine-shaft/700 */

                color: #262626;
            }
        }

        .modal-contact-options i{
            cursor: pointer;
        }

        .contact-details{
            p{
                font-family: $headings-font-family;
                font-style: normal;
                font-weight: 500;
                font-size: 12px;
                line-height: 16px;
                /* identical to box height, or 133% */

                letter-spacing: 0.4px;

                /* mine-shaft/100 */

                color: #757575;
            }

            span{
                font-family:  $headings-font-family;
                font-style: normal;
                font-weight: normal;
                font-size: 14px;
                line-height: 16px;
                /* identical to box height, or 129% */

                display: flex;
                align-items: center;
                letter-spacing: 0.25px;

                /* mine-shaft/700 */

                color: #262626;
            }
        }
    }

    #modal-contact-delete{
        .modal-content{
            min-width: 360px;
            min-height: 144px;
            padding-left: 24px;
            padding-right: 24px;
            padding-bottom: 25px;
            padding-top: 8px;
            border-radius: 12px;
            position: relative;
            border: 1px solid #E1E1E1;
            box-sizing: border-box;
            box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.15);
        }
        .title h4{
            font-family: $headings-font-family;
            font-style: normal;
            font-weight: 500;
            font-size: 20px;
            /* identical to box height, or 140% */

            
            letter-spacing: 0.15px;
        }

        .footer{
            text-align: right;
            position: absolute;
            bottom: 0;
            width: 100%;

            .options{
                margin-left: auto;

                a{
                    font-family: $headings-font-family;
                    font-style: normal;
                    font-weight: 500;
                    font-size: 14px;
                    line-height: 18px;
                    letter-spacing: 1.25px;
                    color: #505050;
                    cursor: pointer;
                }

                .delete{
                    color: #DE321B;
                }
            }
        }
    }

    #modal-contact___BV_modal_outer_{
        z-index: 1039!important;
    }

</style>