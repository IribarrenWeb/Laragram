<template>
    <div class="container-lg container-fluid px-1" id="upload-component">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card position-relative">

                    <!-- Loader -->
                    <div v-if="isLoading" class="loader-card d-flex justify-content-center align-items-center">
                        <div class="spinner-grow text-primary" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                    <!-- End loader -->

                    <div class="card-body">
                        <div class="text-center">
                            <img :src="isLoad ? preview : 'https://via.placeholder.com/350'" class="rounded prevImg shadow">
                            <hr>
                        </div>
                        <div class="form-group row">
                            <label for="image" class="col-form-label col-md-3 text-md-right">Imagen</label>

                            <div class="col-md-7">
                                <input v-if="isLoad" type="text" class="form-control" :value="file.name" disabled>

                                <div class="buttons">
                                    <button v-if="!isLoad" @click="$refs.image.click()" class="btn btn-sm btn-block btn-primary">Seleccionar imagen</button>
                                    <button v-else @click="cancel" class="btn btn-sm btn-block mt-2 btn-danger">Cancelar</button>
                                </div>
                                <!-- <span class="invalid-feedback" role="alert">
                                    <strong></strong>
                                </span> -->
                            </div>
                            <input ref="image" class="form-control" type="file" name="image" v-show="false" @input="selectImg"/>
                        </div>

                        <div class="form-group row">
                            <label for="description" class="col-form-label col-md-3 text-md-right">Descripcion</label>
                            <div class="col-md-7">
                                <textarea v-model="descripcion" 
                                    @focusin="hideErrors" 
                                    name="description" 
                                    class="form-control" 
                                    :class="{'is-invalid' : typeof errors.description != 'undefined'}" 
                                    @keypress.enter.prevent="upload"
                                    @input="hideErrors"
                                    wrap="true">
                                </textarea>
                                <span v-if="typeof errors.description != 'undefined'" class="invalid-feedback" role="alert">
                                    <strong>{{errors.description[0]}}</strong>
                                </span>
                            </div>
                        </div>

                        <div v-if="isLoad" class="col-md-7 offset-3 pl-2">
                            <button @click="upload" class="btn btn-success btn-sm">Publicar imagen</button>
                        </div>
                </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
export default {
    props: ['dataUser'],
    data() {
        return {
            preview: '',
            isLoad: false,
            isLoading: false,
            file: null,
            descripcion: '',
            errors: [],
            user: []
        }
    },
    created() {
        this.user = JSON.parse(this.dataUser);
    },
    methods: {
        selectImg(e){
            let image = e.target.files[0];

            if (!image.type.match('image.*')) {
                this.$toastr.e("ERRROR",'La imagen no es valida!');

                return
            }

            let reader = new FileReader

            reader.readAsDataURL(image)
            reader.onload = e =>{
                this.preview = e.target.result
                this.isLoad = true
                this.file = image
            }
        },
        upload(){
            if(this.file && this.descripcion.length > 0){
                this.isLoading = true;
                let data = new FormData,
                    t = this
                data.append('image_path',this.file)
                data.append('description',this.descripcion)

                axios.post('/image/save',data).then(res => {
                    this.isLoading = false
                    if(!res.data.status){
                        t.errors = res.data.errors
                        this.$toastr.e("ERRROR",'Algunos datos no son validos');
                    }else{
                        window.location.assign(`/user/${t.user.nick}`)
                    }
                })
            }else{
                this.$toastr.e("ERRROR",'Los campos no estan completos');
            }
        },
        cancel(){
            this.preview =  ''
            this.isLoad = false
            this.isLoading = false
            this.file = null
            this.descripcion = ''
        },
        hideErrors(e){
            let element = e.target,
                name = element.name

            if(typeof this.errors[name] !== 'undefined'){
                element.classList.remove('is-invalid')
                this.errors[name] = undefined
            }
        }
    },
}
</script>

