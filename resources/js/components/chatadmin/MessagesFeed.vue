<template>
    <div class="feed" ref="feed">
        <ul v-if="contact" id=adm>
            <li v-for="message in messages" :class="`message${message.to == contact.id ? 'send' : 'reseved'}`" :key="message.id">
                <div class="text">
                    {{ message.text}}
                </div>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    props: {
            contact: {
                type: Object
            },
            messages: {
                type: Array,
            }
        },
    methods:{
        scrollToBottom(){
            setTimeout(()=>{
                this.$refs.feed.scrollTop = this.$refs.feed.scrollHeight - this.$refs.feed.clientHeight;
            }, 50)
            
        }
    },
    watch:{
        contact(contact){
            this.scrollToBottom()
        },
        messages(messages){
            this.scrollToBottom()
        }
    }
}
</script>

<style>
.messagesend{
    background-color: yellow;
    width: 70%;
    position: relative;
    left: 104px;


}
#adm .messagesend{
    background-color: yellow;
    width: 70%;
    position: relative;
    left: 223px;


}
.messagereseved{
    background-color:aquamarine;
    width: 70%;
    margin-left: 5px;
}
.feed{
    height: 100%;
    max-height: 300px;
    overflow-y: scroll;
}
.feed li{
    list-style: none;
    border: 1px solid gray;
    padding: 5px;
    margin-top: 5px;
}
ul{
    padding:  0;
}
</style>