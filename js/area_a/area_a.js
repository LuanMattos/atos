var area_a = {
    Url: function (metodo, params) {
        return App.url("area_a", "Area_a", metodo, params);
    }

}

var vue_instance_area_a = new Vue({
    el:"#content-area-a",
    data:{
        data_users:[],
        img_profile:'',
        path_img_profile_default:location.origin + '/application/assets/libs/images/my-dashboard/my-dp.jpg'

    },
    mounted:function(){
        var url       = area_a.Url("get_img_profile");
        var self_vue  = this;
        $.post(
            url,
            {},
            function(response){
                self_vue.$data.img_profile = response.path;
            },'json');

    },
    methods:{
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




