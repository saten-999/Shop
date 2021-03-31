<template>
    <div class="row">
        <div  class="col-sm-3  mt-5" v-for="product in products" :key="product.index">
                        <div class="products-single fix"  >
                            <div class="box-img-hover">
                                <img :src="'storage/'+product.picture" class="img-flu" alt="Image">
                                <div class="mask-icon">
                                    <ul>
                                        <li><a :href="'product/view/'+product.id" data-toggle="tooltip" data-placement="right" title="View"><i class="fas fa-eye"></i></a></li>
                                        <li><a v-on:click="addtowhishlist(product.id) " style="cursor: pointer; color: white;" data-toggle="tooltip" data-placement="right" title="Add to Wishlist"><i class="far fa-heart"></i></a></li>

                                    </ul>
                                    <a class="cart" v-on:click="add(product.id)" style="cursor: pointer">Add to Cart</a>
                                </div>
                            </div>
                            <div class="why-text" >
                                <h4>{{product.name}}</h4>
                                <h5> {{product.price}} </h5>
                            </div>
                    </div>
            </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                products: []
            }
        },
        methods:{
            add: function(product_id){
                this.$parent.addtocart(product_id)
            },
            addtowhishlist: function(product_id){
                this.$parent.addtowhishlist(product_id)
            }
        },
         watch: {
            $route(to, from) {

             var path = this.$route.params.path;
             axios.get('/all/'+ path).then((response) => this.products = response.data )
            }
        },
        mounted() {
             axios.get('/all/all/').then((response) => this.products = response.data )
        }

        
    }
</script>
