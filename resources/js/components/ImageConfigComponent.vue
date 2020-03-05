<template>
    <div>
        <div class="card-header text-center">Cambiar imagen</div>
        <div class="card-body">
            <div v-if="userData.image" class="container">
                <img
                    class="mx-auto mt-3 mb-5 d-block avatar-big rounded-circle"
                    :src="avatar"
                    :alt="userData.name + 'avatar'"
                />
            </div>
            <!-- Imagen avatar -->
            <div class="form-group">
                <label for="image_path">Avatar</label>
                <input class="form-control" v-if="selected" type="text" :value="imageName" disabled>
                <hr>

                <div>
                    <button v-if="!selected" @click="$refs.image_path.click()" class="btn btn-block btn-success">Select image</button>
                    <div v-else>
                        <button class="btn btn-block btn-primary" :class="{'disabled' : isLoading}" :disabled="isLoading" @click="update">
                            <span v-if="!isLoading">Update avatar</span>
                            <div v-else>
                                <span class="spinner-border spinner-border-sm text-light" role="status"></span>
                                Loading...
                            </div>
                        </button>
                        <button class="btn btn-block btn-danger" :class="{'disabled' : isLoading}" :disabled="isLoading" @click="cancel">Cancelar</button>
                    </div>
                </div>
                
                <input
                ref="image_path"
                type="file"
                class="d-none"
                :class="errors.image_path ? ' is-invalid' : ''"
                @input="validateImg"
                />
                <span v-if="errors.image_path"
                class="invalid-feedback"
                role="alert"
                >
                    <strong>{{errors.image_path}}</strong>
                </span>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props:['userData'],
    data() {
        return {
            errors: [],
            file: false,
            imageName: '',
            selected: false,
            upFile: null,
            isLoading: false,
        }
    },
    methods: {
        validateImg(e){
            let image = e.target.files[0];

            if (!image.type.match('image.*')) {
                this.$toastr.e("La imagen no es valida!",'ERRROR');

                return
            }
            let reader = new FileReader

            reader.readAsDataURL(image);
            reader.onload = e => {
                this.file = e.target.result
                this.imageName = image.name
                this.selected = true
                this.upFile = image
            }
            this.$toastr.s("Imagen valida!",'SUCCESS');
        },
        update(){
            let form = new FormData

            form.append('image',this.upFile)

            this.isLoading = true;

            axios.post('/user/update', form).then(res => {
                this.isLoading = false
                if(res.data.status){
                    this.$toastr.s("Imagen actualizada.",'SUCCESS');
                    setTimeout(() => {
                        window.location.reload()
                    }, 3000);
                }else{
                    this.$toastr.e('No se ha podido actualizar la imagen', 'ERROR')
                }
            }).catch(error => {
                this.$toastr.e('Error en el servidor.', 'ERROR')
            }) 
            
        },
        cancel(){
            this.file = false,
            this.imageName = '',
            this.selected = false,
            this.upFile = null
        }
    },
    computed: {
        avatar(){
            if(!this.file){
                return '/user/avatar/' + this.userData.image
            }

            return this.file
        }
    },
}
</script>
