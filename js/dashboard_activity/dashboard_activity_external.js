if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
}
var dashboard_activity_external = {
    Url: function (metodo, params) {
        return App.url("dashboard_activity", "Dashboard_activity", metodo, params);
    }

};
var vue_instance_dashboard_activity_external = new Vue({
    el: "#div-geral-dashboard_activity",
    data: {
        posts   : [],
        amigos  : [],
        path_img_time_line_default : location.origin + '/application/assets/libs/images/dp.jpg'

    },
    mounted:function(){
        var id = window.location.href.split(App.url("dashboard_activity", "Dashboard_activity", "external/"))[1];

        var self_vue  = this;
        var url       = App.url("pessoas", "Amigos", "amigos_by_usuario_limit");
        // ------------------profile-------------------
        $.post(url, {
            id : id
        }, function(response){
            self_vue.$data.amigos = response.data.amigos;
            },'json');
        $.post(
            App.url("","Home","get_storage_img"),
            {
                id:id
            },
            function(json){
                vue_instance_dashboard_activity_external.$data.posts = json.data
            },'json')
        },
    methods:{
        redirect_user:function(id){
            var url = App.url("dashboard_activity","Dashboard_activity","index");
            $.post(
                url,
                {
                    id:id
                },
                function(json){
                    window.location.href = App.url("dashboard_activity","Dashboard_activity","external/" + json.id[0]);
                },'json')
        }
    }
    }
);

