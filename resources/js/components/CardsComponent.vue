<template>
  <div class="container">
    
    <!-- Bucle foreach to show image cards -->
    <div v-for="(image, index) in images" :key="index">
      
      <!-- Incluir componente de card -->
      <imageCard :image-data="image" :user-data="user"/>
  
    </div>
    <!-- End bucle foreach -->

    <infinite-loading @infinite="infiniteHandler">
      <div class="card mb-4 p-4" slot="no-more">
        No hay mas datos para cargar.
      </div>
    </infinite-loading>
  
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
      }
    },
    methods: {
      async getImages(){
        let response = await axios.get(`${globalPath}/getimages`)
        this.images = response.data.data
      },

      infiniteHandler($state){
        let page = this.images.length / 5 + 1;

        axios.get(`${globalPath}/getimages`,{params: {page: page} })
          .then(res => {

            if (res.data.data.length) {

              this.images.push(...res.data.data)
              setTimeout(() => {
                $state.loaded()
              }, 5000)

              if (res.data.total == this.images.length) {
                $state.complete();
              }

            } else {
              $state.complete();
            }

          })
      }
    },
    components:{
      imageCard,
      InfiniteLoading
    },
    mounted() {
      // mounted
    },
    created() {
      this.getImages()
      this.user = JSON.parse(this.dataUser);
    },
  };
</script>
