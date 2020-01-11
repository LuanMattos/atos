var pessoas = {
    Url: function (metodo, params) {
        return App.url("pessoas", "Pessoas", metodo, params);
    }

}

var vue_instance_pessoas = new Vue({
    el:"#div-geral-pessoas-full",
    data:{
        data_users:[],
        loading: true,
    },
    methods:{
        getPosts() {
                var offset      = this.data_users.length;
                var limit       = 10;
                var vue_self    = this;

            $.post(
                    pessoas.Url("data_full_user"),
                    {
                        limit:limit,
                        offset:offset
                    },
                    function(json){
                        console.log(json.data.all_users.length);
                        if(json.data.all_users.length <= 0){
                            vue_self.loading = false;
                        }
                        vue_self.data_users.push(json.data.all_users);
                    },'json')

        },
    }
});


$.post(
    pessoas.Url("data_full_user"),
    {
        offset:0
    },
    function(json){
            vue_instance_pessoas.$data.data_users.push(json.data.all_users);

    },'json')

