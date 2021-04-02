<template>
    <div class="chat" v-on:click="openchat">
            <span class="unread">{{unread_count==0? '' :unread_count}}</span>
            <i class="fas fa-comment"></i>
        </div>
        
</template>

<script>
import ChatApp from './ChatApp'
    export default {
        props: {
            user: {
                type: Object,
                required: true
            }
        },
        data(){
            return{
                unread_count:null,
                admin: {
                    type: Object,
                },
            };
        },
        methods:{               
          openchat(){
              axios.put(`/admin/conversation/update/${this.admin.id}/${this.user.id}`)
                             .then((response) => {
                                  this.unread_count = null
                             })
              this.$emit('showchat')
          }
        },
        watch:{
          
        },
        mounted() {
            window.Echo.private(`messages.${this.user.id}`)
                .listen('MessageSentEvent',(e)=>{
                   this.unread_count++ 
                })
           axios.get(`/chat/unreadcount/${this.user.id }`)
                              .then((response)=>{
                                    this.unread_count = response.data
                                })

            axios.get('/chat/onlineadmin')
                 .then((response) => {
                        this.admin = response.data[0]
                       
                     })    
        },

    }
</script>
