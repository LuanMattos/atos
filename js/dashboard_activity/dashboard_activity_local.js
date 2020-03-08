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
        // -------------------------------------------
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
        Fake : [],
        ico_minimize_maximise : 'fas fa-window-minimize',
        minimize_class : '',
        user: 'Anônimo',
        text: null,
        messages: [],
        ws: null,
        data_user : '',
        status : []

    },
    mounted:function(){
        var self_vue  = this;
        var url = App.url("dashboard_msg","Dashboard_msg","get_msg_local");
        $.post(url, {}, function( json ){ self_vue.data_user = json },'json')
        // ------------------profile-------------------
        var url  = chat.Url("get_img");
        $.post(url, {type:"profile"}, function(response){self_vue.$data.img_profile = response.path;},'json');
        // ------------------cover------------------
        var url  = chat.Url("get_img");
        $.post(url, {type:"cover"}, function(response){self_vue.$data.img_cover = response.path;},'json');

        // var $messages = $('.messages-content'),
        //   d, h, m,
        //   i = 0;
        // $messages.mCustomScrollbar();
        // setTimeout(function() {
        //     self_vue.fakeMessage();
        // }, 100);
        this.connect();


    },
    methods:{
        // Método responsável por iniciar conexão com o websocket
        connect: function(onOpen) {

            var self = this;

            // Conectando
            // wss://echo.websocket.org
            self.ws = new WebSocket('ws://0.0.0.0:1000');

            // Evento que será chamado ao abrir conexão
            self.ws.onopen = function(e) {

                self.addSuccessNotification('Online');
                // Se houver método de retorno
                if (onOpen) {
                    onOpen();
                }
            };


            // Evento que será chamado quando houver erro na conexão
            self.ws.onerror = function(e) {
                self.addErrorNotification('Não foi possível conectar-se ao servidor');
            };

            // Evento que será chamado quando recebido dados do servidor
            self.ws.onmessage = function(e) {
                self.addMessage(JSON.parse(e.data));
            };

        },
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

        // Método responsável por adicionar uma mensagem de usuário
        addMessage: function(data) {
            this.messages.push(data);
            this.scrollDown();
        },
        addMessageNotification:function(data){
            this.status.push(data);

        },
        // Método responsável por adicionar uma notificação de sucesso
        addSuccessNotification: function(text) {
            this.addMessageNotification({color: '#5490fe', text: text});
        },

        // Método responsável por adicionar uma notificação de erro
        addErrorNotification: function( text ) {
            this.addMessageNotification({color: '#a7acaa', text: text});
        },

        // Método responsável por enviar uma mensagem
        sendMessage: function() {
            var self = this;
            var data_msg = { text : this.text,date : this.setDate(),user:this.data_user.usuario_local.nome };

            if ( !this.text ) {
                return false;
            }

            this.messages.push( data_msg );

            $('.messages-content').appendTo($('.mCSB_container')).addClass('new');

            // this.updateScrollbar();
            //-----gravar dados do próprio usuario no banco------

            console.log(self.ws)

            // Se a conexão não estiver aberta
            if (self.ws.readyState !== self.ws.OPEN) {
                // Exibindo notificação de erro
                self.addErrorNotification('Problemas na conexão. Tentando reconectar...');

                // Tentando conectar novamente e caso tenha sucesso
                // envia a mensagem novamente
                self.connect(function() {
                    self.sendMessage();
                });

                return;
            }

            // Envia os dados para o servidor através do websocket
            self.ws.send(JSON.stringify({
                user: this.data_user.usuario_local.nome,
                text: this.text,
            }));

            this.scrollDown();
            this.text = null;


        },

        // Método responsável por "rolar" a scroll do chat para baixo
        scrollDown: function() {
            var container = this.$el.querySelector('.messages');
            container.scrollTop = container.scrollHeight;
        },


    }

});



