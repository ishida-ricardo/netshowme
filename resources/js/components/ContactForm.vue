<template>
    <div class="contact-form">        
        <div class="row justify-content-md-center">
            <div class="col-md-6">
                <div v-if="formSuccess" class="alert alert-success" role="alert">
                    Contato enviado com sucesso!
                </div>
                <h3 class="text-center">Formulário de Contato</h3>        
                <form @submit.prevent="addPost">
                    <div class="form-group">
                        <label>Nome</label>
                        <input type="text" class="form-control" v-model="contact.name" required>
                        <small v-if="this.errors.name" id="nameHelp" class="form-text text-muted form-error">{{ this.errors.name[0] }}</small>
                    </div>
                    <div class="form-group">
                        <label>E-mail</label>
                        <input type="email" class="form-control" v-model="contact.email" required>
                        <small v-if="this.errors.email" id="emailHelp" class="form-text text-muted form-error">{{ this.errors.email[0] }}</small>
                    </div>
                    <div class="form-group">
                        <label>Telefone</label>
                        <the-mask :mask="['(##) #####-####']" class="form-control" v-model="contact.phone" required />
                        <small v-if="this.errors.phone" id="phoneHelp" class="form-text text-muted form-error">{{ this.errors.phone[0] }}</small>
                    </div>
                    <div class="form-group">
                        <label>Arquivo</label>
                        <input type="file" ref="fileupload" class="form-control" @change="handleFileChange($event)" required>
                        <small v-if="this.errors.file" id="fileHelp" class="form-text text-muted form-error">{{ this.errors.file[0] }}</small>
                    </div>
                    <div class="form-group">
                        <label>Mensagem</label>
                        <textarea class="form-control" v-model="contact.message" required></textarea>
                        <small v-if="this.errors.message" id="messageHelp" class="form-text text-muted form-error">{{ this.errors.message[0] }}</small>
                    </div>
                    <button type="submit" class="btn btn-primary">Enviar</button>                
                </form>
            </div>
        </div>
    </div>
</template>
 
<script>
    export default {
        data() {
            return {
                formSuccess: false,
                errors: {},
                contact: {},
            }
        },
        methods: {
            handleFileChange(evt) {
                this.contact.file = evt.target.files[0];
            },
            addPost() {
                const newContact = new FormData ()
                newContact.append('name', this.contact.name)
                newContact.append('email', this.contact.email)
                newContact.append('phone', this.contact.phone)
                newContact.append('file', this.contact.file)
                newContact.append('message', this.contact.message)

                window.axios
                    .post('http://localhost:8000/api/contacts', newContact, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    })
                    .then(response => {
                        this.contact = {};
                        this.errors = {};
                        this.$refs.fileupload.value=null;
                        this.formSuccess = true;
                    })
                    .catch(error => {
                        this.formSuccess = false;
                        this.errors = error.response.data.errors;
                    }) 
            }
        }
    }
</script>