var cadastro_usuarios = {

    Url: function (metodo, params) {
        return App.url("unico", "cadastro_unico/Cadastro_usuarios", metodo, params);
    },

    Init: function () {
        var self = this;
        $.post(
            self.Url("index"),
            {},
            function (j) {
                App.modal({
                    title: "Cadastro usuários",
                    vue:j.html,
                    callback: function (content) {
                        var div = content.target;
                        var vue_instance = new Vue({
                            el: div,
                            data: {
                                data: j.data,
                                search: "",
                                links: j.data.links
                            },
                            methods: {
                                excluir: function (el, codigo) {
                                    App.alerta("Deseja excluir o registro?", {
                                        "Sim": function (event) {
                                            $.post(
                                                cadastro_usuarios.Url("excluir", codigo),
                                                {},
                                                function (j) {
                                                    if (j.info) {
                                                        vue_instance.$delete(vue_instance.$root.data, el);

                                                        $(".buscar").click();

                                                    }
                                                    if(!j.info){
                                                        App.error(j.msg);
                                                    }
                                                }, 'json')
                                            $(this).dialog("close");
                                        },
                                        "Não": function () {
                                            $(this).dialog("close");
                                        }
                                    });
                                },
                                busca: function () {

                                    $.post(
                                        cadastro_usuarios.Url("index"),
                                        {
                                            search: this.search
                                        },
                                        function (j) {
                                            vue_instance.data = j.data;
                                        }, 'json')

                                },
                                editar: function (codigo) {
                                    cadastro_usuarios.Form(codigo);
                                }
                            },


                        });

                        $(".novo").click(function () {
                            self.Form();
                        });
                    }
                });


            }, 'json')


    },
    Form: function (codigo) {
        var self = this;
        var title = "Novo registro"

        if (typeof codigo != "undefined" && codigo != "") {
            title = "Editando - registro";
            var editar = true;
        }

        $.post(
            self.Url("salvar", codigo),
            {},
            function (j) {
                App.modal({
                    title: title,
                    width: "950px",
                    vue:j.html,
                    callback: function (content) {
                        var modal = $(this);
                        var dialog = content;
                        var div = content.target;


                        var vue_instance_form = new Vue({
                            el: div,
                            data: {
                                dados: {
                                    codigo   : j.data.codigo,
                                    login    : j.data.login  || "",
                                    senha    : j.data.senha  || "",
                                    repsenha : ""
                                }

                            },
                            methods: {
                                closemodal: function () {
                                    var self_modal = modal;
                                    self_modal.dialog("close");
                                }

                            }
                        }
                    );


                        $(".btn-salvar").click(function (event) {
                            event.preventDefault();
                            event.stopPropagation();

                            self.Salvar(vue_instance_form);

                        });

                    }
                });

            }, 'json')


    },

    Salvar: function (vue_instance) {
        var self = this;
        var data = vue_instance.dados;

        $.post(
            self.Url("acao_salvar"),
            {
                data : data
            },
            function (j) {
                if (j.info) {

                    $(".buscar").click();
                    App.close_modal();

                }
                if(!j.info){
                    App.error(j.msg);
                }

            }, 'json')

    },


}