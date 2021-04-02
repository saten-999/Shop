<template>
    <div class="chat-app" ref="feed">
        <ul v-if="admin">
            <li v-for="message in messages" :class="`message${message.to == admin.id ? 'send' : 'reseved'}`" :key="message.id">
                <div class="text">
                    {{ message.text}}
                </div>
            </li>
        </ul>
       <div class="composer">
            <textarea v-model = "message" @keydown.enter="startConversation" placeholder ="Message..." ></textarea>
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
                    this.$refs.feed.scrollTop = this.$refs.feed.scrollHeight -this.$refs.feed.clientHeight;
                }, 50)
            }

//             updateUnreadCount(contact, reset){
//                 this.contacts = this.contacts.map((single)=>{
//                     if(single.id != contact.id){
//                         return single
//                     }

//                     if(reset){
//                         single.unread  = 0 
//                         axios.put(`/conversation/update/${single.id}`)
//                              .then((response) => {
                                  
//                              })
//                         }
//                     else{
//                         single.unread++
//                     }

//                     return single

//                 })
            },
//         },
        watch:{
            messages(messages){
                this.scrollToBottom()
            }
        },
        mounted() {
            console.log("saten")
            window.Echo.private(`messages.${this.user.id}`)
                .listen('MessageSentEvent',(e)=>{
                    console.log(e.message)
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
    max-height: 300px;
    overflow-x: scroll;
}
.chat-app li{
    list-style: none;
    border: 1px solid gray;
    padding: 5px;
    margin-top: 5px;
}

textarea, .composer{
    width: 100%;  
}

</style>