if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
}
var dashboard_activity = {
    Url: function (metodo, params) {
        return App.url("dashboard_activity", "Dashboard_activity", metodo, params);
    }

};

var vue_instance_dashboard_activity = new Vue({
    el: "#div-geral-dashboard_activity",
    data: {
        amigos : [],
        path_img_time_line_default : location.origin + '/application/assets/libs/images/dp.jpg'

    },
    mounted:function(){
        var self_vue  = this;
        var url       = App.url("pessoas", "Amigos", "amigos_by_usuario_limit");
        // ------------------profile-------------------
        $.post(url, {}, function(response){
            self_vue.$data.amigos = response.data.amigos;
            },'json');
        }
    }
);

