<form id="form-cadastro-unificado" method="POST">
    <ul class="nav nav-tabs" id="tab-cadastro-unico" role="tablist">
        <li class="nav-item">
            <a class="nav-link active"
               id="home-tab"
               data-toggle="tab" href="#home" role="tab" aria-controls="documentos" aria-selected="true">Documentos</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="contato"
               aria-selected="true">Contato</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="enderecos"
               aria-selected="false">Endereços</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="dados_bancarios-tab" data-toggle="tab" href="#dados_bancarios" role="tab" aria-controls="dados_bancarios"
               aria-selected="false">Dados bancários</a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane fade show active" id="home">
            <div class="tab-content">
                <form class="form-inline">
                    <div class="form-group col-md-8 mb-3 mt-3">
                        <div class="row">
                            <div class="col">
                                <input type="text" class="form-control form-control-sm"  autocomplete="off" v-model="dados.nome" placeholder="Nome">
                            </div>
                            <div class="col">
                                <input type="text" class="form-control form-control-sm"   autocomplete="false" v-model="dados.cpf"  placeholder="CPF">
                            </div>
                        </div>
                    </div>

                    <div class="form-group col-md-8 mb-3">
                        <div class="row">
                            <div class="col">
                                    <div class="row">
                                        <div class="col">
                                            <input type="text" class="form-control form-control-sm"    v-model="dados.cnh"  placeholder="CNH" autocomplete="false">
                                        </div>
                                        <div class="col">
                                            <select class="form-control form-control-sm" v-model="dados.catcnh">
                                                <option value="">Nenhuma</option>
                                                <option value="a">A</option>
                                                <option value="b">B</option>
                                                <option value="c">C</option>
                                                <option value="d">D</option>
                                                <option value="e">E</option>
                                            </select>
                                        </div>
                                    </div>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control form-control-sm"   autocomplete="false" v-model="dados.rg"  placeholder="RG">
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-8 mb-3">
                        <div class="row">
                            <div class="col">
                                <input type="text" class="form-control form-control-sm"   autocomplete="false" v-model="dados.pis"  placeholder="PIS">
                            </div>
                            <div class="col">
                                <input type="text" class="form-control form-control-sm"   autocomplete="false" v-model="dados.pasep"  placeholder="PASEP">
                            </div>
                            <div class="col">
                                 <input type="text" class="form-control form-control-sm"   autocomplete="false" v-model="dados.nis"  placeholder="NIS">
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-8 mb-3">
                        <div class="row">
                            <div class="col">
                                <input type="text" class="form-control form-control-sm"   autocomplete="false" v-model="dados.ctps"  placeholder="CTPS">
                            </div>
                            <div class="col">
                                <input type="text" class="form-control form-control-sm"   autocomplete="false" v-model="dados.certidao_nasc"  placeholder="Certidão Nasc.">
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-8 mb-3">
                        <div class="row">
                            <div class="col">
                                <input type="text" class="form-control form-control-sm"   autocomplete="false" v-model="dados.nomepai"  placeholder="Nome Pai">
                            </div>
                            <div class="col">
                                <input type="text" class="form-control form-control-sm"   autocomplete="false" v-model="dados.nomemae"  placeholder="Nome Mãe">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                <div class="form-group col-md-4 mt-3">
                    <input type="email" class="form-control form-control-sm"   autocomplete="false" v-model="dados.email"  placeholder="E-mail">
                </div>
                <div class="form-group col-md-8 mb-3">
                    <div class="row">
                        <div class="col">
                            <input type="text" class="form-control form-control-sm"   autocomplete="false" v-model="dados.celular"  placeholder="Celular">
                        </div>
                        <div class="col">
                            <input type="text" class="form-control form-control-sm"   autocomplete="false" v-model="dados.teleresidencial"  placeholder="Tel.Residencial">
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-4 mb-3">
                        <input type="text" class="form-control form-control-sm"   autocomplete="false" v-model="dados.fax"  placeholder="FAX">
                </div>
        </div>
        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
            <div class="form-group col-md-8 mt-3">
                <div class="row">
                    <div class="col-sm-4">
                        <input type="text" class="form-control form-control-sm"   autocomplete="false" v-model="dados.cep"  placeholder="CEP">
                    </div>
                    <div class="col">
                        <input type="text" class="form-control form-control-sm"   autocomplete="false" v-model="dados.endereco"  placeholder="Endereço">
                    </div>
                 </div>
            </div>
            <div class="form-group col-md-8 mt-3">
                <div class="row">
                    <div class="col">
                        <input type="text" class="form-control form-control-sm"   autocomplete="false" v-model="dados.bairro"  placeholder="Bairro">
                    </div>
                    <div class="col-sm-5">
                        <input type="text" class="form-control form-control-sm"   autocomplete="false" v-model="dados.numero"  placeholder="Número">
                    </div>
                    <div class="col">
                        <input type="text" class="form-control form-control-sm"   autocomplete="false" v-model="dados.cidade"  placeholder="Cidade">
                    </div>
                </div>
            </div>

            <div class="form-group col-md-8 mt-3">
                <div class="row">
                    <div class="col">
                        <input type="text" class="form-control form-control-sm"   autocomplete="false" v-model="dados.pais"  placeholder="País">
                    </div>
                    <div class="col-sm-5">
                        <input type="text" class="form-control form-control-sm"   autocomplete="false" v-model="dados.estado"  placeholder="Estado" maxlength="2">
                    </div>
                </div>


            </div>
        </div>
        <div class="tab-pane fade" id="dados_bancarios" role="tabpanel" aria-labelledby="dados_bancarios-tab">
            <div class="form-group col-md-4 mt-3">
                <input type="text" class="form-control form-control-sm"   autocomplete="false" v-model="dados.agencia"  placeholder="Agência">
            </div>
            <div class="form-group col-md-4 mt-3">
                <input type="text" class="form-control form-control-sm"   autocomplete="false" v-model="dados.conta"  placeholder="Conta">
            </div>
            <div class="form-group col-md-4 mt-3">
                <input type="text" class="form-control form-control-sm"   autocomplete="false" v-model="dados.banco"  placeholder="Banco">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <h3 class="one"></h3>
        </div>
        <div class="col-auto btn-group">
            <button @click.prevent="closemodal()" class="btn btn-danger pull-right cancelar ">Cancelar</button>
            <button class="btn btn-primary pull-right btn-salvar">Salvar</button>
        </div>
    </div>
</form>
