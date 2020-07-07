<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php $this->load->view('head/css') ?>
    <link href="<?= URL_RAIZ() ?>application/assets/libs/css/modules/msg_usuarios/dashboard/style.scss"
          rel="stylesheet">

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
                        <li class='c-sidepanel__nav__li'><a class='c-sidepanel__nav__link' href='javascript:void(0)' title='' @click="anotacoes()"><i data-feather="inbox"></i>Inbox <span class='c-notification c-notification--nav'>404</span></a></li>
                        <li class='c-sidepanel__nav__li'><a class='c-sidepanel__nav__link' href='javascript:void(0)' title='' @click="inbox()"><i data-feather="edit"></i>Anotações</a></li>
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
                    <div class='c-sidepanel__header'>
                        <h2>Amigos<span></span></h2>
<!--                        <button>See All</button>-->
                    </div>
                </nav>
            </aside>
            <section class='c-chats inbox'>
                <div class='c-chats__header'>
                    <div>
                        <label aria-label=''><i data-feather='search'></i></label>
                        <input type='text' placeholder='Buscar'>
                    </div>
                </div>
            </section>
            <section class='c-openchat inbox'>
                <div class='c-openchat__box'>
                    <div class='c-openchat__box__header'>
                        <img class='c-openchat__box__pp' src='' alt=''>
                        <p class='c-openchat__box__name'>Aaron McGuire</p>
                        <span class='c-openchat__box__status'></span>
                    </div>
                    <div class='c-openchat__box__info'></div>
                </div>
            </section>
            <section class='c-chats anotacoes hide'>
                <div class='c-chats__header'>
                    <div>
                        <label aria-label='Search your active chats.'><i data-feather='search'></i></label>
                        <input type='text' placeholder='Buscar anotações'>
                    </div>
                </div>
            </section>
            <section class='c-openchat anotacoes hide cards-content'>
                <div class="row-card row-card-first">
                        <template v-for="(i,l) in data">
                            <div class="column-card">
                                <div class="card-anotacao">
                                    <h6>{{i.title | crop_string(10)}}
                                        <i class="fas fa-trash cursor-pointer" @click="delete_cart(i._id,l)"></i>
                                        <i class="fas fa-edit cursor-pointer" @click="edit_cart(l)"></i>
                                        <i class="fas fa-check cursor-pointer" @click="confirm_edit(i._id,l)"></i>
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
      data:''
    },
    mounted:function(){
      var url = "get_anotacoes"
      $.post(url,{},function(json){vue_instance_dashboard_msg.data = json.data;},'json')
    },
    methods:{
          inbox:function(){
            $(".inbox").hide();
            $(".anotacoes").slideDown();
          },
          anotacoes:function(){
            $(".inbox").slideDown();
            $(".anotacoes").hide();
          },
          search_hide_show:function(){
            if(this.width <= 600){
              $(".c-chats.inbox").hide()
            }else{
              $(".c-chats.inbox").show()
            }
          },
          delete_cart:function( id,i ){
            console.log(id)
            var url = "excluir_nota";
            if(this.data[i]._id.$oid === id.$oid) {
              this.data.splice(id.$oid, 1);
              $.post(url,{
                  id : id
                }
              )
            }
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
          }
        }
    }
  );



  feather.replace();

  let app = {
    currentUserID: 59284,
    friends: [
      {
        id: 78845,
        name: "Daniel Bookton",
        pp: "https://s.cdpn.io/profiles/user/739421/80.jpg?1557442808",
        lastActive: `${Math.floor(Math.random() * Math.floor(60))} mins`
      },

    ],
    chats: [
      {
        chatID: "D-09182",
        users: [59284, 78845],
        chatTitle: "Website Quote",
        msgs: [
          {
            user: 78845,
            message: "I want you to design something for me",
            timeStamp: "2020-08-20 15:30:00"
          },
          {
            user: 59284,
            message: "Cool, what did you have in mind?",
            timeStamp: "2020-08-20 15:32:00"
          }
        ]
      }
    ],
    renderFriends: function () {
      if (this.friends) {
        document.querySelector(
          ".c-friends .c-sidepanel__header h2 span"
        ).innerHTML = ` (${this.friends.length})`;
        let friendContainer = document.createElement("ul");
        this.friends.forEach((friend) => {
          let friendTemplate = `<li class='c-friends__list'><a class='c-friends__link' href='' title=''><img class='c-friends__image' src='${friend.pp}' alt=''> ${friend.name}<span class='c-friends__active'>${friend.lastActive}</span></a></li>`;
          friendContainer.innerHTML += friendTemplate;
        });

        document.querySelector(".c-friends").append(friendContainer);
      } else {
        console.warn("You've got no friends 😔");
      }
    },
    renderActiveChats: function () {
      // Check we actually have chats available
      if (this.chats) {
        let openChatContainer = document.createElement("ul");
        this.chats.forEach((chat) => {
          chat.users.forEach((id) => {
            let user = id;
            /* loop through friends to check if the id of the current chat matches that user. In this POC the first id in the object is the current user */
            this.friends.forEach((friend) => {
              if (user === friend.id && user !== this.currentUserID) {
                let chatTemplate = `<li class='c-chats__list'><a data-id='${
                  chat.chatID
                }' class='c-chats__link' href='' title=''><div class='c-chats__image-container'><img src='${
                  friend.pp
                }' alt=''></div><div class='c-chats__info'><p class='c-chats__title'>${
                  chat.chatTitle ? chat.chatTitle : friend.name
                }</p><span>${
                  chat.msgs[chat.msgs.length - 1].timeStamp
                }</span><p class='c-chats__excerpt'>${
                  chat.msgs[chat.msgs.length - 1].message
                }</p></div></a></li>`;
                openChatContainer.innerHTML += chatTemplate;
              }
            });
          });
          document.querySelector(".c-chats").append(openChatContainer);
        });
      } else {
      }
    },
    handleChatOptions: function () {
      var activeChats = document.querySelectorAll('.c-chats__list');
      if(activeChats.length > 0 ) {
        let newestChat = activeChats[0].childNodes[0].dataset.id;

        this.chats.forEach((chat) => {
          if(newestChat === chat.chatID) {
            var chatBubbleContainer = document.createElement("ul");
            chat.msgs.forEach((message) => {
              let bubbleTemplate = `<li class='c-bubble'><img class='c-bubble__image' src='' alt=''> <p class='c-bubble__msg'>${message.message}<span class='c-bubble__timestamp'>${message.timeStamp}</span></p></li>`;

              chatBubbleContainer.innerHTML += bubbleTemplate;
              console.log(chatBubbleContainer);
            });
            document.querySelector('.c-openchat__box__info').append(chatBubbleContainer);
          }

        })
      }
    },
    init: function () {
      this.renderFriends();
      this.renderActiveChats();
      this.handleChatOptions();
    }
  };
  console.clear();
  app.init();


</script>

</body>

</html>