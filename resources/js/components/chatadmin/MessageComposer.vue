<template>
    <div class="composer">
        <textarea v-model = "message" @keydown.enter="send" placeholder ="Message..." ></textarea>
    </div>
</template>

<script>
export default {
    data(){
        return{
            message: ''
        }
    },
    methods:{
        send(e){
            e.preventDefault()
            if(this.message ==''){
                return
            }
            this.$emit('send', this.message)
            this.message = ''
        }
    }
}
</script>
<style>
.composer{
    top: 0;
}
textarea{
    width: 100%;
  
}

</style>