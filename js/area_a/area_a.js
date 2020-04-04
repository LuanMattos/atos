var area_a = {
    Url: function (metodo, params) {
        return App.url("area_a", "Area_a", metodo, params);
    }

}
var vue_instance_area_a = new Vue({
    el:"#content-area-a",
    data:{
        data_users               : [],
        img_profile              : '',
        img_cover                : '',
        path_img_profile_default : location.origin + '/application/assets/libs/images/my-dashboard/my-dp.jpg',
        path_img_cover_default   : location.origin + '/application/assets/libs/images/event-view/my-bg.jpg',


    },
    mounted:function(){
        var self_vue  = this;
        var id        = window.location.href.split(App.url("dashboard_activity", "Dashboard_activity", "external/"))[1];
        var type      = "profile";

        if( !_.isUndefined( id ) ){ type = 'where'; }

        // ------------------profile-------------------
        var url  = area_a.Url("get_img");
        $.post(url, { type:type,id : id}, function(response){self_vue.$data.img_profile = response.path;},'json');
        // ------------------cover------------------
        var url   = area_a.Url("get_img");
        type      = "cover";
        if( !_.isUndefined( id ) ){ type = 'where_cover'; }

        $.post(url, {type:type,id : id }, function(response){self_vue.$data.img_cover = response.path;},'json');

    },
    methods:{
        openfile:function(){
            $("#input-file-img-profile").click();
        },
        openfilecover:function(){
            $("#input-file-img-cover").click();
        },
        update_img_profile:function()  {
            var self_vue  = this;
            var url       = App.url("dashboard_activity/Dashboard_activity/update_img_profile");
            var data      = new FormData();
            data.append('fileimagemprofile', $('#input-file-img-profile')[0].files[0]);
            vue_lightbox._data.visible = false
            $.ajax({
                    url         : url,
                    data        : data,
                    processData : false,
                    contentType : false,
                    type        : 'POST',
                    dataType    : 'json',
                    success     : function(response) {
                        self_vue.$data.img_profile = response.path;
                        vue_lightbox._data.visible = false
                    }
                }
            );
        },
        update_img_cover:function()  {
            var self_vue  = this;
            var url       = area_a.Url("update_img_cover");
            var data      = new FormData();
            data.append('fileimagemcover', $('#input-file-img-cover')[0].files[0]);

          vue_lightbox._data.visible = false
            $.ajax({
                    url         : url,
                    data        : data,
                    processData : false,
                    contentType : false,
                    type        : 'POST',
                    dataType    : 'json',
                    success     : function(response) {
                        self_vue.$data.img_cover = response.path;

                    }
                }
            );
        },
        showImg ( path,el,edit) {
          vue_lightbox._data.imgs = path;
          vue_lightbox._data.visible = true;
          vue_lightbox._data.element_open = el;
          vue_lightbox._data.edit = edit;
        },
    }
});




