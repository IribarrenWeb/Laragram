<template>
    <div>
       <!-- Likes  -->
        <div class="likes">
            <img :src="likepath" @click="changeLike"/>
        </div>

        <!-- Comments  -->
        <div class="comment">
            <img src="/images/comment.png"/>
        </div> 

        <!-- Advise -->
        <div style="font-weight:500" :class="classAdvice">               
            <p class="m-0 py-0" v-if="totalLikes > 0">
                Le gusta a <strong>{{ totalLikes }}</strong> personas
            </p>
            <p class="m-0 py-0" v-else>
                Se el primero en indicar que te gusta.
            </p>
        </div>
    </div>
</template>

<script>
    export default {
        props:['classAdvice', 'image', 'user', 'detectLike'],
        data() {
            return {
                totalLikes: 0,
                isLike: false,
                touch: false,
            }
        },
        methods: {
            checkLike() {
                this.image.likes.forEach(like => {
                    if (like.user_id == this.user.id) {
                        this.isLike = true
                    }
                });
            },

            changeLike(){
                axios.get(`/like/${this.image.id}`)
                    .then(res => {
                        this.isLike = !this.isLike
                        console.log(res.data.total);
                        this.totalLikes = res.data.total
                    })
            }
        },
        computed: {
            likepath(){
                let path = `/images/`
                if (this.isLike) {
                    path += 'likered.png' 
                }else{
                    path += 'like.png'
                }

                return path;
            }
        },
        created(){
            this.checkLike();

            this.totalLikes = this.image.likes.length

        },
        watch: {
            detectLike: function(){
                if (this.detectLike) {
                    this.changeLike();
                    this.$emit('changeLike',false)
                }
            }
        }
    }
</script>