<form id="form-cadastro-unificado" method="POST">
    <ul class="nav nav-tabs" id="tab-cadastro-unico" role="tablist">
        <li class="nav-item">
            <a class="nav-link active"
               id="home-tab"
               data-toggle="tab" href="#home" role="tab" aria-controls="documentos" aria-selected="true">Usuarios</a>
        </li>
    </ul>
    <div class="tab-content">
        <form class="form-inline">
            <div class="form-group col-md-4 mb-3">
                <label for="inputPassword6">Login</label>
                <input type="text" class="form-control form-control-sm" id="" autocomplete="false" v-model="dados.login">
            </div>
            <div class="form-group col-md-4 mb-3">
                <label for="inputPassword6">Senha</label>
                <input type="password" class="form-control form-control-sm"  minlength="8" maxlength="100" autocomplete="false" v-model="dados.senha">
                <small class="text-muted">
                    De 8 a 100 caractéres.
                </small>
            </div>
            <div class="form-group col-md-4 mb-3">
                <label for="inputPassword6">Rep. Senha</label>
                <input type="password"  class="form-control form-control-sm" minlength="8" maxlength="100" autocomplete="false" v-model="dados.repsenha">
            </div>
        </form>
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
