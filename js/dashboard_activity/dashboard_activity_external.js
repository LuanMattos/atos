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
        },
        open_chat : function(external){
            if(external){
                $(".chat-content").toggleClass('hide');
            }
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
        ico_minimize_maximise    : 'fas fa-window-minimize',
        minimize_class : '',
        user: 'Anônimo',
        text: null,
        messages: [],
        ws: null,
        data_user : '',
        status : [],
        here:false,
        user_local:false
    },
    mounted:function(){

        var self_vue  = this;

        //dados usuario externo

        var id  = window.location.href.split(App.url("dashboard_activity", "Dashboard_activity", "external/"))[1];
        var url = App.url("dashboard_msg","Dashboard_msg","get_msg/" + true);
        const params = new URLSearchParams();

        params.append('id', id);
        axios({ method: 'post', url : url, data : params })
        .then(function( json ){ self_vue.data_user = json.data;});

        // ------------------profile-------------------
        var url  = chat.Url("get_img");
        $.post(url, {type : "where",id : id}, function(response){self_vue.$data.img_profile = response.path;},'json');
        // ------------------cover------------------

        //dados usuario local
        var url = App.url("dashboard_msg","Dashboard_msg","get_msg" );
        axios({ method: 'post', url : url, data : null })
          .then(function( json ){ self_vue.user_local = json.data;self_vue.connect()});

    },
    methods:{
        // Método responsável por iniciar conexão com o websocket
        connect: function(onOpen) {

            var self = this;
            var _id = this._data.user_local.data.codusuario;

            if(!_.isUndefined(_id) && !_.isEmpty(_id)){
                self.ws = new WebSocket('ws://localhost:8050?' + _id);
            }else{
                console.debug("Usuário não possui identificação válida!");
                return false;
            }

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
            var data_msg = { text : this.text,date : this.setDate(),user:this.data_user.usuario.nome };

            if ( !this.text ) {
                return false;
            }

            this.messages.push( data_msg );

            $('.messages-content').appendTo($('.mCSB_container')).addClass('new');

            // this.updateScrollbar();
            //-----gravar dados do próprio usuario no banco------


            // Se a conexão não estiver aberta
            if (self.ws.readyState !== self.ws.OPEN) {
                self.addErrorNotification('Problemas na conexão. Tentando reconectar...');

                self.connect(function() {
                    self.sendMessage();
                });

                return;
            }

            var self = this;
            var id  = window.location.href.split(App.url("dashboard_activity", "Dashboard_activity", "external/"))[1];
            var url = App.url("dashboard_msg","Dashboard_msg","get_msg/" + true);
            const params = new URLSearchParams();

            params.append('id', id);
            axios({ method: 'post', url : url, data : params })
              .then(function( json ){

                  var channel = json.data.usuario.channel;

                  // Envia os dados para o servidor através do websocket
                  self.ws.send(JSON.stringify({
                      user        : self.data_user.usuario.nome,
                      text        : self.text,
                      img_profile : self.data_user.usuario.img_profile,
                      class_text  : 'msg-local-here',
                      channel     : channel,
                      command:'message'
                  }));

                  self.scrollDown();
                  self.text = null;
                  self.here = true;
              });

        },
        // Método responsável por "rolar" a scroll do chat para baixo
        scrollDown: function() {
            var container = this.$el.querySelector('.messages');
            container.scrollTop = container.scrollHeight;
        },
    },



});
