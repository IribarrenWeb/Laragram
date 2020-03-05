<template>
  <div
    class="col-md-4 d-none d-md-flex align-content-center position-relative"
    v-click-outside="hideResult" id="search-component"
  >
    <div class="position-relative m-auto">
      <input
      id="search"
      class="my-auto form-control form-control-sm text-center mx-md-auto"
      v-model="searchText"
      type="text"
      @input="searchQuery"
      @focusin="(searchText.length >= 2 && users.length >= 1) ? isResult = true : ''"
      placeholder="Busca"
      />

      <div v-if="isLoading" class="spinner-border position-absolute loader" role="status" aria-hidden="true"></div>
    </div>

    <!-- Result container -->
    <transition name="fade">
      <div v-show="isResult" id="search-result" class="bg-white">

        <!-- Reasult list -->
        <ul v-if="users.length >= 1" id="list-result" class="list-group">
          <li v-for="(user, index) in users" :key="index" class="d-flex align-items-center">
            <div class="d-flex">
              <div>
                <img class="avatar rounded-circle" :src="`/user/avatar/${user.image}`" alt />
              </div>
              <div class="ml-3">
                <span class="d-block">
                  <a
                    class="list-group-item-action"
                    :href="`/user/${user.nick}`"
                    title
                  >{{ user.nick }}</a>
                </span>
                <span class="d-block">{{ user.name + ' ' + user.surname}}</span>
              </div>
            </div>
          </li>
        </ul>
        <!-- END Reasult list -->

        <!-- No result show -->
        <div v-if="noResult" class="no-result">
          No hay resultados
        </div>
        <!-- No result show -->

      </div>
    </transition>
    <!-- END Result container -->

  </div>
</template>

<script>
import vClickOutside from "v-click-outside";

export default {
  directives: {
    clickOutside: vClickOutside.directive
  },
  data() {
    return {
      searchText: "",
      users: [],
      isLoading: false,
      isResult: false,
      click: false,
      noResult: false
    };
  },
  methods: {
    async searchQuery() {
      if (this.searchText.length >= 2) {
        
        this.isLoading = true;
        
        await axios.get(`/gente/${this.searchText}`).then(response => {
          this.isLoading = false;
          this.users = response.data.users;
          if(!this.users.length >= 1){
            this.noResult = true;
          }else{
            this.noResult = false
          }

          this.isResult = true;
        });
      } else {
        this.hideResult();
      }
    },
    hideResult() {
      if (this.isResult) this.isResult = false, this.noResult = false;
    }
  }
};
</script>