var config = {
    Url: function (metodo, params) {
        return App.url("account_settings/", "Account_settings", metodo, params);
    }
};

$(function () {


    var pais_option =  $("#selec-pais option:selected").val();
    if(pais_option === ""){
        $("#telcel").attr("disabled",true);
    }else{
        $("#telcel").attr("disabled",false);
    }

    var vue_instance = new Vue({
        el: "#main-config-account-settings",
        data: {
            informacoes_pessoais: {
                data_cidade: "",
                error:false,
                success:""
            },
        },
        methods: {
        acao_salvar_informacoes_pessoais:function(){
                const url = config.Url("acao_salvar_informacoes_pessoais");
                const data = App.form_data("#form-informacoes-pessoais");

                $.ajax({
                    method:"POST",
                    dataType:"json",
                    url,
                    data:data,
                    success:function(json){
                        if(!json.info){
                            vue_instance.informacoes_pessoais.error = json
                                }
                        if(json.msg){
                            vue_instance.informacoes_pessoais.success = json.msg
                                }
                            }
                        }
                    );
        },MenuconfigClick: function (id) {
                $(".config-itens").slideUp();

                this.informacoes_pessoais.error = "";
                this.informacoes_pessoais.success = "";

                switch (id) {
                    case 1:

                        $("#div-geral-config-informacoes-pessoais-index").slideDown();
                        break;
                    case 2:
                        $("#div-geral-config-perfil-index").slideDown();
                        break;
                    case 3:
                        $("#div-geral-config-requisicoes-amizades").slideDown();
                        break;
                    case 4:
                        $("#div-geral-config-redes-sociais").slideDown();
                        break;
                    case 5:
                        $("#div-geral-config-email").slideDown();
                        break;
                    case 6:
                        $("#div-geral-config-notificacoes").slideDown();
                        break;
                    case 7:
                        $("#div-geral-mudar-senha").slideDown();
                        break;
                    case 8:
                        $("#div-geral-desativar-conta").slideDown();
                        break;
                }
            },
        }
    });
})
