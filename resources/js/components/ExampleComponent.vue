<template>
    <li class="breadcrumb-item active" id="crumb">{{ crumb }}</li>
</template>     
<script>
    export default {
        data(){
            return{
                crumb:this.$route.name,
            }
        }
    }
</script>