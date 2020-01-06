var home = {
    Url: function (metodo, params) {
        return App.url("", "Home", metodo, params);
    }

};
var vm = new Vue({
    el: '#vue-instance',
    data: {
        posts: [],
        loading: false
    },
    created() {
        this.getPosts()
    },
    methods: {
        getPosts() {
            for (var i = 0; i < 16; i++) {
                var count = this.posts.length + i
                this.posts.push({
                    title: 'title ' + count
                })
            }
        }
    }
});

