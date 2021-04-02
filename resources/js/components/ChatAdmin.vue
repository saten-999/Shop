<template>
    <div class="chat-admin">
       <conversation :contact="selectedContact" :messages="messages"  @new = "saveNewMessage"/>
       <contactList :contacts="contacts" @selected="startConversationWith"/>
    </div>
</template>

<script>
import  conversation  from './chatadmin/Conversation';
import  contactList  from './chatadmin/ContactList';
    export default {
        props: {
            user: {
                type: Object,
                required: true
            }
        },
        data(){
            return{
                selectedContact: null,
                messages: [],
                contacts: [],
            };
        },
        methods:{
            startConversationWith(contact){
                this.updateUnreadCount(contact, true)
                axios.get(`/admin/conversation/${contact.id}`)
                     .then((response)=>{
                         this.messages = response.data
                         this.selectedContact = contact
                     })
            },

            saveNewMessage(message){

                this.messages.push(message)
            },
            handleIncoming(message){

                if(this.selectedContact && message.from == this.selectedContact.id){
                    this.saveNewMessage(message)
                    return
                
                }
                this.updateUnreadCount(message.from_contact, false)
            

                
            },

            updateUnreadCount(contact, reset){
                this.contacts = this.contacts.map((single)=>{
                    if(single.id != contact.id){
                        return single
                    }

                    if(reset){
                        single.unread  = 0 
                        axios.put(`/admin/conversation/update/${single.id}/${this.user.id}`)
                             .then((response) => {
                                  
                             })
                        }
                    else{
                        single.unread++
                    }

                    return single

                })
            }

            
        },
        mounted() {
            window.Echo.private(`messages.${this.user.id}`)
                .listen('MessageSentEvent',(e)=>{
                   this.handleIncoming(e.message)
                })

            axios.get('/admin/contacts')
                 .then(
                     (response) => {
                         this.contacts = response.data
                     }
                 )
        },
        components:{
            conversation, contactList
        }
    }
</script>
<style>
.chat-admin{
    display: flex;
}
</style>