var pessoas = {
    Url: function (metodo, params) {
        return App.url("pessoas", "Pessoas", metodo, params);
    }

}

var vue_instance_pessoas = new Vue({
    el:"#div-geral-pessoas-full",
    data:{
        teste_count        :"",
        data_users         : [],
        loading            : true,
        default_img_prfile : 'application/assets/libs/images/find-peoples/user-1.jpg'

    },
    methods:{
        getPosts() {
                var offset       = this.data_users.length + 1;
                var limit        = 10;
                var vue_self     = this;


            $.post(
                    pessoas.Url("data_full_user"),
                    {
                        limit   : limit,
                        offset  : offset
                    },
                    function(json){

                        if(!json.data.all_users.length){
                            vue_self.loading = false;
                        }else{
                               vue_self.data_users.push(json.data.all_users);
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
            vue_instance_pessoas.$data.img_profile = json.path;

    },'json')

