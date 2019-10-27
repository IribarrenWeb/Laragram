<template>
  <div>
    <!-- Init card section  -->
    <div class="card card-home mb-5">

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
        <div class="ml-3 mr-2 my-auto">
          <strong class="text-capitalize">
            <a class="text-muted" href title>{{ imageData.user.name + imageData.user.surname }}</a>
          </strong>
        </div>
        <span class="border-left pl-2 my-auto">{{ imageData.user.nick }}</span>
      </div>
      <!-- END Card header  -->

      <!-- Card body -->
      <div class="card-body p-0">
        <div class="w-100 d-flex">
          <a class="d-block m-auto" :href="imageDetail" title>
            <img :src="imagePath" alt />
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

          <div v-if="comments.length >= 2 || comments.length != 0">
            <p class="mb-0 mt-2 comment">
              <a
                class="text-muted"
                :href="imageDetail"
                title
              >Ver los {{ totalComments }} comentarios.</a>
            </p>

            <div
              class="d-block comment_show mt-1"
              v-for="(comment, index) in comments"
              :key="index"
            >
              <p class="mb-0 d-inline-block">
                <img
                  class="mr-2 avatar rounded-circle"
                  :src="userImage(comment.user.image)"
                  height="500px"
                  alt
                />
                <strong class="d-inline-block mr-1">{{comment.user.nick}}</strong>
                {{ comment.content }}
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
    props: ["imageData", "userData"],
    components: {
      LikeComponent
    },
    data() {
      return {
        user: "",
        comments: [],
        totalComments: 0,
        text: ""
      };
    },
    methods: {

      async getComments() {

        let comments = [];

        let res = await axios.get(`/comment/get/${this.imageData.id}`)
        
        if (res.data.found) {
          for (let i = 0; i < 2; i++) {
            // console.log(res);
            comments[i] = res.data.comments[i];
          }
          this.comments = comments
        }
  
      },

      async sendComment(e) {
        e.preventDefault();
        
        const params = {
          content: this.text,
          id: this.imageData.id
        };

        await axios.post(`/comment/save`, params).then(res => {
          this.getComments();
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
      }
    },

    created() {
      this.getComments();

      this.totalComments = this.imageData.comments.length;
    }
  };
</script>