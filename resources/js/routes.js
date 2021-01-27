import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

let routes = [

    { path: '/:path', component: require('./components/AllComponent.vue').default },
  
  ]



export default new VueRouter({
    routes
})