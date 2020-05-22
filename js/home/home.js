if ( window.history.replaceState ) {
    window.history.replaceState( null, null, window.location.href );
}
var home = {
    Url: function (metodo, params) {
        return App.url("", "Home", metodo, params);
    }

};

var vm = new Vue({
      el: '#div-geral-time-line',
      data: {
          img_profile: '',
          img_cover: '',
          users_menu: [],
          path_img_profile_default: location.origin + '/application/assets/libs/images/my-dashboard/my-dp.jpg',
          path_img_cover_default: location.origin + '/application/assets/libs/images/event-view/my-bg.jpg',
          path_img_time_line_default: location.origin + '/application/assets/libs/images/event-view/user-1.jpg',
          posts: [],
          loading: false,
          error_input_file: false,
          error_text_area: false,
          acData: [],
          inputData: '',
          focusIndex: '',
          inputFocus: false,
          action_like:'fas fa-heart',
          display_notification:'hide'

      },
      created () {
          this.getPosts()
      },
      mounted: function () {

          var self_vue = this;
          var url = App.url("area_a", "Area_a", "get_img");
          // ------------------profile-------------------
          $.post(url, { type: "profile" }, function (response) {self_vue.$data.img_profile = response.path;}, 'json');
          // -------------------cover-------------------
          var url = App.url("area_a", "Area_a", "get_img");
          $.post(url, { type: "cover" }, function (response) {self_vue.$data.img_cover = response.path;}, 'json');
          var url = App.url("pessoas", "Pessoas", "get_img_menu_pessoas");
          // ------------------menu-pessoas-------------------
          $.post(url, {}, function (response) {
              self_vue.$data.users_menu = response.data.all_users;
          }, 'json');
      },
      methods: {
          getPosts () {
              // for (var i = 0; i < 5; i++) {
              //     var count = this.posts.length + i
              //     this.posts.push({count})
              // }
          },
          openfile: function () {
            $('#input-file-postagem').click();
          },
          excluir_postagem: function (id, posts, $index) {
            var url = App.url("", "Home", "delete_time_line");
              $.post( url, { id: id },
                function (json) { if (json) { vm.posts.splice($index, 1)} }, 'json')
          },
          postar: function () {

              var data = new FormData();
              data.append('fileimagem', $('#input-file-postagem')[0].files[0]);
              data.append('text', $('#text-area-postagem').val());
              var url = home.Url("add_time_line");

              if ($('#input-file-postagem').val() == "") {
                  vm.error_input_file = true;
                  return false;
              } else {
                  vm.error_input_file = false;
              }
              if ($('#text-area-postagem').val() === "") {
                  vm.error_text_area = true;
                  return false;
              } else {
                  vm.error_text_area = false;
              }
              $.ajax({
                    url: url,
                    data: data,
                    processData: false,
                    contentType: false,
                    type: 'POST',
                    dataType: 'json',
                    success: function (response) {
                        var text_area = $('#text-area-postagem').val();
                        if (response) {
                            var data = {
                                'text': text_area,
                                'path': response.path,
                                '_id': response.id
                            };
                            vm.posts.unshift(data);
                        }
                    }
                }
              );

              $('#input-file-postagem').val("");
              $('#text-area-postagem').val("");
          },
          add_person: function (id, l) {
              $.post(
                App.url("pessoas", "Amigos", "add_person"),
                {
                    id: id
                },
                function (json) {
                    if (json === "delete") {
                        $(".div-confirmada-solicitacao:eq(" + l + ")").hide();
                        $(".btn-enviar-solicitacao:eq(" + l + ")").show();

                    }
                    if (json === "add") {
                        $(".div-confirmada-solicitacao:eq(" + l + ")").show();
                        $(".btn-enviar-solicitacao:eq(" + l + ")").hide();
                    }

                }, 'json')

          },
          redirect_user: function (id) {
              var url = App.url("dashboard_activity", "Dashboard_activity", "index");
              $.post(
                url,
                {
                    id: id
                },
                function (json) {
                    window.location.href = App.url("dashboard_activity", "Dashboard_activity", "external/" + id);
                }, 'json')

          },
          compute_like: function (data,index) {
              var self = this;
              var url = App.url("", "Home", "compute_like");
              var qtd = this.posts[index].count_like;

              const params = new URLSearchParams();
              params.append('id', data._id);
              axios({ method: 'post', url: url, data: params }).then(function (json) {
                if(json.data === 'like'){
                  $(".left-comments:eq(" + index + ")").find(".fa-heart").addClass('text-like');
                  self.posts[index].count_like = qtd + 1;
                }else if(json.data === 'dislike'){
                  $(".left-comments:eq(" + index + ")").find(".fa-heart").removeClass('text-like');
                  self.posts[index].count_like = qtd - 1;
                }

              });
          },
        showImg ( path ) {
          vue_lightbox._data.imgs = path
           vue_lightbox._data.visible = true
           vue_lightbox._data.edit = false
        },

      }
  }
);
$.post( home.Url("get_storage_img/" + true), {}, function(json){vm.$data.posts = json.data},'json');
