(function(e){function t(t){for(var n,o,i=t[0],l=t[1],c=t[2],d=0,m=[];d<i.length;d++)o=i[d],r[o]&&m.push(r[o][0]),r[o]=0;for(n in l)Object.prototype.hasOwnProperty.call(l,n)&&(e[n]=l[n]);u&&u(t);while(m.length)m.shift()();return a.push.apply(a,c||[]),s()}function s(){for(var e,t=0;t<a.length;t++){for(var s=a[t],n=!0,i=1;i<s.length;i++){var l=s[i];0!==r[l]&&(n=!1)}n&&(a.splice(t--,1),e=o(o.s=s[0]))}return e}var n={},r={app:0},a=[];function o(t){if(n[t])return n[t].exports;var s=n[t]={i:t,l:!1,exports:{}};return e[t].call(s.exports,s,s.exports,o),s.l=!0,s.exports}o.m=e,o.c=n,o.d=function(e,t,s){o.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:s})},o.r=function(e){"undefined"!==typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},o.t=function(e,t){if(1&t&&(e=o(e)),8&t)return e;if(4&t&&"object"===typeof e&&e&&e.__esModule)return e;var s=Object.create(null);if(o.r(s),Object.defineProperty(s,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var n in e)o.d(s,n,function(t){return e[t]}.bind(null,n));return s},o.n=function(e){var t=e&&e.__esModule?function(){return e["default"]}:function(){return e};return o.d(t,"a",t),t},o.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},o.p="/";var i=window["webpackJsonp"]=window["webpackJsonp"]||[],l=i.push.bind(i);i.push=t,i=i.slice();for(var c=0;c<i.length;c++)t(i[c]);var u=l;a.push([0,"chunk-vendors"]),s()})({0:function(e,t,s){e.exports=s("56d7")},"1d76":function(e,t,s){},"2f71":function(e,t,s){},"370c":function(e,t,s){},"3cc9":function(e,t,s){},"3ee9":function(e,t,s){"use strict";var n=s("370c"),r=s.n(n);r.a},5272:function(e,t,s){"use strict";var n=s("659b"),r=s.n(n);r.a},"52e2":function(e,t,s){"use strict";var n=s("b073"),r=s.n(n);r.a},"56d7":function(e,t,s){"use strict";s.r(t);s("cadf"),s("551c"),s("097d");var n=s("2b0e"),r=function(){var e=this,t=e.$createElement,s=e._self._c||t;return s("div",{attrs:{id:"app"}},[s("nav-menu",{attrs:{navItems:e.navItems},on:{toHome:e.toHome}}),s("page-head",{attrs:{pageTitle:e.pageTitle}}),e.isVisibleAddBtn||e.isHomePage?s("add-new-btn",{on:{onAddNewUser:e.AddNewUser}}):e._e(),s("div",{staticClass:"data-table"},[s("user-message",{staticClass:"msg",attrs:{hasError:e.hasError,message:e.message}}),e.isHomePage?s("users-grid",{attrs:{channels:e.channels,columns:e.columnHeaders,url:e.url},on:{onEditUser:e.editUser,onDeleteUser:e.DeleteCh,onViewPosts:e.onViewPosts}}):e._e(),e.isHomePage?e._e():s("posts-grid",{attrs:{columns:e.columnPostsHeaders,posts:e.posts}})],1),e.showConfirm?s("modal-window",{attrs:{modalUser:e.modalUser},on:{close:e.onNotConfirmed,ok:e.onDeleteCh}},[s("p",{attrs:{slot:"body"},slot:"body"},[e._v("Do you want to delete "),s("strong",[e._v(e._s(e.screen_name))]),e._v("?")])]):e._e(),e.showUserWind?s("modal-window",{attrs:{modalUser:e.modalUser},on:{close:e.onNotConfirmed,ok:e.onStoreNewUser}}):e._e(),e.showUpdUserWind?s("modal-window",{attrs:{modalUser:e.modalUser},on:{close:e.onNotConfirmed,ok:e.onUpdateUser}}):e._e()],1)},a=[],o=s("f499"),i=s.n(o),l=(s("7f7f"),{name:"App",data:function(){return{apiUrl:"http://localhost:8021/api/accounts/",channels:{},columnHeaders:["#","Screen name","Name","Posts number","Refresh interval","Actions"],columnPostsHeaders:["id_str","created_at","title","description","favorite_count","replies_count","retweet_count"],defaults:{homePageTitle:"Channels",postsPageTitle:"Posts",modalUser:{erMsg:"",isEr:!1,title:"",screen_name:"",refreshInterval:1,name:""}},hasError:!1,index:-1,isConfirmed:!1,isHomePage:!0,isVisibleAddBtn:!1,message:"Page loaded. Loading channels...",modalUser:{},navItems:[{title:"Home"}],pageTitle:"",posts:{},refreshInterval:1,screen_name:"",showConfirm:!1,showUpdUserWind:!1,showUserWind:!1,url:"https://twitter.com/"}},methods:{AddNewUser:function(){this.clearData(),this.showUserWind=!0,this.modalUser.title="Add new channel"},onStoreNewUser:function(e){if(this.screen_name=e.screen_name,this.refreshInterval=e.refreshInterval,""===this.screen_name||this.screen_name.indexOf(" ")>0)return this.modalUser.erMsg="Check screen name. <br><small>Possible: it's empty or has spaces</small>",void(this.modalUser.isEr=!0);this.showUserWind=!1;var t=new Request(this.apiUrl+"new"),s={screen_name:this.screen_name,interval:this.refreshInterval};this.onFetchPost(t,s,!0)},DeleteCh:function(e,t){this.screen_name=e,this.index=t,this.modalUser.title="Confirm deleting",this.showConfirm=!0},onDeleteCh:function(){this.showConfirm=!1;var e=new Request(this.apiUrl+this.screen_name+"/delete");this.onFetchPost(e),this.hasError||this.channels.splice(this.index,1)},editUser:function(e,t,s){this.showUpdUserWind=!0,this.modalUser.title="Update channel",this.modalUser.screen_name=this.screen_name=e,this.modalUser.refreshInterval=this.refreshInterval=t,this.modalUser.name=s,this.message="".concat(this.screen_name," interval ").concat(this.refreshInterval)},onUpdateUser:function(e){if(this.screen_name=e.screen_name,this.refreshInterval=e.refreshInterval,""===this.screen_name||this.screen_name.indexOf(" ")>0||""==this.modalUser.name)return this.modalUser.erMsg="Check screen name. <br><small>Possible: it's empty or has spaces</small>",void(this.modalUser.isEr=!0);this.showUpdUserWind=!1;var t=new Request(this.apiUrl+this.screen_name);this.onFetchPost(t,{interval:this.refreshInterval,name:this.modalUser.name},!0)},onViewPosts:function(e){this.isHomePage=!1;var t=new Request(this.apiUrl+e+"/posts"),s=this;fetch(t).then(function(e){return e.json()},function(e){s.message=e.message}).then(function(e){"success"===e.status?s.posts=e.tweets:(s.hasError=!0,setTimeout(function(){s.message=e.description||"Error occurs"},3e3))}),s.navItems.push({title:e}),s.screen_name=e,s.pageTitle=s.defaults.postsPageTitle},toHome:function(){this.isHomePage=!0,this.navItems.splice(1,this.navItems.length-1),this.screen_name="",this.posts={},this.pageTitle=this.defaults.homePageTitle},onNotConfirmed:function(){this.isConfirmed=!1,this.showConfirm=this.showUserWind=this.showUpdUserWind=!1,this.clearData()},onConfirmed:function(){this.isConfirmed=!0,this.showConfirm=!1},clearData:function(){this.screen_name="",this.modalUser.screen_name="",this.modalUser.refreshInterval=1,this.modalUser.name="",this.isConfirmed=!1,this.refreshInterval=1},onFetchChData:function(){var e=this;fetch(this.apiUrl).then(function(e){return e.json()},function(t){e.message=t.message,e.hasError=!0}).then(function(t){"success"==t.status?e.channels=t.accounts:e.hasError=!0,setTimeout(function(){e.message=t.description||"Error occurs"},3e3)})},onFetchPost:function(e){var t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:{},s=arguments.length>2&&void 0!==arguments[2]&&arguments[2],n=this;fetch(e,{method:"POST",body:i()(t),headers:{"Content-Type":"application/json","Access-Control-Allow-Origin":"*","Access-Control-Request-Method":"POST"},mode:"cors"}).then(function(e){return e.json()},function(e){n.message=e.message,n.hasError=!0}).then(function(e){"success"===e.status?(s&&n.onFetchChData(),n.hasError=!1,n.clearData()):n.hasError=!0,n.message=e.description||"Error occurs"})}},created:function(){this.pageTitle=this.defaults.homePageTitle,this.modalUser=this.defaults.modalUser,this.onFetchChData()}}),c=l,u=(s("7faf"),s("2877")),d=Object(u["a"])(c,r,a,!1,null,null,null);d.options.__file="App.vue";var m=d.exports,h=function(){var e=this,t=e.$createElement,s=e._self._c||t;return s("p",{class:[e.hasError?"errorMsg":""]},[e._v(e._s(e.message))])},f=[],p={name:"UserMessage",props:{message:String,hasError:{type:Boolean,default:!1}}},v=p,_=(s("52e2"),Object(u["a"])(v,h,f,!1,null,null,null));_.options.__file="UserMessage.vue";var U=_.exports,g=function(){var e=this,t=e.$createElement,s=e._self._c||t;return s("table",[s("thead",[s("tr",e._l(e.columns,function(t){return s("th",{key:t,staticClass:"default"},[e._v("\n                "+e._s(t)+"\n\t\t\t")])}),0)]),s("tbody",e._l(e.channels,function(t,n){return s("tr",{key:t.id},[s("td",[e._v(e._s(n))]),s("td",[s("a",{attrs:{href:e.url+t.screen_name}},[e._v(e._s(t.screen_name))])]),s("td",[e._v(e._s(t.name))]),s("td",[e._v(e._s(t.posts_number))]),s("td",[e._v(e._s(t.refresh_interval))]),s("td",[s("a",{attrs:{href:"#"},on:{click:function(s){s.preventDefault(),e.$emit("onEditUser",t.screen_name,t.refresh_interval,t.name)}}},[e._v("Edit ")]),e._v("/ \n            "),t.posts_number?s("a",{attrs:{href:"#"},on:{click:function(s){s.preventDefault(),e.$emit("onViewPosts",t.screen_name)}}},[s("span",[e._v("Posts")])]):s("span",[e._v("Posts")]),e._v(" / \n            "),s("a",{attrs:{href:"#"},on:{click:function(s){s.preventDefault(),e.$emit("onDeleteUser",t.screen_name,n)}}},[e._v("Delete")])])])}),0)])},b=[],w={name:"UsersGrid",props:{channels:[Object,Array],url:String,columns:Array}},C=w,y=(s("5272"),Object(u["a"])(C,g,b,!1,null,null,null));y.options.__file="UsersGrid.vue";var P=y.exports,E=function(){var e=this,t=e.$createElement,s=e._self._c||t;return s("h1",{staticClass:"pageHead"},[e._v(e._s(e.pageTitle))])},O=[],A={name:"PageHead",props:{pageTitle:String}},k=A,I=Object(u["a"])(k,E,O,!1,null,null,null);I.options.__file="PageHead.vue";var N=I.exports,j=function(){var e=this,t=e.$createElement,s=e._self._c||t;return s("div",{staticClass:"add-new-channel"},[s("button",{on:{click:function(t){e.$emit("onAddNewUser")}}},[e._v("Add new channel")])])},x=[],T={name:"AddNewUserBtn"},$=T,D=(s("b162"),Object(u["a"])($,j,x,!1,null,null,null));D.options.__file="AddNewUserBtn.vue";var H=D.exports,M=function(){var e=this,t=e.$createElement,s=e._self._c||t;return s("ul",{staticClass:"nav"},e._l(e.navItems,function(t,n){return s("li",[s("span",{class:{"nav-active":e.isNavActive(n)},on:{click:function(t){e.$emit("toHome")}}},[e._v(e._s(t.title))]),e.isNavActive(n)?s("span",[e._v(e._s(e.navSpacer))]):e._e()])}),0)},S=[],W={name:"NavMenu",props:{navItems:Array},data:function(){return{navSpacer:" >"}},computed:{itemsCount:function(){return this.navItems.length}},methods:{isNavActive:function(e){return this.itemsCount-++e}}},B=W,F=(s("3ee9"),Object(u["a"])(B,M,S,!1,null,null,null));F.options.__file="NavMenu.vue";var R=F.exports,G=function(){var e=this,t=e.$createElement,s=e._self._c||t;return s("div",{staticClass:"modal-mask"},[s("div",{staticClass:"modal-wrapper"},[s("div",{staticClass:"modal-container"},[s("div",{staticClass:"modal-header"},[e._t("header",[s("h3",[e._v(e._s(e.modalUser.title))])]),s("button",{attrs:{id:"close-wind",name:"close-btn"},on:{click:function(t){e.$emit("close")}}},[e._v("X")])],2),s("div",{staticClass:"modal-body"},[e._t("body",[e.modalUser.isEr?s("p",{staticClass:"error-msg",attrs:{slot:"body"},domProps:{innerHTML:e._s(e.modalUser.erMsg)},slot:"body"}):e._e(),s("div",{staticClass:"custom-input"},[s("label",{attrs:{for:"screen-name"}},[e._v("Screen Name")]),s("input",{directives:[{name:"model",rawName:"v-model.trim",value:e.modalUser.screen_name,expression:"modalUser.screen_name",modifiers:{trim:!0}}],attrs:{id:"sreen-name",placeholder:"Channel name"},domProps:{value:e.modalUser.screen_name},on:{input:[function(t){t.target.composing||e.$set(e.modalUser,"screen_name",t.target.value.trim())},function(t){e.modalUser.isEr=!1}],blur:function(t){e.$forceUpdate()}}})]),""!==e.modalUser.name?s("div",{staticClass:"custom-input"},[s("label",{attrs:{for:"name"}},[e._v("Name")]),s("input",{directives:[{name:"model",rawName:"v-model.trim",value:e.modalUser.name,expression:"modalUser.name",modifiers:{trim:!0}}],attrs:{id:"name",placeholder:"User name"},domProps:{value:e.modalUser.name},on:{input:[function(t){t.target.composing||e.$set(e.modalUser,"name",t.target.value.trim())},function(t){e.modalUser.isEr=!1}],blur:function(t){e.$forceUpdate()}}})]):e._e(),s("div",{staticClass:"custom-input"},[s("label",{attrs:{for:"refresh_interval"}},[e._v("Refresh interval")]),s("br"),s("select",{directives:[{name:"model",rawName:"v-model",value:e.modalUser.refreshInterval,expression:"modalUser.refreshInterval"}],attrs:{name:"refresh-inerval",id:"refresh-interval"},on:{change:function(t){var s=Array.prototype.filter.call(t.target.options,function(e){return e.selected}).map(function(e){var t="_value"in e?e._value:e.value;return t});e.$set(e.modalUser,"refreshInterval",t.target.multiple?s:s[0])}}},e._l(12,function(t){return s("option",{key:t,domProps:{value:t}},[e._v("\n              "+e._s(t)+" hrs\n          ")])}),0)])])],2),s("div",{staticClass:"modal-footer"},[e._t("footer",[s("button",{on:{click:function(t){e.$emit("ok",e.modalUser)}}},[e._v("Ok")]),s("button",{staticClass:"modal-default-button",on:{click:function(t){e.$emit("close")}}},[e._v("\n             Cancel\n           ")])])],2)])])])},K=[],V={name:"ModalWindow",props:{modalUser:{Object:Object}}},q=V,L=(s("a851"),Object(u["a"])(q,G,K,!1,null,null,null));L.options.__file="ModalWindow.vue";var z=L.exports,J=function(){var e=this,t=e.$createElement,s=e._self._c||t;return s("table",[s("thead",[s("tr",e._l(e.columns,function(t){return s("th",{key:t,class:{active:e.sortKey==t},on:{click:function(s){e.sortBy(t)}}},[e._v("\n        "+e._s(e._f("capitalize")(t))+"\n        "),s("span",{staticClass:"arrow",class:e.sortOrders[t]>0?"asc":"dsc"})])}),0)]),s("tbody",e._l(e.filteredData,function(t,n){return s("tr",{key:n},e._l(e.columns,function(n){return s("td",{key:n},[e._v("\n        "+e._s(t[n])+"\n      ")])}),0)}),0)])},X=[],Q=(s("55dd"),s("a4bb")),Y=s.n(Q),Z=(s("ac6a"),{name:"PostsGrid",props:{posts:[Array,Object],columns:Array},data:function(){var e={};return this.columns.forEach(function(t){e[t]=1}),{sortKey:"",sortOrders:e}},computed:{filteredData:function(){var e=this.sortKey,t=this.filterKey&&this.filterKey.toLowerCase(),s=this.sortOrders[e]||1,n=this.posts;return t&&(n=n.filter(function(e){return Y()(e).some(function(s){return String(e[s]).toLowerCase().indexOf(t)>-1})})),e&&(n=n.slice().sort(function(t,n){return t=t[e],n=n[e],(t===n?0:t>n?1:-1)*s})),n}},filters:{capitalize:function(e){return e.charAt(0).toUpperCase()+e.slice(1)}},methods:{sortBy:function(e){this.sortKey=e,this.sortOrders[e]=-1*this.sortOrders[e]}}}),ee=Z,te=(s("f6ac"),Object(u["a"])(ee,J,X,!1,null,null,null));te.options.__file="PostsGrid.vue";var se=te.exports;n["a"].config.productionTip=!1,n["a"].component("PageHead",N),n["a"].component("AddNewBtn",H),n["a"].component("UserMessage",U),n["a"].component("NavMenu",R),n["a"].component("UsersGrid",P),n["a"].component("ModalWindow",z),n["a"].component("PostsGrid",se),new n["a"]({render:function(e){return e(m)}}).$mount("#app")},"659b":function(e,t,s){},"7faf":function(e,t,s){"use strict";var n=s("8fba"),r=s.n(n);r.a},"8fba":function(e,t,s){},a851:function(e,t,s){"use strict";var n=s("1d76"),r=s.n(n);r.a},b073:function(e,t,s){},b162:function(e,t,s){"use strict";var n=s("3cc9"),r=s.n(n);r.a},f6ac:function(e,t,s){"use strict";var n=s("2f71"),r=s.n(n);r.a}});
//# sourceMappingURL=app.1af2f60c.js.map