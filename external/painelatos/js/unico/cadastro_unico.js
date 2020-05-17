var cadastro_unico = {

    Url: function (metodo, params) {
        return App.url("unico", "cadastro_unico/Cadastro_unico", metodo, params);
    },

    Init: function () {
        var self = this;
        $.post(
            self.Url("index"),
            {},
            function (j) {
                App.modal({
                    title: "Cadastro Único",
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
                                            $.ajax(
                                                cadastro_unico.Url("excluir", codigo),
                                                {},
                                                function (j) {
                                                }, 'json')
                                            vue_instance.$delete(vue_instance.$root.data, el);
                                            $(this).dialog("close");
                                        },
                                        "Não": function () {
                                            $(this).dialog("close");
                                        }
                                    });
                                },
                                busca: function () {

                                    $.post(
                                        cadastro_unico.Url("index"),
                                        {
                                            search: this.search
                                        },
                                        function (j) {
                                            vue_instance.data = j.data;
                                        }, 'json')

                                },
                                editar: function (codigo) {
                                    cadastro_unico.Form(codigo);
                                }
                            },


                        });

                        $(".novo").click(function () {
                            self.Form();
                        });



                            // $('#demo').pagination({
                            //     dataSource: [1, 2, 3, 4, 5, 6, 7, 15],
                            //     pageSize: 5,
                            //     showNavigator: true,
                            //     formatNavigator: '',
                            //     position: 'top',
                            //     beforePageOnClick:function(event){
                            //       event.preventDefault();
                            //     },
                            //     beforeNextOnClick:function(event){
                            //       event.preventDefault();
                            //     },
                            //     beforePreviousOnClick:function(event){
                            //       event.preventDefault();
                            //     },
                            //     className: 'paginationjs-theme-blue',
                            //     callback: function (data, pagination) {
                            //
                            //
                            //         // template method of yourself
                            //         var html = template(data);
                            //         dataContainer.html(html);
                            //     }
                            // });



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
                                    codigo          : j.data.codigo,
                                    nome            : j.data.nome || "",
                                    cpf             : j.data.cpf || "",
                                    rg              : j.data.rg || "",
                                    orgaoemissor    : j.data.orgaoemissor || "",
                                    email           : j.data.email || "",
                                    cnh             : j.data.cnh || "",
                                    nis             : j.data.nis || "",
                                    pis             : j.data.pis || "",
                                    celular         : j.data.celular || "",
                                    teleresidencial : j.data.teleresidencial || "",
                                    fax             : j.data.fax || "",
                                    endereco        : j.data.endereco || "",
                                    cep             : j.data.cep || "",
                                    numero          : j.data.numero || "",
                                    bairro          : j.data.bairro || "",
                                    cidade          : j.data.cidade || "",
                                    estado          : j.data.estado || "",
                                    pais            : j.data.pais || "",
                                    certidao_nasc   : j.data.certidao_nasc || "",
                                    agencia         : j.data.agencia || "",
                                    conta           : j.data.conta || "",
                                    banco           : j.data.banco || "",
                                    nomepai         : j.data.nomepai || "",
                                    nomemae         : j.data.nomemae || "",
                                    ctps            : j.data.ctps || "",
                                    catcnh          : j.data.catcnh || "",

                                }

                            },
                            methods: {
                                closemodal: function () {
                                    var self_modal = modal;
                                    self_modal.dialog("close");
                                }


                            }
                        });
                        var Form = $("#form-cadastro-unificado");


                        // $("#tab-cadastro-unico").tab();

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
        var url = self.Url("acao_salvar");
        var data = vue_instance.dados;

        $.post(
            self.Url("acao_salvar"),
            {
                data: data
            },
            function (j) {
                if (j.info) {
                    $(".buscar").click();
                    App.close_modal();
                }
                if(!j.info){
                    App.error(j);
                }

            }, 'json')


    },


}