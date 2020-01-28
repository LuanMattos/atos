var menu = {
    Url: function (metodo, params) {
        return App.url("", "Home", metodo, params);
    }
}

var vue_instance_menu = new Vue({
    el: "#content-menu",
    data: {
        img_profile : '',
        path_img_time_line_default : location.origin + '/application/assets/libs/images/dp.jpg'

    },
    mounted:function(){
        var self_vue  = this;
        var url       = App.url("area_a", "Area_a", "get_img");
        // ------------------profile-------------------
        $.post(url, {type:"profile"}, function(response){self_vue.$data.img_profile = response.path;},'json');


    }
})





