import Vue from 'vue'
import App from './App.vue'
import userMessage from './components/UserMessage.vue'
import usersGrid from './components/UsersGrid.vue'
import pageHead from './components/PageHead.vue'
import addNewUserBtn from './components/AddNewUserBtn.vue'
import navMenu from './components/NavMenu.vue'
import modalWindow from './components/ModalWindow.vue'
import postsGrid from './components/PostsGrid.vue'


Vue.config.productionTip = false

Vue.component('PageHead', pageHead);
Vue.component('AddNewBtn', addNewUserBtn);
Vue.component('UserMessage', userMessage);
Vue.component('NavMenu', navMenu);
Vue.component('UsersGrid', usersGrid);
Vue.component('ModalWindow', modalWindow);
Vue.component('PostsGrid', postsGrid);


new Vue({
    render: h => h(App),
    }).$mount('#app')
