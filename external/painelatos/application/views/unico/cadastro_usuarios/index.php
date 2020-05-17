<form id="form-cadastro-usuarios-container" action="<?= site_url("unico/cadastro_unico/Cadastro_usuarios/index") ?>"
      method="POST">
    <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text">Buscar:</span>
        </div>
        <input type="text" class="form-control" id="buscar" v-model="search">
        <div class="input-group-append">
            <input type="submit"
                   class="btn btn-info buscar"
                   value="Buscar"
                   @click.prevent="busca()"
            >
            <button type="button" class="btn btn-info novo "><i class="far fa-file"></i> Novo</button>
        </div>
    </div>
</form>
<table id=" tabela-geral-cadastro-unificado"
       class="rounded-top table table-striped table-hover table-bordered table-sm table-secondary small ">
    <thead>
    <tr>
        <th class="col-sm-0 text-center">Código:</th>
        <th class="col-sm-3 text-center">Login:</th>
        <th class="col-sm-3 text-center">Criado em:</th>
        <th class="col-sm-3 text-center">Atualizado em :</th>
        <th colspan="3" class="text-center">
            <i class="fas fa-cog"></i>
        </th>
    </tr>
    </thead>
    <tbody>
    <tr class="table-light" v-for="(i,index) in data">
        <td class="text-right">{{i.codigo}}</td>
        <td>{{i.login}}</td>
        <td>{{i.created_at}}</td>
        <td>{{i.updated_at}}</td>
        <td class="text-center" @click="excluir(index,i.codigo)">
            <i class="fas fa-times cursor-pointer"></i>
        </td>
        <td class="text-center" @click="editar(i.codigo)">
            <i class="fas fa-external-link-alt cursor-pointer"></i>
        </td>
        <td class="text-center" @click="imprimir()">
            <i class="fas fa-print cursor-pointer"></i>
        </td>
    </tr>
    </tbody>

</table>
<div id="demo"></div>
