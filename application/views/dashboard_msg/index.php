<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php $this->load->view('head/css') ?>
    <link href="<?= URL_RAIZ() ?>application/assets/libs/css/modules/msg_usuarios/dashboard/style.scss"
          rel="stylesheet">
<style>
    /*por algum motivo essa merda nao funcionou no style.scsscscsccsscs*/
    .c-bubble-align-left {
        align-self: flex-end;
        display: flex;
        align-items: center;
    }
    .c-bubble-align-left p {
        background-color:#dadcdc ;
        border: none;
        order: 1;
    }
    .c-bubble-align-left img {
        order: 2;
        margin-right: 10px;
        margin-left: 10px;
    }
</style>
</head>

<body>

<?php if (isset($dados)):
    $data = $dados;
else:
    $data = [];
endif;
?>
<div v-bind:class="display_notification" style="z-index: 1000;position:fixed;float:bottom;right:1%;bottom:10%" v-cloak>
    <section @click="close_notify()">
        <div class="tn-box tn-box-color-2">
            <p>
                {{name_new_message | firstUpperCase}} enviou uma nova mensagem
                &nbsp; <i class="fas fa-flag-checkered"></i>
            </p>
        </div>
    </section>
</div>
<main class="dashboard-mp">
    <?php $this->load->view("menu/menu", compact("data")); ?>
    <div class="div-geral-dashboard">
        <div class='c-app'>
            <aside class='c-sidepanel'>
                <nav class='c-sidepanel__nav'>
                    <ul>
                        <li class='c-sidepanel__nav__li'><a class='c-sidepanel__nav__link' href='javascript:void(0)' title='' @click="inbox()">
                                <i data-feather="inbox"></i>Inbox
                                <span class='c-notification c-notification--nav'>
                                    {{data_all_messages.length}}
                                </span>
                            </a>
                        </li>
                        <li class='c-sidepanel__nav__li'>
                            <a class='c-sidepanel__nav__link' href='javascript:void(0)' title='' @click="anotacoes()">
                                <i data-feather="edit"></i>Anotações
                            </a>
                        </li>
<!--                        <li class='c-sidepanel__nav__li'><a class='c-sidepanel__nav__link' href='' title=''><i data-feather="send"></i>Enviados</a></li>-->
<!--                        <li class='c-sidepanel__nav__li'><a class='c-sidepanel__nav__link' href='' title=''><i data-feather="star"></i>Favourites</a></li>-->
                    </ul>
                </nav>

<!--                <nav class='c-sidepanel__nav c-sidepanel__nav--spacer'>-->
<!--                    <ul>-->
<!--                        <li class='c-sidepanel__nav__li'><a class='c-sidepanel__nav__link c-sidepanel__nav__link--success' href='' title=''><i data-feather="check-circle"></i>Paid</a></li>-->
<!--                        <li class='c-sidepanel__nav__li'><a class='c-sidepanel__nav__link c-sidepanel__nav__link--pending' href='' title=''><i data-feather="clock"></i>Pending</a></li>-->
<!--                        <li class='c-sidepanel__nav__li'><a class='c-sidepanel__nav__link c-sidepanel__nav__link--warning' href='' title=''><i data-feather="trash"></i>Denied</a></li>-->
<!--                    </ul>-->
<!--                </nav>-->

                <nav class='c-sidepanel__nav c-sidepanel__nav--spacer c-friends'>
<!--                    <div class='c-sidepanel__header'>-->
<!--                        <h2>-->
<!--                            Conversas-->
<!--                            <span>-->
<!--                                <ul>-->
<!--                                    <template v-for="(i,l) in data_all_messages">-->
<!--                                        <li class='c-friends__list'>-->
<!--                                            <a class='c-friends__link' href='javascript:void(0)' @click="open_chat(i)">-->
<!--                                                <img class='c-friends__image' :src='i.img_profile.length > 10?i.img_profile:path_img_profile_default'>-->
<!--                                                <span class='c-friends__active'>-->
<!--                                                    {{i.nome | firstUpperCase}}-->
<!--                                                </span>-->
<!--                                            </a>-->
<!--                                        </li>-->
<!--                                    </template>-->
<!--                                </ul>-->
<!--                            </span>-->
<!--                        </h2>-->
<!--                        <button>See All</button>-->
<!--                    </div>-->
                </nav>
            </aside>
            <section class='c-chats inbox'>
                <div class='c-chats__header'>
                    <div>
                        <label aria-label=''><i data-feather='search'></i></label>
                        <input type='text' placeholder='Buscar'>
                    </div>
                </div>
                <ul>
                    <template v-for="(i,l) in data_all_messages">
                        <li class="c-chats__list">
                            <a class="c-chats__link" href="javascript:void(0)" @click="open_chat(i)">
                                <div class="c-chats__image-container">
                                    <img :src='i.img_profile.length > 10?i.img_profile:path_img_profile_default'>
                                </div>
                                <div class="c-chats__info">
                                    <p class="c-chats__title">{{i.nome | firstUpperCase}}</p>
                                    <span>{{i.sobrenome | firstUpperCase}}</span>
