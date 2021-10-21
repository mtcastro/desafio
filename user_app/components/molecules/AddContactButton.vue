<template>
    <div  class="add-contact">
        <b-button @click="showModalContactForm()"  variant="primary">
            <svg class="mr-2" width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M11 6.83335H6.83329V11C6.83329 11.4584 6.45829 11.8334 5.99996 11.8334C5.54163 11.8334 5.16663 11.4584 5.16663 11V6.83335H0.999959C0.541626 6.83335 0.166626 6.45835 0.166626 6.00002C0.166626 5.54169 0.541626 5.16669 0.999959 5.16669H5.16663V1.00002C5.16663 0.541687 5.54163 0.166687 5.99996 0.166687C6.45829 0.166687 6.83329 0.541687 6.83329 1.00002V5.16669H11C11.4583 5.16669 11.8333 5.54169 11.8333 6.00002C11.8333 6.45835 11.4583 6.83335 11 6.83335Z" fill="white"/>
            </svg>
            <samp>Adicionar contato</samp>
        </b-button>
    </div>
</template>

<script>
    export default {
        name: "AddContactButton",

        data() {
            return {
                contactData: {
                    name:'',
                    email:'',
                    phone:'',
                    address:'',
                    district:'',
                    city:'',
                    state:''
                },
            }
        },

        props:{
            keyModalContactForm: Boolean
        },
        
        methods:{
            showModalContactForm(){
                this.$emit('key-modal-contact-form', { keyModalContactForm: true, contactData: JSON.stringify(this.contactData)});
            }
        }
    }
    
</script>

<style lang="scss">

    .add-contact{
        
        button{
            border: none;
        }

        button, samp{
            font-family: $headings-font-family;
            font-style: normal;
            font-weight: 500;
            font-size: 14px;
            letter-spacing: 1.25px;
        }
    }
</style>