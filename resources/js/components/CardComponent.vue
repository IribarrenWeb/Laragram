<template>
  <div>
    {{imagesData}}
    <!-- Bucle foreach to show image cards -->
    <!-- <div v-for="(image, index) in images" :key="index"> -->
  
      <!-- Incluir componente de card -->
      <!-- {{image}} -->
  
    <!-- </div> -->
    <!-- End bucle foreach -->
    mieeeeeeeeeerdaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
  </div>
</template>

<script>
export default {
  name: "example",
  props:[
    'ser'
  ],
  mounted() {
    console.log(this.ser);
  }
};
</script>