<!--                                    <p class="c-chats__excerpt"></p>-->
                                </div>
                            </a>
                        </li>
                    </template>
                </ul>
            </section>
            <section class='c-openchat inbox'>
                <div class='c-openchat__box'>
                    <div class='c-openchat__box__header'>
                        <img class='c-openchat__box__pp' :src='data_user.length && data_user.img_profile.length > 10?data_user.img_profile:path_img_profile_default'>
                        <p class='c-openchat__box__name'>{{data_user.nome | firstUpperCase }} {{data_user.sobrenome | firstUpperCase}}</p>
                        <span class='c-openchat__box__status'></span>
                    </div>
                    <div class='c-openchat__box__info'>
                        <ul>
                           <template v-for="(i,l) in data_messages">
                              <li :class="i.recebendo?'c-bubble':'c-bubble-align-left'">
                                        <template v-if="i.recebendo">
                                            <img class='c-bubble__image' :src='i.img_profile.length > 10?i.img_profile:path_img_profile_default' alt=''>
                                        </template>
                                        <p class='c-bubble__msg'>
                                            {{i.text}}
                                        <span class='c-bubble__timestamp'>
                                            {{i.created_at}}
                                        </span>
                                        </p>
                                    </li>
                            </template>
                        </ul>
                    </div>
                </div>
                <div class="container-input">
                    <div class="right-input">
                        <div class="write-input">
                            <a href="javascript:;" class="write-link attach"></a>
                            <input type="text" />
                            <a href="javascript:;" class="write-link smiley"></a>
                            <a href="javascript:;" class="write-link send"></a>
                        </div>
                    </div>
                </div>
            </section>
            <section class='c-openchat anotacoes hide cards-content'>
                <div class="row-card row-card-first">
                        <template v-for="i in data">
                            <div class="column-card">
                                <div class="card-anotacao">
                                    <h6>{{i.title | crop_string(10)}}
                                        <i class="fas fa-trash cursor-pointer" @click="delete_cart(i._id)"></i>
                                        <i class="fas fa-edit cursor-pointer" @click="edit_cart(l)"></i>
                                        <i class="fas fa-check cursor-pointer" @click="confirm_edit(i._id)"></i>
                                    </h6>
                                    <p class="content-find">{{i.text}}</p>
                                    <textarea class="replt-comnt  area-content-edit hide">{{i.text}}</textarea>
                                </div>
                            </div>
                        </template>
                    <div class="column-card card-add">
                        <div class="card-anotacao">
                            <h6>
                                <input type="text" placeholder="Título" class="title-discussion-input title-add">
                            </h6>
                            <textarea class="replt-comnt area-content-add"></textarea>
                            <i class="fas fa-plus cursor-pointer" @click="add_item()" style="font-size:24px"></i>
                        </div>
                    </div>
                </div>

            </section>
        </div>
    </div>
</main>

