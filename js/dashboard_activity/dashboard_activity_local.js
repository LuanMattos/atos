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
            var url = App.url("dashboard_msg","Dashboard_msg","get_msg_local");

            $.post(url,
              {},
              function( json ){
                console.log(json);

              },'json')


            $(".chat-content").toggleClass('hide');

        }
    }

    }
);


var chat = {
    Url: function (metodo, params) {
        return App.url("area_a", "Area_a", metodo, params);
    }
}
var vue_instance_chat = new Vue({
    el:"#content-chat",
    data:{
        data_users               : [],
        img_profile              : '',
        img_cover                : '',
        path_img_profile_default : location.origin + '/application/assets/libs/images/my-dashboard/my-dp.jpg',
        path_img_cover_default   : location.origin + '/application/assets/libs/images/event-view/my-bg.jpg',
        messages_content:'',
        Fake : [
            'Hi there, I\'m Fabio and you?',
            'Nice to meet you',
            'How are you?',
            'Not too bad, thanks',
            'What do you do?',
            'That\'s awesome',
            'Codepen is a nice place to stay',
            'I think you\'re a nice person',
            'Why do you think that?',
            'Can you explain?',
            'Anyway I\'ve gotta go now',
            'It was a pleasure chat with you',
            'Time to make a new codepen',
            'Bye',
            ':)'
        ],
        ico_minimize_maximise : 'fas fa-window-minimize',
        minimize_class : ''

    },
    mounted:function(){
        var self_vue  = this;
        // ------------------profile-------------------
        var url  = chat.Url("get_img");
        $.post(url, {type:"profile"}, function(response){self_vue.$data.img_profile = response.path;},'json');
        // ------------------cover------------------
        var url  = chat.Url("get_img");
        $.post(url, {type:"cover"}, function(response){self_vue.$data.img_cover = response.path;},'json');

        var $messages = $('.messages-content'),
          d, h, m,
          i = 0;
        $messages.mCustomScrollbar();
        setTimeout(function() {
            self_vue.fakeMessage();
        }, 100);

    },
    methods:{
        fakeMessage : function(){
            var i = 0;
            var self = this;
            if ($('.message-input').val() != '') {
                return false;
            }
            $('<div class="message loading new"><figure class="avatar"><img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/156381/profile/profile-80.jpg" /></figure><span></span></div>').appendTo($('.mCSB_container'));
            this.updateScrollbar();

            setTimeout(function() {
                $('.message.loading').remove();
                $('<div class="message new"><figure class="avatar"><img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/156381/profile/profile-80.jpg" /></figure>' + self.Fake[i] + '</div>').appendTo($('.mCSB_container')).addClass('new');
                self.setDate();
                self.updateScrollbar();
                i++;
            }, 1000 + (Math.random() * 20) * 100);
        },
        setDate:function(){
            var d = new Date();
            var m = '';
            if (m != d.getMinutes()) {
                m = d.getMinutes();
                $('<div class="timestamp">' + d.getHours() + ':' + m + '</div>').appendTo($('.message:last'));
            }
        },
        minimize_maximize : function(){

            switch (this.ico_minimize_maximise) {
                case 'fas fa-window-minimize' :
                    this.ico_minimize_maximise = 'fas fa-level-up-alt';
                    this.minimize_class = 'minimize-chat';
                break;
                 case 'fas fa-level-up-alt' :
                    this.ico_minimize_maximise = 'fas fa-window-minimize';
                    this.minimize_class = '';
                break;

            }

            // <!--                fa-window-maximize-->
            // <!--                -->
            // $(".fa-window-minimize").show();
            // $(".fa-window-maximize").hide();
        },
        close:function(event){
            $(event.target).parent().parent().parent().parent().addClass('hide');
        },
        updateScrollbar:function(){
            var messages_content = $('.messages-content');
            messages_content.mCustomScrollbar("update").mCustomScrollbar('scrollTo', 'bottom', {
                scrollInertia: 10,
                timeout: 0
            });
        },
        insertMessage:function(){
            var msg = $('.message-input').val();
            var self = this;
            if ($.trim(msg) == '') {
                return false;
            }
            $('<div class="message message-personal">' + msg + '</div>').appendTo($('.mCSB_container')).addClass('new');
            this.setDate();

            $('.message-input').val(null);
            this.updateScrollbar();
            setTimeout(function() {
                self.fakeMessage();
            }, 1000 + (Math.random() * 20) * 100);
        },


    }

});

