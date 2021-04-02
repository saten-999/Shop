<template>
    <div class="chat-app" ref="feed">
       
        <div class="admin">
            <h5>Chat with {{admin.name}} </h5>
        </div>
        <div >
            <ul v-if="admin">
            <li v-for="message in messages" :class="`message${message.to == admin.id ? 'send' : 'reseved'}`" :key="message.id">
                <div class="text">
                    {{ message.text}}
                </div>
            </li>
        </ul>
       <div class="composer-user">
            <textarea v-model = "message" @keydown.enter="startConversation" placeholder ="Message..." ></textarea>
        </div>
       </div>
    </div>
        
</template>

<script>

    export default {
        props: {
            user: {
                type: Object,
                required: true
            }
        },
        data(){
            return{
                message: '',
                messages: [],
                admin: {
                    type: Object,
                },
            };
        },
        methods:{
            startConversation(e){
                
                e.preventDefault()
                if(this.message ==''){
                    return
                }
                axios.post('/admin/conversation/send',{
                    contact_id: this.admin.id,
                    text: this.message 
                }).then( (response) => {
                    this.saveNewMessage(response.data)
                })
                this.message = ''
               

            },
            saveNewMessage(message){

                this.messages.push(message)
                
            },
            handleIncoming(message){
                if(message.from == this.admin.id){
                    this.saveNewMessage(message)
                    return
                }
            },
            scrollToBottom(){
                setTimeout(()=>{
                    var messageDisplay = this.$refs.feed;
                    messageDisplay.scrollTop = messageDisplay.scrollHeight;
                }, 50)
            }

            },

        watch:{
            messages(messages){
                this.scrollToBottom()
            }
        },
        mounted() {
            this.scrollToBottom()
            window.Echo.private(`messages.${this.user.id}`)
                .listen('MessageSentEvent',(e)=>{
                   this.handleIncoming(e.message)
                })

            axios.get('/chat/onlineadmin')
                 .then((response) => {
                        this.admin = response.data[0]

                         axios.get(`/admin/conversation/${this.admin.id }`)
                              .then((response)=>{
                                    this.messages = response.data
                                })
                     })           
        },

    }
</script>
<style>
.chat-app{
    max-height: 400px;
    overflow-y: scroll;
    overflow-x: hidden;
}
.chat-app li{
    list-style: none;
    border: 1px solid gray;
    padding: 5px;
    margin-top: 5px;
    word-wrap: break-word;
    
}

textarea, .composer-user{
    width: 100%;  
    position: relative;
    top: 8px;
}
.admin{
    background-color: #d33b33;
    color: white;
    position: sticky;
    top: 0;
    z-index: 1;
    border: 1px solid gray;
}
.admin h5{
    color: white;
    margin-top: 10px;
}

</style>