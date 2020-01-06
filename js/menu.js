var menu = {
    Url: function (metodo, params) {
        return App.url("", "Home", metodo, params);
    }
}

new Vue({
    el: "#teste",
    data: {
    },
    methods:{
        buscar:function(){
            alert('fsdf');
        }
    }
})





