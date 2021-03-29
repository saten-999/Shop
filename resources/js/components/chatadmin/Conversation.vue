<template>
    <div class="conversation">
        <h5>{{ contact ? contact.name : 'Select a Contact'}}</h5>
        <messagesFeed :contact="contact"  :messages="messages"/>
        <messageComposer @send="sendmessage"/>

    </div>
</template>

<script>
import messagesFeed from './MessagesFeed'
import messageComposer from './MessageComposer'
    export default {
        props:{
            contact: {
                type: Object,
                default: null
            },
            messages: {
                type: Array,
            }
        },
        data(){
            return{
              
            };
        },
        methods:{
            sendmessage(text){
                if(! this.contact){
                    return;
                }

                axios.post('/admin/conversation/send',{
                    contact_id: this.contact.id,
                    text: text
                }).then( (response) => {
                    this.$emit('new', response.data)
                })
            }
        },
        components:{
            messagesFeed, messageComposer
        }
    }
</script>
<style >
    .conversation{
        width: 70%;
    }
</style>