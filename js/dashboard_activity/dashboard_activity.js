if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
}
var dashboard_activity = {
    Url: function (metodo, params) {
        return App.url("dashboard_activity", "Dashboard_activity", metodo, params);
    }

};

var vue_instance_dashboard_activity = new Vue({
        el: '#div-geral-dashboard_activity',
        data: {
            img_profile:"",
            path_img_profile_default:location.origin + '/application/assets/libs/images/my-dashboard/my-dp.jpg'
        },
        mounted:function(){
            var url       = dashboard_activity.Url("get_img_profile");
            var self_vue  = this;

            $.post(
                url,
                {},
                function(response){
                    console.log(response.path)
                    self_vue.$data.img_profile = response.path;
                },'json');
            },
        methods: {
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
            openfile_profile:function(){
                $("#input-file-postagem").click();
            },
            openfile:function(){
                $("#input-file-img-profile").click();
            },


        },

    }
);

