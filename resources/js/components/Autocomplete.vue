<template>
 <div>

  <div class="form-inline">
    <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" v-model="query" v-on:keyup="autoComplete">
    <button class="btn  my-2 my-sm-0" type="submit" style="border: 1px solid #d33b33">Search</button>
  </div>
  <div class="panel-footer" v-if="results.length">
   <ul class="list-group">
    <li class="list-group-item" v-for="result in results" :key="result.index" style="position: absolute; width: 12%; z-index: 1;" >

        <a :href="'product/view/'+result.id"> {{ result.name }} </a>

    </li>
   </ul>
  </div>
 </div>
</template>
<script>
 export default{
  data(){
   return {
    query: '',
    results: []
   }
  },
  methods: {
   autoComplete(){
    this.results = [];
    if(this.query.length > 2){

     axios.get('/api/search',{params: {query: this.query}}).then(response => {
        this.results = response.data;
     });
    }
   }
  }
 }
</script>