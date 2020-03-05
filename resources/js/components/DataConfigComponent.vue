<template>
  <div class="config-container">
      <!-- Init card -->
    
      <div class="card-header text-center">Configurar mi cuenta</div>

      <div class="card-body" @keydown.enter="sendUpdates">
        <!-- Name -->
        <div class="form-group">

            <label for="name">Name:</label>
            <input
              id="name"
              type="text"
              class="form-control"
              :class="errors.name ? ' is-invalid' : ''"
              v-model="user.name"
              required
              autofocus
              placeholder="Name"
            />
            <!-- <p>Compare data: {{oldData.name}}, user data: {{user.name}}</p> -->

            <span v-if="errors.name" class="invalid-feedback" role="alert">
              <strong class="d-block" v-for="(message, index) in errors.name" :key="index">{{ message}}</strong>
            </span>

        </div>

        <!-- Surname -->
        <div class="form-group">

            <label for="surname">Surname:</label>
            <input
              id="surname"
              type="text"
              class="form-control"
              :class="errors.surname ? ' is-invalid' : ''"
              v-model="user.surname"
              required
              autofocus
              placeholder="Surname"
            />

            <span v-if="errors.surname" class="invalid-feedback" role="alert">
              <strong class="d-block">{{ errors.surname }}</strong>
            </span>

        </div>

        <!-- Nick -->
        <div class="form-group">
            <label for="nick">Nick:</label>
            <input
              id="nick"
              type="text"
              class="form-control"
              :class="errors.nick ? ' is-invalid' : ''"
              v-model="user.nick"
              required
              autofocus
              placeholder="Nick"
            />

            <span v-if="errors.nick" class="invalid-feedback" role="alert">
              <strong class="d-block">{{ errors.nick }}</strong>
            </span>

        </div>

        <!-- Email -->
        <div class="form-group">
            <label for="email">Email:</label>
            <input
              id="email"
              type="email"
              class="form-control"
              :class="errors.email ? ' is-invalid' : ''"
              v-model="user.email"
              placeholder="E-mail"  
              required
            />

            <span v-if="errors.email" class="invalid-feedback" role="alert">
              <strong class="d-block">{{ errors.email}}</strong>
            </span>
        
        </div>

        <!-- Button -->
        <div class="form-group row mb-0">
          <div class="col-md-6">
            <button class="btn btn-primary" :disabled="disabled" @click.prevent="sendUpdates()">
              <span v-if="isLoad" class="spinner-border spinner-border-sm text-light"></span>
              {{isLoad ? 'Cargando...' : 'Actualizar'}}
            </button>
          </div>
        </div>
      </div>
    <!-- Ends Card -->

  </div>
</template>

<script>
export default {
    props: {
      userData:{
        required: true,
      },
      oldData:{
        required: false
      }
    },
    data() {
      return {
        errors: {},
        dataOrigin: {},
        disabled: true,
        isLoad: false
      }
    },
    methods: {
      checkData(){
        if(JSON.stringify(this.compareData) == JSON.stringify(this.user)){
          this.disabled = true
        }else{
          this.disabled = false
        }
        return this.disabled
      },
      sendUpdates(){
        if(!this.checkData()){
          this.isLoad = true
          this.disabled = true
          axios.post('/user/update', {
            name: this.user.name,
            surname: this.user.surname,
            nick: this.user.nick,
            email: this.user.email
          })
          .then(res => {
            this.isLoad = false
            if(res.data.errors){
              this.errors = res.data.errors
            }else{
              if (res.data.status) {
                this.$toastr.s('Datos actualizados, recargando la pagina...','SUCCESS')
                setTimeout(() => {
                  window.location.reload()
                }, 3000);
              }else{
                this.$toastr.e('Los datos no pudieron ser actualizados.','ERROR')
              }
              
            }
          })
          .catch( error => {
            this.isLoad = false
            this.$toastr.e('Error en el servidor.','ERROR')
          })
          
        }
      }
    },
    computed: {
      compareData(){
        return JSON.parse(JSON.stringify(this.oldData))
      },
      user(){
        return this.userData
      }
    },
    created(){
      // this.user = this.userData
      // this.checkData();
    },
    watch:{
        'user.nick'(){
            this.checkData();
        },
        'user.name'(){
            this.checkData();
        },
        'user.surname'(){
            this.checkData();
        },
        'user.email'(){
            this.checkData();
        },
    }
}
</script>

