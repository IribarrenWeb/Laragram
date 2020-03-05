<template>
  <div class="d-flex justify-content-center">
    <!-- Init card section  -->
    <div :style="widthImg" class="card card-home mb-5">

      <!-- Card header  -->
      <div class="card-header bg-white d-flex">
        <div class>
          <img
            class="avatar rounded-circle"
            :src="userImage(imageData.user.image)"
            height="500px"
            alt
          />
        </div>
        <!-- <div class="ml-3 mr-2 my-auto">
          <strong class="text-capitalize">
            <a class="text-muted" href= title>{{ imageData.user.name + imageData.user.surname }}</a>
          </strong>
        </div> -->
        <span class="ml-3 my-auto user-link"><a :href="`/user/${imageData.user.nick}`">{{ imageData.user.nick }}</a></span>
      </div>
      <!-- END Card header  -->

      <!-- Card body -->
      <div class="card-body p-0">
        <div class="w-100 d-flex">
          <a class="d-block m-sm-auto m-0" :href="imageDetail" title>
            <img 
            :style="widthImg"
            :src="imagePath" alt />
          </a>
        </div>
      </div>
      <!-- END Card body -->

      <!-- Card footer -->
      <div class="card-footer bg-white">

        <!-- Likes and comments icons  -->
        <LikeComponent class="d-flex mb-2 icons" 
            class-advice="mb-3 d-block info-likes w-100" 
            :user="userData" 
            :image="imageData">
        </LikeComponent>

        <!-- Show comments  -->
        <div class="d-block mt-3">
          <strong class="d-inline-block">{{ imageData.user.nick }} -</strong>
          <p class="mb-0 d-inline-block">{{ imageData.description }}</p>

          <div v-if="imageData.comments.length >= 1">
            <p class="mb-0 mt-2 comment">
              <a
                class="text-muted"
                :href="imageDetail"
                title
              >Ver los {{ imageData.comments.length }} comentarios.</a>
            </p>

            <div
              class="d-block comment_show mt-1"
            >
              <p class="mb-0 d-inline-block">
                <img
                  class="mr-2 avatar rounded-circle"
                  :src="userImage(comments.user.image)"
                  height="500px"
                  alt
                />
                <strong class="d-inline-block mr-1">{{comments.user.nick}}</strong>
                {{ comments.content }}
              </p>
            </div>
          </div>
        </div>

        <!-- Show hour  -->
        <div class="d-block time mt-2"></div>
      </div>
      <!-- END Card footer -->

      <!-- Form to post a comment -->
      <div class="comment">
        <form class="form_comment" accept-charset="utf-8" @submit.prevent="sendComment">
          <div class="form-group d-flex mb-0 mt-2">
            <textarea
              class="form-control rounded-bottom border-bottom-0 border-left-0 border-right-0"
              type="text"
              name="content"
              value
              placeholder="Escribe un comentario"
              v-model="text"
              @keypress.enter="sendComment"
            ></textarea>
            <div class="input-group-append border-top border-left">
              <button
                class="btn btn-sm bg-white text-primary font-weight-bold"
                type="submit"
                disabled
              >Post</button>
            </div>
          </div>
        </form>
      </div>
      <!-- END Form to post a comment -->
      
    </div>
  </div>
</template>

<script>

  import LikeComponent from './LikeComponent'

  export default {
    props: ["imageData", "userData", "imageWidth"],
    components: {
      LikeComponent
    },
    data() {
      return {
        user: "",
        text: "",
        imageComments: this.imageData.comments
      };
    },
    methods: {
      async sendComment(e) {
        e.preventDefault();
        
        const params = {
          content: this.text,
          id: this.imageData.id
        };

        await axios.post(`/comment/save`, params).then(res => {
          this.imageComments.push(res.data.comment)
          this.text = "";
          this.totalComments += 1;
        });
      },

      userImage(dataId) {
        return `/user/avatar/${dataId}`;
      }
    },
    computed: {
      imageDetail() {
        return `/image/detail/${this.imageData.id}`;
      },
      imagePath() {
        return `/image/get/${this.imageData.image_path}`;
      },
      widthImg(){
        if(this.imageWidth != false){
          return {'max-width': this.imageWidth.maxWidth}
        }
        return
      },
      comments(){
        if(this.imageComments.length == 0){
          return
        }
        let comments = _.orderBy(this.imageComments,'created_at','desc')
        return _.head(comments);
      },

    },

    created() {
      this.totalComments = this.imageComments.length;
    }
  };
</script>

<style lang="scss">
  .card-header {
    .user-link a{
      text-decoration: none;
      color: black;
    }
  }
</style>