<template>
  <div id="app">
    <nav-menu :navItems="navItems" @toHome="toHome"/>
    <page-head :pageTitle="pageTitle"/>
    <add-new-btn v-if="(isVisibleAddBtn || isHomePage)" @onAddNewUser="AddNewUser"/>

    <div class="data-table">
       <user-message class="msg" :hasError="hasError" :message="message"/>
       <users-grid v-if="isHomePage" :channels="channels" :columns="columnHeaders" :url="url" @onEditUser="editUser" @onDeleteUser="DeleteCh" @onViewPosts="onViewPosts"/>
       <posts-grid v-if="!isHomePage" :columns="columnPostsHeaders" :posts="posts"/>

   </div>

   <modal-window v-if="showConfirm" @close="onNotConfirmed" @ok="onDeleteCh" :modalUser="modalUser">
      <p slot="body">Do you want to delete <strong>{{screen_name}}</strong>?</p>
  </modal-window>

  <modal-window v-if="showUserWind" @close="onNotConfirmed" @ok="onStoreNewUser" :modalUser="modalUser">
    </modal-window>

  <modal-window v-if="showUpdUserWind" @close="onNotConfirmed" @ok="onUpdateUser" :modalUser="modalUser">
  </modal-window>

</div>
</template>

<script>
export default {
    name: "App",
    data() {
        return {
            apiUrl: "http://localhost:8021/api/accounts/",
            channels: {},
            columnHeaders: ["#", "Screen name", "Name", "Posts number", "Refresh interval", "Actions"],
            columnPostsHeaders: ['id_str', 'created_at', 'title', 'description', 'favorite_count','replies_count', 'retweet_count'],
            defaults:{homePageTitle: "Channels", postsPageTitle: "Posts", modalUser:{erMsg:'', isEr:false, title:'', screen_name:'', refreshInterval:1, name:''}},
            hasError: false,
            index: -1,
            isConfirmed: false,
            isHomePage: true,
            isVisibleAddBtn: false,
            message: "Page loaded. Loading channels...",
            modalUser:{},
            navItems: [{title: "Home"}],
            pageTitle : '',
            posts: {},
            refreshInterval:1,
            screen_name: '',
            showConfirm: false,
            showUpdUserWind: false,
            showUserWind: false,
            url: "https://twitter.com/",
        }
    },
    methods: {
      AddNewUser() {
        this.clearData();
        this.showUserWind = true;
        this.modalUser.title = "Add new channel";
      },
      onStoreNewUser(modalUser){
        this.screen_name = modalUser.screen_name;
        this.refreshInterval = modalUser.refreshInterval;
        if(this.screen_name === '' || this.screen_name.indexOf(' ') > 0){
          this.modalUser.erMsg = 'Check screen name. <br><small>Possible: it\'s empty or has spaces</small>';
          this.modalUser.isEr=true;
          return;
        }
        this.showUserWind = false;
        let request = new Request(this.apiUrl + "new");
        let body = {screen_name: this.screen_name, interval: this.refreshInterval};
        this.onFetchPost(request, body, true);
      },
      DeleteCh(screen_name, index){
        this.screen_name = screen_name;
        this.index = index;
        this.modalUser.title = "Confirm deleting";
        this.showConfirm = true;
      },
      onDeleteCh(){
        this.showConfirm = false;
        let request = new Request(this.apiUrl + this.screen_name + "/delete");
        this.onFetchPost(request);
        if(!this.hasError) this.channels.splice(this.index, 1);
      },
      editUser(screen_name, refreshInterval, name){
        this.showUpdUserWind = true;
        this.modalUser.title = "Update channel";
        this.modalUser.screen_name = this.screen_name = screen_name;
        this.modalUser.refreshInterval = this.refreshInterval = refreshInterval;
        this.modalUser.name = name;
      },
      onUpdateUser(modalUser){
        this.screen_name = modalUser.screen_name;
        this.refreshInterval = modalUser.refreshInterval;
        if(this.screen_name === '' || this.screen_name.indexOf(' ') > 0 || this.modalUser.name==''){
          this.modalUser.erMsg = 'Check screen name. <br><small>Possible: it\'s empty or has spaces</small>';
          this.modalUser.isEr=true;
          return;
        }
        this.showUpdUserWind = false;
        let request = new Request(this.apiUrl+this.screen_name);
        this.onFetchPost(request, {interval:this.refreshInterval, name:this.modalUser.name}, true)
      },
      onViewPosts(screen_name){
        this.isHomePage = false;
        let request = new Request(this.apiUrl + screen_name+"/posts");
        let vm = this;
        fetch(request)
        .then(function (response) {
          return response.json();
        }, function (error) {
          vm.message = error.message;
        })
        .then(function (data) {
          if (data.status === "success") {
            vm.posts = data.tweets;
          } else {
            vm.hasError = true;
            setTimeout(()=>{vm.message = data.description || "Error occurs"},3000);
          }
        });
        vm.navItems.push({
          title: screen_name
        });
        vm.screen_name = screen_name;
        vm.pageTitle = vm.defaults.postsPageTitle;
      },
      toHome(){
        this.isHomePage = true;
        this.navItems.splice(1, this.navItems.length - 1);
        this.screen_name = '';
        this.posts = {};
        this.pageTitle = this.defaults.homePageTitle;
      },
      onNotConfirmed(){
        this.isConfirmed = false;
        this.showConfirm = this.showUserWind = this.showUpdUserWind = false;
        this.clearData();
      },
      onConfirmed(){
        this.isConfirmed = true;
        this.showConfirm = false;
      },
      clearData(){
        this.screen_name = '';
        this.modalUser.screen_name = '';
        this.modalUser.refreshInterval = 1;
        this.modalUser.name = '';
        this.isConfirmed = false;
        this.refreshInterval = 1;
      },
      onFetchChData(){
        let vm = this;
        fetch(this.apiUrl)
        .then(function (response) {
          return response.json();
        }, function(error){
          vm.message = error.message;
          vm.hasError = true;
        })
        .then(function (data) {
          if (data.status == "success") {
            vm.channels = data.accounts;
          } else {
            vm.hasError = true;
          }
          setTimeout(()=>{vm.message = data.description || "Error occurs"},3000);
        });
      },
      onFetchPost(request, body={}, update = false){
        let vm = this;
        fetch(request, {
          method: "POST",
          body: JSON.stringify(body),
          headers: {
           "Content-Type": "application/json",
           "Access-Control-Allow-Origin" : "*",
           "Access-Control-Request-Method": "POST"
         },
         mode: 'cors'
       })
        .then(
          function (response) {
            return response.json();
          },
          function (error) {
            vm.message = error.message;
            vm.hasError = true;
          })
        .then(function (data) {
          if(data.status === "success"){
            if (update) vm.onFetchChData();
            vm.hasError = false;
            vm.clearData();
          }
          else vm.hasError = true;
          vm.message = data.description || "Error occurs";
        });
      }
    },
    created () {
      this.pageTitle = this.defaults.homePageTitle;
      this.modalUser = this.defaults.modalUser;
      this.onFetchChData();
    }
}
</script>

<style lang="stylus">
#app
    display grid
    grid-gap 5px
    grid-template-areas 'bread-crumbs bread-crumbs bread-crumbs' 'page-head page-head add-btn' 'data data data'
.page-head
    grid-area page-head
/* nav */
.nav
    grid-area bread-crumbs
.error-msg
    color red
    text-align center
</style>