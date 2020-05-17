<head>
    <script type="text/javascript"
            src="<?= URL_RAIZ() ?>application/assets/js/libs/bootstrap-4.1.3/js/jquery-3.3.1.slim.min.js"></script>
    <script type="text/javascript"
            src="<?= URL_RAIZ() ?>application/assets/js/libs/bootstrap-4.1.3/dist/js/bootstrap.js"></script>
    <link rel="stylesheet" href="<?= URL_RAIZ() ?>application/assets/js/libs/bootstrap-4.1.3/dist/css/bootstrap.css">
    <link rel="stylesheet" href="<?= URL_RAIZ() ?>application/assets/js/libs/icons/fontawesome-free-5.10.2-web/css/all.css">

</head>
<style>
    .background-index {
        background-image: url(<?= URL_RAIZ() ?>application/assets/js/libs/imagens/teste.png);
        background-size: 100%;
        background-position:50% ;
        background-repeat: no-repeat;

    }


</style>
<body class="background-index" >

<div class="col-4 mx-auto d-flex h-100 flex-column p-3  "  style="margin-top:15%;color:white;">
    <form method="POST" class="form-signin" id="formulario-login" action="<?= site_url('Logado/index') ?>">
        <div class="text-center mb-4">
            <div class="form-label-group">
                <div width="350"></div>
                <h1 class="h3 mb-3">Área de acesso</h1>
            </div>

        </div>
        <div class="form-group row">
            <label for="inputEmail3" class="col-sm-2 col-form-label">Usuário</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="inputEmail3" placeholder="Login" name="login">
            </div>
        </div>
        <div class="form-group row">
            <label for="inputPassword3" class="col-sm-2 col-form-label">Senha</label>
            <div class="col-sm-10">
                <input type="password" class="form-control" id="inputPassword3" placeholder="Senha" name="senha">

                <div class=" row m-4">
                    <button type="submit" class=" btn btn-block btn-primary"> Entrar &nbsp &nbsp<i class="fas fa-key"></i> </button>
                </div>
            </div>
        </div>

    </form>
    <p class="text-danger">
        <?php if (isset($error_senha)) {
            echo $error_senha;
        } else {
            echo " ";
        } ?>
    </p>
</div>
</div>
</body>
<script type="text/javascript" src="<?= URL_RAIZ() ?>application/assets/js/libs/icons/fontawesome-free-5.10.2-web/js/all.js"></script>

