<template>
  <div class="container" id="cards-component">
    
    <div class="row" ref="imgrow">

      <div class="first-container mx-auto">
        <div v-if="images.length > 0">
        
          <!-- Bucle foreach to show image cards -->
          <div v-for="(image, index) in images" :key="index">
            
            <!-- Incluir componente de card -->
            <imageCard :image-data="image" :user-data="user" :image-width="imageWidth"/>
        
          </div>
          <!-- End bucle foreach -->
        
          <infinite-loading v-if="totalImages > 4" @infinite="infiniteHandler">
            <div class="card mb-4 p-4 no-more mx-auto" slot="no-more">
              No hay mas datos para cargar.
            </div>
          </infinite-loading>
      
        </div>

        <div v-else>
          <div class="card text-center no-more mt-5 mx-auto">
            <div class="card-body d-block">
              <h4 class="card-title">Aun no hay post para mostrar</h4>
              <a class="card-text text-decoration-none" href="/image/subir">Subir una Imagen</a>
            </div>
          </div>
        </div>

      </div>

      <aside :style="{width: asideWidth}" class="aside-container d-none d-lg-block" ref="aside">
        <div :style="{width: asideWidth}" :class="{'scrollClass':checkScroll}">
          <div class="d-flex align-items-center">
            <img class="avatar avatar-med" :src="userImage" :alt="user.name">
            <strong class="ml-3">{{user.nick}}</strong>
          </div>
          <div class="card mt-4">
            <div class="card-header bg-white">
              <strong>Opciones</strong>
            </div>
            <div class="card-body p-0">
              <ul class="list-group">
                <li class="list-group-item border-0"><a href="/image/subir">Subir imagen</a></li>
                <li class="list-group-item border-0"><a :href="'/user/' + user.nick">Mi cuenta</a></li>
                <li class="list-group-item border-0"><a class="text-danger" href="/logout">Salir</a></li>
              </ul>
            </div>
          </div>
        </div>
      </aside>

    </div>

  </div>
</template>

<script>

  import imageCard from './ImagesComponents'
  import InfiniteLoading from 'vue-infinite-loading';

  const globalPath = window.location.origin;

  export default {
    props:[
      'dataUser',
      'dataImages'
    ],
    data() {
      return {
        images: [],
        user: null,
        checkScroll: false,
        asideWidth: null,
        color: 'redsaas',
        imageWidth: false,
        totalImages: null
      }
    },
    methods: {
      async getImages(){
        let response = await axios.get(`${globalPath}/getimages`)
        this.images = response.data.data
        this.totalImages = response.data.total
      },

      infiniteHandler($state){
        let page = this.images.length / 4 + 1;

        axios.get(`${globalPath}/getimages`,{params: {page: page} })
          .then(res => {
            if (res.data.data.length) {

              this.images.push(...res.data.data)

              $state.loaded();

              if (res.data.total == this.images.length) {
                $state.complete();
              }

            } else {
              $state.complete();
            }

          })
      },
      getWidth(refname, op = false){

        let width = refname.clientWidth + 'px'
        
        if(op){
          return width
        }

        this.asideWidth = width
      },
      responsiveWidth(width){
        if(width <= 768){
          this.imageWidth = {
              width:300 + 'px',
              maxWidth: this.getWidth(this.$refs.imgrow,true)
            }
        }
      },
      handlerScroll(event){
        if(window.scrollY >= 20){
          this.checkScroll = true
        }else{
          this.checkScroll = false
        }
      },
      handlerResize(event){
        this.getWidth(this.$refs.aside)
        this.responsiveWidth(window.innerWidth)
      }
    },
    components:{
      imageCard,
      InfiniteLoading
    },
    computed: {
      userImage(){
        return `/user/avatar/${this.user.image}`
      }
    },
    mounted() {
      this.getWidth(this.$refs.aside)
      this.responsiveWidth(window.innerWidth)
    },
    created() {
      this.getImages()

      this.user = JSON.parse(this.dataUser);
      window.addEventListener('scroll',this.handlerScroll)
      window.addEventListener('resize',this.handlerResize)
    },
    destroyed(){
      window.removeEventListener('scroll',this.handlerScroll)
      window.removeEventListener('resize',this.handlerResize)
    }
  };
</script>