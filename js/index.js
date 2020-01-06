var index = {
    Url: function (metodo, params) {
        return App.url("", "Home", metodo, params);
    }
}

$("#formulario-cadastro").hide();

    var vue_instance = new Vue({
        el: ".register-mp",
        data: {
            error: "",
            form: {
                email: "",
                senhacadastro: "",
                repsenha: "",
                datanasc: "",
                telcel: "",
                nome:"",
                sobrenome:"",
                telcodpais:"55"

            }
        }
    });

    var bg = $(".body-bg");

    bg.find(".login-btn").on("click", function (event) {
        event.preventDefault();
        event.stopPropagation();
        vue_instance.form.telcel = $("input[name='telcel']").val();
        $.post(
            index.Url("acao_cadastro"),
            {
                data: vue_instance.form,

            },
            function (j) {
                if(!j.info){
                    vue_instance.error = j.error;
                }
                if(j.info){
                    console.log(j.info);
                    window.location.href = App.url("verification","Verification","index");
                }

            }, 'json');


    });

    bg.find("#comecar").click(function () {

        bg.find("#formulario-cadastro").slideToggle();
        bg.find("#formulario-login").hide();
    });

    bg.find("#back").click(function () {
        bg.find("#formulario-cadastro").hide();
        bg.find("#formulario-login").slideToggle();
    });




