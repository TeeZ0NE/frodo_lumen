Vue.component('user-message', {
    template: "<p><slot></slot></p>"
});


Vue.component("acc-grid", {
    template: "#grid-template",
    props: {
        channels: {},
        columns: Array,
        url: String
    },
    methods: {
        onDeleteUser: function (screen_name, index) {
            var res = confirm("delete user?");
            if (res) {
                fetch("http://localhost:8021/api/accounts/" + screen_name + "/delete", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json"
                        },
                        credentials: "same-origin"
                    })
                    .then(
                        function (response) {
                            return response.json();
                        },
                        function (error) {
                            vm.message = error.message;
                        }
                    )
                    .then(function (data) {
                        vm.hasError = data.status === "success" ? false : true;
                        vm.message = data.description || defaults.description;
                    });
                vm.channels.splice(index, 1);
            }
        },
        onViewPosts: function (screen_name) {
            fetch('http://localhost:8021/api/accounts/' + screen_name + '/posts')
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
                    }
                });
            vm.navItems.push({
                title: screen_name
            });
            vm.screen_name = screen_name;
            vm.pageHead = defaults.pageHeadPosts;
        },
        onEditUser: function () {
            vm.message = "edit user";
        }
    }
});

Vue.component('posts-grid', {
    template: "#posts-template",
    props: {
        columns: Array,
        posts: Array
    }
});


var defaults = {
    description: "Some error occurs",
    navHome: "Home",
    pageHead: "Channels",
    pageHeadPosts: "Posts"
};
var vm = new Vue({
    el: "#app",
    data: {
        channels: {},
        columnHeaders: [
            "#",
            "Screen name",
            "Name",
            "Posts number",
            "Refresh interval",
            "Actions"
        ],
        columnPostsHeaders: ["#", "Id", "Created at", "Title", "Description", "Favorite count", "Replies count", "Retweet count"],
        hasError: false,
        isPosts: false,
        isVisibleAddBtn: true,
        message: '',
        navItems: [{
            title: defaults.navHome
        }],
        navSpacer: ">",
        pageHead: defaults.pageHead,
        posts: [],
        screen_name: '',
        url: "https://twitter.com/"
    },
    created: function () {
        fetch('http://localhost:8021/api/accounts/')
            .then(function (response) {
                return response.json();
            })
            .then(function (data) {
                if (data.status == "success") {
                    vm.channels = data.accounts;
                } else {
                    vm.hasError = true;
                }
                vm.message = data.description || defaults.description;
            });
    },
    computed: {
        itemsCount: function () {
            return this.navItems.length;
        }
    },
    methods: {
        addNewChannel: function () {
            this.message = "Adddede;";
            console.log('add new channel clicked');
        },
        isNavActive: function (index) {
            this.isPosts = this.itemsCount >= 2 ? true : false;
            return this.itemsCount - (++index);
        },
        toHome: function (event) {
            if (this.isPosts && event.target.innerText === this.navItems[0].title) {
                vm.navItems.splice(1, this.itemsCount - 1);
                this.screen_name = '';
                this.pageHead = defaults.pageHead;
            }
        }
    }
});