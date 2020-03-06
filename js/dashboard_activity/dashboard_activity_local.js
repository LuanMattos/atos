if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
}
var dashboard_activity_local = {
    Url: function (metodo, params) {
        return App.url("dashboard_activity", "Dashboard_activity", metodo, params);
    }

};
var vue_instance_dashboard_activity_local = new Vue({
    el: "#div-geral-dashboard_activity",
    data: {
        posts   : [],
        amigos  : [],
        path_img_time_line_default : location.origin + '/application/assets/libs/images/dp.jpg'

    },
    mounted:function(){
        var self_vue  = this;
        var url       = App.url("pessoas", "Amigos", "amigos_by_usuario_limit");
        // ------------------profile-------------------
        $.post(url, {}, function(response){
            self_vue.$data.amigos = response.data.amigos;
            },'json');
        $.post(
            App.url("","Home","get_storage_img"),
            {},
            function(json){
                vue_instance_dashboard_activity_local.$data.posts = json.data
            },'json')
        },
    methods:{
        excluir_postagem:function( id, posts ,$index){

            $.post(
                App.url("","Home","delete_time_line"),
                {
                    id:id
                },
                function(json){
                    if(json){
                        vue_instance_dashboard_activity_local.posts.splice($index, 1)
                    }
                    if(!json){
                    }

                },'json')
        },
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
        },
        open_chat : function(){
            $(".chat-content").toggleClass('hide');

        }
    }

    }
);

