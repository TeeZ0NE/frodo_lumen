Vue.component('user-message', {
  template:"<p><slot></slot></p>"
});

Vue.prototype.$http = axios;

Vue.component('acc-grid',{
  template: '#grid-template',
  props: {
    channels: {},
    columns: Array,
    url: String
  },
  methods:{
    onDeleteUser: function(screen_name, index){
      res = confirm('delete user?');
      this.$http.post('http://localhost:8021/api/accounts/'+screen_name+"/delete")
      .then(function (response) {
        (response.data.status == "success") ? vm.hasError=false : vm.hasError = true;
        vm.message = response.data.description;
        return response;
      });
      vm.channels.splice(index,1);
    }
  }
});
var vm = new Vue({
  el: "#app",
  data: {
    breadCrumbs: "Home",
    channels: {},
    columnHeaders:["#", "Screen name", "Name", "Posts number", "Refresh interval", "Actions"],
    hasError: false,
    isVisibleAddBtn: true,
    message: '',
    pageHead: "Channels",
    url: "https://twitter.com/"
  },
  created: function () {
    fetch('http://localhost:8021/api/accounts/')
      .then(function (response) {
        return response.json()
      })
      .then(function (data) {
        (data.status == "success") ? vm.channels = data.accounts : vm.hasError = true;
        vm.message = data.description;
      });
  },
  methods: {
    addNewChannel: function () {
      vm.message = "Adddede;";
      console.log('add new channel clicked');
    }
  }
});