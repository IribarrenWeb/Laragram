<template>
  <div class="card card-container">
    <SidebarConfig class="d-none d-md-block" @activeComponent="componentOn = $event"></SidebarConfig>
    <component class="config-container" :is="componentOn" :user-data="user" :old-data="oldData" @changeData="changeUserData"></component>
  </div>
</template>

<script>

import SidebarConfig from './SidebarConfigComponent'
import DataConfig from './DataConfigComponent'
import ImageConfig from './ImageConfigComponent'
import PassConfig from './PassConfigComponent'

export default {
    props: {
        userData:{
            required: true,
        }
    },
    components:{
        SidebarConfig,
        DataConfig,
        ImageConfig,
        PassConfig
    },
    data() {
        return {
            oldData: {},
            user: {},
            componentOn: 'DataConfig' 
        }
    },
    methods: {
        changeUserData(event){
            this.oldData = JSON.parse(JSON.stringify(event))
            this.user = event
        },
        
    },
    created(){
        this.user = JSON.parse(this.userData)
        this.oldData = JSON.parse(this.userData)
    }
}
</script>

<style lang="scss" scoped>
    .card-container{
        flex-direction: row;
        min-height: 600px;
    }
    .config-container{
        flex:5;
    }
</style>

