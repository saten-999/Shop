<template>
    <div class="contact-list">
        <ul >
            <li v-for="contact in sortedContact" :key="contact.id" @click="selectContact(contact)" :class="{ 'selected': contact == selected}">
                {{ contact.name }} 
                <br>
                {{ contact.email }}
                <span class="unread" v-if="contact.unread">
                {{ contact.unread}}
                </span>
            </li>
            
        </ul>
    </div>
</template>

<script>
    export default {
        props: {
            contacts:{
                type: Array,
                default: []
            }
        },
        data(){
            return{
              selected : this.contacts.length ?  this.contacts[0] :null
            };
        },
        methods: {
            selectContact( contact) {
                this.selected = contact
                this.$emit('selected', contact)
            }
        },
        computed:{
            sortedContact(){
                return _.sortBy(this.contacts, [
                    (contact) => {
                        if(contact == this.selected){
                            return Infinity;
                        }
                        return contact.unread}
                ]).reverse()
            }
        }
    }
</script>
<style>
.contact-list{
    overflow-y: scroll;
    height: 300px;
    width: 30%;
}
.contact-list ul{
    list-style: none;
    padding: 0;
  
}
.contact-list li{
    border: 1px solid gray;
    padding: 5px;
    margin: 5px;
}
.selected{
    background-color: aliceblue;
}
.unread{
    background-color:mediumseagreen;
    color: white;
    border-radius: 50%;
    padding: 1px 6px;
    float: right;
}
</style>