<template>
    <div>
        <div class="card-header">
            Cambiar contraseña
        </div>
        <div class="card-body">
            <!-- Password -->
            <div class="form-group">
                <label for="nick">Password:</label>
                <input
                    id="password"
                    type="text"
                    class="form-control"
                    :class="errors.password ? ' is-invalid' : ''"
                    v-model="password"
                    required
                    autofocus
                    placeholder="Password"
                />

                <span v-if="errors.password != false" class="invalid-feedback" role="alert">
                    <strong>{{ errors.password }}</strong>
                </span>

            </div>

            <!-- NewPassword -->
            <div class="form-group">
                <label for="nick">New password:</label>
                <input
                    id="password"
                    type="text"
                    class="form-control"
                    :class="isValid.pass1.class"
                    v-model="repassword.pass1"
                    required
                    autofocus
                    placeholder="Password"
                />
                <span v-if="isValid.pass1.message != false" class="invalid-feedback" role="alert">
                    <strong>{{ isValid.pass1.message }}</strong>
                </span>

            </div>
            
            <!-- Re-NewPassword -->
            <div class="form-group">
                <label for="nick">Confirm password:</label>
                <input
                    id="password"
                    type="text"
                    class="form-control"
                    :class="isValid.pass2.class"
                    v-model="repassword.pass2"
                    required
                    autofocus
                    placeholder="Confirm password"
                />

                <span v-if="isValid.pass2.message != false" class="invalid-feedback" role="alert">
                    <strong>{{ isValid.pass2.message }}</strong>
                </span>

            </div>
            <button class="btn btn-primary" @click="checkPass(true,true)">
                <span v-if="isLoad" class="spinner-border spinner-border-sm text-light" role="status"></span>
                {{ isLoad ? 'Cargando...' : 'Enviar' }}
            </button>
        </div>

    </div>
</template>

<script>
export default {
    props: ['userData'],
    data() {
        return {
            password: '',
            repassword: {
                pass1: '',
                pass2: ''
            },
            isValid:{
                pass1: {
                    message: false,
                    class: ''
                },
                pass2: {
                    message: false,
                    class: ''
                }
            },
            errors: {},
            isLoad: false
        }
    },
    methods: {
        checkPass(op = null, send = false){

            if(this.repassword.pass1.length == 0){
            
                this.isValid.pass1.class = 'is-invalid'
                this.isValid.pass1.message = 'La contrasena esta vacia'

            }else if(this.repassword.pass1.length > 0){
                
                this.isValid.pass1.class = 'is-valid'
                this.isValid.pass1.message = false
                
                if(this.repassword.pass1 != this.repassword.pass2){
                    
                    this.isValid.pass2.class = 'is-invalid'
                    this.isValid.pass2.message = 'Las contraseñas no coinciden'
                
                }else if(this.repassword.pass1 == this.repassword.pass2){
                    this.isValid.pass1.class = 'is-valid'
                    this.isValid.pass2.class = 'is-valid'

                    this.isValid.pass1.message = false
                    this.isValid.pass2.message = false

                }
            }

            if(op){
                if(this.password.length > 0){
                    this.errors.password = false

                    if(this.isValid.pass1.class == 'is-valid' && this.isValid.pass2.class == 'is-valid' && send){
                        this.isLoad = true
                        axios.post('/user/update', {
                             password: this.password,
                             repassword: this.repassword.pass1,
                             repassword2: this.repassword.pass2
                        }).then(res => {
                            this.isLoad = false
                            if(res.data.status){
                                this.$toastr.s("Password actualizado",'SUCCESS');
                            }else{
                                this.$toastr.e("Los datos no pudieron ser actualizados.",'ERRROR');
                            }
                        }).catch( error => {
                            this.isLoad = true
                            this.$toastr.e("Error en el servidor.",'ERROR');
                        });
                    }
                }else{
                    this.errors.password = 'El password esta vacio'
                }
            }
        }
    },
    watch:{
        'repassword.pass2'(){
            this.checkPass()
        },
        'repassword.pass1'(){
            this.checkPass()
        },
        'password'(){
            this.checkPass(true)
        }
    }
}
</script>