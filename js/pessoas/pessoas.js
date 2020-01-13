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
        img_profile:'',
        path_img_profile_default:location.origin + '/application/assets/libs/images/my-dashboard/my-dp.jpg'

    },
    methods:{
        getPosts() {
                var offset      = this.data_users.length ++;
                var limit       = 10;
                var vue_self    = this;

            $.post(
                    pessoas.Url("data_full_user"),
                    {
                        limit:limit,
                        offset:offset
                    },
                    function(json){

                        if(!json.data.all_users.length){
                            vue_self.loading = false;
                        }else{
                            vue_self.data_users.push(json.data.all_users);
                        }
                    },'json')

        },
        openfile:function(){
            $("#input-file-img-profile").click();
        },
        update_img_profile:function()  {
            var self_vue  = this;
            var url       = dashboard_activity.Url("update_img_profile");
            var data      = new FormData();
            data.append('fileimagemprofile', $('#input-file-img-profile')[0].files[0]);

            $.ajax({
                    url         : url,
                    data        : data,
                    processData : false,
                    contentType : false,
                    type        : 'POST',
                    dataType    : 'json',
                    success     : function(response) {
                        self_vue.$data.img_profile = response.path;

                    }
                }
            );
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

