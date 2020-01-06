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
        posts: [],
        loading: false,
        error_input_file:false,
        error_text_area:false
    },
    created() {
        this.getPosts()
    },
    methods: {
        getPosts() {
            // for (var i = 0; i < 5; i++) {
            //     var count = this.posts.length + i
            //     this.posts.push({count})
            // }
        },
        openfile:function(){
            $("#input-file-postagem").click();
        },
        postar:function(){
            var url = home.Url("add_time_line");

            var data = new FormData();
            data.append('fileimagem', $('#input-file-postagem')[0].files[0]);

            if($('#input-file-postagem').val() == ""){
                vm.error_input_file = true;
                return false;
            }else{
                vm.error_input_file = false;
            }
            if($('#text-area-postagem').val() == ""){
                vm.error_text_area = true;
                return false;
            }else{
                vm.error_text_area = false;
            }


            $.ajax({
                url: url,
                data: data,
                processData: false,
                contentType: false,
                type: 'POST',
                dataType:'json',
                success: function(response) {
                    var text_area = $('#text-area-postagem').val();
                    if(response){
                        var data = {
                            'frase' : text_area,
                            'path' : response.path
                        };
                        console.log(response.path);
                        vm.posts.push(data);

                    }
                }
            });

        }
    }
});

$.post(
    home.Url("get_storage_img"),
    {},
    function(json){

            vm.$data.posts = json.data

    },'json')