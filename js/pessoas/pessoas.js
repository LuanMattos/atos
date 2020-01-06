var pessoas = {
    Url: function (metodo, params) {
        return App.url("pessoas", "Pessoas", metodo, params);
    },
    Init:function(){

        $.post(
            pessoas.Url("data_full_user"),
            {},
            function(json){
                console.log(json);

                new Vue({
                    el:"#div-geral-pessoas-full",
                    data:{

                    }
                })
            },'json')
    }
}
