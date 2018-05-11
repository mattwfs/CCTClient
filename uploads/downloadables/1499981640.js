new Vue({
  el: '#vue-app',
  data: {
    name: 'Aswin',
    job: 'Web developer'
  },
  methods: {
    greet:function(time){
      return 'Good '+time+' '+this.name; 
    }
  }
});

/* use v-bind: to bind dynamic value to attribute */
// v-bind:href="website"
// :href="website"

// use v-html attribute to display html
// <p v-html="content"></p>


/*
Events

click
<p v-on:click="age++">add</p>
<p v-on:click.once="age++">add</p>  // event modifier
<p @click="age++">add</p>
<p v-on:dblclick="age++">add</p>