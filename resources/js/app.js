/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */


require('./bootstrap');

window.Vue = require('vue');
import router from './routes';


Vue.component('auto-complete', require('./components/Autocomplete.vue').default);
Vue.component('chat-app', require('./components/ChatApp.vue').default);
Vue.component('chat-admin', require('./components/ChatAdmin.vue').default);
Vue.component('chat-icon', require('./components/Chaticon.vue').default);




const app = new Vue({
    router,
    el: '#app',
    data: {
        product: [],
        whishlist: [],
        subtotal:0,
        delivery:false,
        product_count: 0,
        whishlist_count: 0,
        status:'',
        showchat:false,
        additional: [],
      },
   methods:{
    change_order_count: function(product_id,index){

        axios.get('/cart/'+product_id+'/count/'+ this.product[index].order_count)
             .then((response) =>  this.sum())
    },
     addtocart: function(product_id){

      axios.get('/cart/'+product_id).then((response) => {
                            this.product_count=response.data
                            this.status = 'Added to cart'

                            setTimeout(() => {
                              this.status = ''
                            }, 1000);
                            
                          })
     
      
     },
     deletefromcart: function(index){

      this.product.splice(index,1);
     
      axios.get('/cart/delete/'+index).then((response) =>this.product_count= response.data  )

     },
     addtowhishlist: function(product_id){
      this.whishlist_count+=1
      axios.get('/product/wishlist/'+product_id).then((response) => {
            this.status = 'Added to wishlist'
            setTimeout(() => {
              this.status = ''
            }, 1000); 
   })
     
      
     },
     addtocartfromwhishlist: function(product_id,index){
      
      axios.get('/cart/'+product_id).then((response) => { console.log(response.data)
        this.product_count=response.data
        this.status = 'Added to cart'
        setTimeout(() => {
          this.status = ''
        }, 1000);
      })

      this.deletefromwhishlist(index);

     },
     deletefromwhishlist: function(index){

      this.whishlist.splice(index,1);
      
      axios.get('/product/wishlist/delete/'+index).then((response) =>console.log(response) )
     },
     openchat: function(){
        this.showchat= true
     },
     closechat(){
      this.showchat= false
     },
    sum: function(){
     
      this.subtotal = 0
      if(this.product.length>0){
          this.product.forEach((element) => {

            this.subtotal  += (element.price * element.order_count)
        });

        return this.subtotal
      }
      else{
        return;
      }
     }
     

   },
   watch: {
     additional(newValue, oldValue) {
       // new additional array value will be here every time any checkbox switched
     }
   },
   
    mounted() {
        axios.get('/prod/cart').then((response) => {
            this.product = response.data
            this.product_count = this.product.length
            this.sum()
          })

          axios.get('/prod/whishlist').then((response) => {
            this.whishlist = response.data
          })

        


         



          

    }
      
}).$mount('#app');


