var vue_instance_menu_chat = new Vue({
  el:"#hangout",
  data:{
    amigos : []
  },
  mounted : function(){
    this.get_amigos_chat();
  },
  methods:{
    get_amigos_chat:function(){
      var self = this;
      var url = App.url("pessoas","Amigos","full_amigos_chat");

      axios({ method: 'post', url : url, data : {} })
        .then(function( json ){ self.amigos = json.data.data;});
    },
    open_chat:function( data ){
      var login = data.login;
      var self = this;
      var url  = App.url("dashboard_msg","Dashboard_msg","get_msg");
      const params = new URLSearchParams();

      params.append('login', login);
      axios({ method: 'post', url : url, data : params })
        .then(function( json ){
          vue_instance_chat._data.data_user = json.data;
          vue_instance_chat._data.img_profile = json.data.usuario.img_profile;
        });
      var chat = $(".chat-content");

      if( chat.is(":visible") ){
        return false;
      }
      chat.toggleClass('hide');
    },
    close_menu_chat:function(){
      $(".content-menu-chat").toggleClass('hide-transition');
    }
  }
})


var GLOBALSTATE = {
  route: '.list-account'
};

setRoute(GLOBALSTATE.route);
$('.nav > li[data-route="' + GLOBALSTATE.route + '"]').addClass('active');

setName(localStorage.getItem('username'));

if (localStorage.getItem('color') !== null) {
  var colorarray = JSON.parse(localStorage.getItem('color'));
  stylechange(colorarray);
} else {
  var colorarray = [51,102,153,1];
  localStorage.setItem('color', JSON.stringify(colorarray));
  stylechange(colorarray);
}


function setName(name) {
  $.trim(name) === '' || $.trim(name) === null ? name = 'Taras Anichin' : name = name;
  $('h1').text(name);
  localStorage.setItem('username', name);
  $('#username').val(name).addClass('used');
  $('.card.menu > .header > h3').text(name);
}


function stylechange(arr) {
  var x = 'rgba(' + arr[0] + ',' + arr[1] + ',' + arr[2] + ',1)';
}

function setRoute(route) {
  GLOBALSTATE.route = route;
  $(route).addClass('shown');

  if (route !== '.list-account') {
    $('#add-contact-floater').addClass('hidden');
  } else {
    $('#add-contact-floater').removeClass('hidden');
  }

  if (route !== '.list-text') {
    $('#chat-floater').addClass('hidden');
  } else {
    $('#chat-floater').removeClass('hidden');
  }

  if (route === '.list-chat') {
    $('.mdi-menu').hide();
    $('.mdi-arrow-left').show();
    $('#content').addClass('chat');
  } else {
    $('#content').removeClass('chat');
    $('.mdi-menu').show();
    $('.mdi-arrow-left').hide();
  }
}




$('.search-filter').on('keyup', function() {
  var filter = $(this).val();
  $(GLOBALSTATE.route + ' .list > li').filter(function() {
    var regex = new RegExp(filter, 'ig');

    if (regex.test($(this).text())) {
      $(this).show();
    } else {
      $(this).hide();
    }
  });
});