<?php $this->load->view("footer/footer"); ?>
<!-- Scripts js -->
<?php $this->load->view("head/js"); ?>
<script type="text/javascript" src="<?= URL_RAIZ() ?>application/assets/js/libs/dashboard_msg/index.js"></script>
<script>
  var vue_instance_dashboard_msg = new Vue({
    el: ".div-geral-dashboard",
    data: {
      width:$(window).width(),
      data:[],
      data_messages:[],
      data_all_messages:[],
      msg:[],
      data_user_local:false,
      path_img_profile_default : location.origin + '/application/assets/libs/images/my-dashboard/my-dp.jpg',
      data_user:false
    },
    mounted:function(){
      App.spinner_start();
      this.get_anotacoes();
      this.get_msg();
    },
    methods:{
          get_msg : function(){
            var self = this;
            var url = App.url("pessoas","Amigos","full_amigos_chat");
            axios({ method: 'post', url : url, data : false })
              .then(function( json ){
                if(json.data.data){
                  vue_instance_dashboard_msg.$data.data_all_messages =  json.data.data;
                  App.spinner_stop();
                }
              });
          },
           get_anotacoes:function(){
             var url = "get_anotacoes"
             $.post(url,{},function(json){vue_instance_dashboard_msg.data = json.data;},'json')
           },
          open_chat:function( data ){
            var login = data.login;
            var self = this;
            var url  = App.url("dashboard_msg","Dashboard_msg","get_msg");
            const params = new URLSearchParams();
            this.chat = true;
            vue_instance_dashboard_msg._data.data_messages = [];
            App.spinner_chat_start();

            params.append('login', login);
            axios({ method: 'post', url : url, data : params })
              .then(function( json ){

                  vue_instance_dashboard_msg._data.data_user = json.data.usuario;
                  vue_instance_dashboard_msg._data.img_profile = json.data.usuario.img_profile;


                  if(json.data.data) {
                    json.data.data.msg.map(function (el,index ) {
                        el.img_profile = json.data.usuario.img_profile;
                      }
                    )
                    vue_instance_dashboard_msg._data.data_messages = json.data.data.msg;
                  }
                  App.spinner_chat_stop();
                }
              );
            var chat = $(".chat-content");

            if( chat.is(":visible") ){
              return false;
            }
            chat.toggleClass('hide');

            setTimeout(function(){
              self.scrollDown();
            },'100')

          },
          scrollDown: function() {
            var height = document.querySelector(".c-openchat").scrollHeight + 100
            $('.messages-content').scrollTop(height);

          },
          anotacoes:function(){
            $(".inbox").hide();
            $(".anotacoes").slideDown();
            $(".c-sidepanel__nav.c-sidepanel__nav--spacer.c-friends").hide();

          },
          inbox:function(){
            $(".inbox").slideDown();
            $(".anotacoes").hide();
            $(".c-sidepanel__nav.c-sidepanel__nav--spacer.c-friends").show();


            var url  = App.url("dashboard_msg","Dashboard_msg","get_msg");

            // this.chat = true;
            vue_instance_dashboard_msg.$data.messages = [];
            App.spinner_chat_start();


            axios({ method: 'post', url : url })
              .then(function( json ){
                var msgs = json.data.data.msg;

                  App.spinner_chat_stop();
                }
              );

          },
          search_hide_show:function(){
            if(this.width <= 600){
              $(".c-chats.inbox").hide()
            }else{
              $(".c-chats.inbox").show()
            }
          },
          delete_cart:function( id ){
            var url = "excluir_nota";
              this.data.splice(id.$oid, 1);
              $.post(url,{
                  id : id
                }
              )
          },
          confirm_edit:function(id,i){
            $('.area-content-edit:eq(' + i +')').hide()
            $('.content-find:eq(' + i +')').show()
            $('.fa-edit:eq(' + i +')').show()
            $('.fa-check:eq(' + i +')').hide()
          },
          edit_cart:function(i){

            $('.area-content-edit:eq(' + i +')').show()
            $('.content-find:eq(' + i +')').hide()
            $('.fa-edit:eq(' + i +')').hide()
            $('.fa-check:eq(' + i +')').show()
          },

          add_item:function(){
            var text = $(".area-content-add").val()
            var title = $(".title-add").val();
            var self = this;

            if(_.isEmpty(text) && _.isEmpty(title)){
              $(".area-content-add").css('border-color','red');
              $(".title-add").css('border-color','orange');
              return false
            }

            var url = "salvar_notas";
            $.post(url,{
              text  : text,
              title : title
            },function( json ){
                  vue_instance_dashboard_msg.data.push(json.data)

              },'json'
            )
          },
          onChange() {

          },
        }
    }
  );

  feather.replace();

  // vue_instance_dashboard_msg.$data.app.init();


</script>

</body>

</html>