/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
window.Vue = require('vue');


import VueRouter from 'vue-router'
Vue.use(VueRouter)

Vue.component('auto-complete', require('./components/Autocomplete.vue').default);

const routes = [

  { path: '/:path', component: require('./components/AllComponent.vue').default },

]


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */	

const router = new VueRouter({
  routes, 
  mode:"history"
})

const app = new Vue({
    router,
    el: '#app',
    data: {
        product: [],
        whishlist: [],
        subtotal:0,
        delivery:false,
        product_count: 0,
        status:''
      },
   methods:{
    change_order_count: function(product_id,index){

        axios.get('/cart/'+product_id+'/count/'+ this.product[index].order_count).then((response) => console.log('done'))

          this.sum()
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
     
      axios.get('cart/delete/'+index).then((response) => this.product_count )

     },
     addtowhishlist: function(product_id){

      axios.get('/product/wishlist/'+product_id).then((response) => {
            this.status = 'Added to wishlist'
            setTimeout(() => {
              this.status = ''
            }, 1000); 
   })
     
      
     },
     addtocartfromwhishlist: function(product_id,index){
      
      axios.get('cart/'+product_id).then((response) => { console.log(response.data)
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
      
      axios.get('product/wishlist/delete/'+index).then((response) => console.log('delete from whishlist'))
     },

     
    sum: function(){

        this.product.forEach(element => {
            this.subtotal  += (element.price * element.order_count)
        });
        // return this.subtotal
     }

   },
    mounted() {
        // this.subtotal = s;
        axios.get('/prod/cart').then((response) => {
            this.product = response.data

            this.sum()
            this.product_count = this.product.length
          })

          axios.get('/prod/whishlist').then((response) => {
            this.whishlist = response.data
          })



          

    }
      
}).$mount('#app');


