<template>
    <div id="card-sidebar" class="card-sidebar border-right d-sm-none d-md-block">
        <ul class="list-group list-group-flush">
            <li class="list-group-item" :class="(option == 'config') ? 'actives' : ''" @click="changeComponent('config')">Cambiar datos</li>
            <li class="list-group-item" :class="(option == 'image') ? 'actives' : ''" @click="changeComponent('image')">Cambiar imagen</li>
            <li class="list-group-item" :class="(option == 'pass') ? 'actives' : ''" @click="changeComponent('pass')">Cambiar contraseña</li>
        </ul>
    </div>
</template>
<script>
export default {
    data() {
        return {
            option: 'config'
        }
    },
    methods: {
        changeComponent(option){
            let componentName = ''
            if(option == 'config'){
                componentName = 'DataConfig'
            }else if(option == 'image'){
                componentName = 'ImageConfig'
            }else{
                componentName = 'PassConfig'
            }
            this.option = option
            this.$emit('activeComponent',componentName);
        }
    },
}
</script>
