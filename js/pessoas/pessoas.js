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
            vue_self.loading = false;

            $.post(
                    pessoas.Url("data_full_user"),
                    {
                        limit:limit,
                        offset:offset
                    },
                    function(json){
                        vue_self.data_users.push(json.data.all_users);

                        if(!json.data.all_users.length){
                            console.log(json.data.all_users.length);
                        }
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

