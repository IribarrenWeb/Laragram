<template>
  <div class="row h-100 mx-0">

      <!-- CARD IMAGE -->
      <div class="card col-md-8 detail-image px-0">
        <div class="card-body d-flex p-0">
          <div class="w-100 align-self-center">
            <img
              class="image h-100 w-100"
              :src="imagePath"
              alt
            @dblclick="like = true"/>
          </div>
        </div>
      </div>
      <!-- END CARD IMAGE -->
      
       <!-- SIDEBAR CARD -->
       <div class="card col-md-4 p-0 detail-sidebar">

           <!-- Init Row -->
           <div class="row h-100 mx-0">

               <!-- Card Header -->
                <div class="col-md-12 card-header bg-white d-flex">
                    
                    <!-- User info -->
                    <div class="d-flex w-75">
                        <img class="avatar rounded-circle" :src="userImage(image.user.image)" alt="">
                        <div class="ml-3 mr-2 my-auto">
                            <strong class="font-weight-bold">
                                <a class="text-decoration-none text-md" 
                                    :href="'/user/' + image.user.nick" 
                                    title="">
                                    {{ image.user.nick }}
                                </a>
                            </strong>
                        </div>
                    </div>
                    
                    <!-- Edit and delete options -->
                    <div v-if="image.user_id == user.id" class="w-50 mt-2 dropup">
                        <a id="dropedit" data-toggle="dropdown" href=""><i class="fas fa-ellipsis-h float-right text-dark"></i></a>
                        <div style="font-family: Helvetica Neue, Helvetica, Arial, sans-serif;" class="dropdown-menu" aria-labelledby="dropedit">
                            <a class="dropdown-item" 
                                :href=" globalPath + '/image/edit/' + image.id">
                                Editar
                            </a>
                            <a class="dropdown-item text-danger" data-toggle="modal" data-target="#modalDelete">Eliminar</a>
                        </div>
                    </div>
                    
                </div>
                <!-- End Card Header -->

                <!-- Card Body -->
                <div class="col-md-12 d-block px-3 pt-1 comment-section">

                    <!-- Header (Image info) -->
                    <div class="pt-2">
                        <div class="d-inline-block mr-3 mb-2">
                            <img class="avatar rounded-circle" 
                                :src="userImage(image.user.image)" 
                                :alt="image.user.name">
                        </div>
                        <strong class="d-inline-block mr-1">{{ image.user.nick }}</strong>
                        <p class="mb-0 d-inline-block">{{ image.description }}</p>
                        <hr class="mb-1">
                        <span class="text-capitalize text-monospace text-muted mb-3 d-block">
                            Comentarios ({{ totalComments }})
                        </span>
                    </div>

                    <!-- Body (comments) -->
                    <div v-for="(comment, index) in comments" :key="index" 
                        class="d-flex mb-2 position-relative">

                        <!-- Avatar image -->
                        <div class="mr-3">
                            <img class="avatar rounded-circle" 
                                :src="userImage(comment.user.image)" 
                                :alt="comment.user.name">
                        </div>

                        <!-- Comment content -->
                        <p class="mb-0 d-inline-block text-break">
                            <!-- Nick user comment -->
                            <strong class="d-inline-block mr-1 text-sm">
                                {{ comment.user.nick }}
                            </strong>
                            {{ comment.content }}
                            <br>
                            <!-- Countdiff and delete option -->
                            <span style="font-size: 16px;" class="text-capitalize text-monospace text-muted mb-0">
                                <!-- Mostrar tiempo aqui -->
                                <a v-if="comment.user.id == user.id || image.user.id == user.id"
                                    class="text-danger text-sm text-right text-lowercase cursor-pointer" 
                                    title=""
                                    @click="action('delete',comment.id)">eliminar</a>
                            </span>
                        </p>
                    </div>

                </div>
                <!-- End Card Body -->

                <!-- Card Footer -->
                <div class="col-md-12 align-items-baseline px-0">
                    
                    <!-- Likes section -->
                    <div class="border-top px-3 mx-0 py-2">
                        <LikeComponent class-advice="w-100 mt-1 mb-0"
                            :user="user"
                            :image="image"
                            :detectLike="like" 
                            @changeLike="like = $event"
                            class="icons d-flex w-100" 
                            id="container-set-info">
                        </LikeComponent>

                        <!-- Time counter -->
                        <!-- <div class="w-100 mt-4">
                            <p class="text-uppercase text text-monospace text-muted mb-0">
                                {{image.created_at}}
                            </p>
                        </div> -->
                    </div>

                    <!-- Form comment -->
                    <div class="comment w-100">
                        <form class="form_comment" accept-charset="utf-8" @submit.prevent="sendComment">
                            <div class="form-group d-flex mb-0 mt-2">
                                <textarea
                                    class="form-control rounded-bottom border-top border-bottom-0 border-left-0 border-right-0"
                                    type="text"
                                    name="content"
                                    value
                                    placeholder="Escribe un comentario"
                                    v-model="text"
                                    @keypress.enter="sendComment">
                                </textarea>
                                <div class="input-group-append border-top border-left">
                                    <button
                                        class="btn btn-sm bg-white text-primary font-weight-bold"
                                        type="submit"
                                        disabled>
                                        Post
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
                <!-- End Card Footer -->

           </div>
           <!-- End Row -->

       </div>
       <!-- END SIDEBAR CARD -->
    
  </div>
</template>

<script>

    import LikeComponent from './LikeComponent'

    export default {
        props: {
            dataImage: String,
            dataUser: String
        },
        data() {
            return {
                globalPath: window.location.origin,
                user: null,
                image: null,
                like: false,
                comments: [],
                text: '',
                totalComments: 0
            }
        },
        components: {
            LikeComponent
        },
        methods: {
            userImage(dataId) {
                return `${this.globalPath}/user/avatar/${dataId}`;
            },
            action(option, id = null) {
                if (option == 'delete' && id != null) {
                    axios.get(`${this.globalPath}/comment/delete/${id}/${this.image.id}`)
                        .then(res => {
                            this.getComments()
                            this.totalComments -= 1
                        })
                }
            },
            async getComments(){
                let comments = [];
                let res = await axios.get(`${this.globalPath}/comment/get/${this.image.id}`)
                
                if (res.data.found) {
                    for (let i = 0; i < res.data.comments.length; i++) {

                        comments[i] = res.data.comments[i];
                    }

                    this.comments = comments
                }
            },
            async sendComment(e) {
                e.preventDefault();
                
                const params = {
                    content: this.text,
                    id: this.image.id
                };

                await axios.post(`${this.globalPath}/comment/save`, params)
                .then(res => {
                    this.getComments();
                    this.text = "";
                    this.totalComments += 1;
                });
            },
        },
        computed: {
            imagePath() {
                return `${this.globalPath}/image/get/${this.image.image_path}`;
            }
        },
        created(){
            this.user = JSON.parse(this.dataUser);
            this.image = JSON.parse(this.dataImage);
            this.getComments()
            this.totalComments = this.image.comments.length;
        }
    };
</script>