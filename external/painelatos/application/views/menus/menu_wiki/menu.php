<link rel="stylesheet" href="<?= URL_RAIZ() ?>application/assets/js/libs/bootstrap-4.1.3/dist/css/bootstrap.css">
<link rel="stylesheet" href="<?= URL_RAIZ() ?>application/assets/js/libs/jquery-ui-1.12.1/jquery-ui.css">
<link rel="stylesheet" href="<?= URL_RAIZ() ?>application/assets/js/libs/icons/fontawesome-free-5.10.2-web/css/all.css">
<link rel="stylesheet" href="<?= URL_RAIZ() ?>application/assets/js/libs/pagination/dist/pagination.css">

<body>
<style>
    .bg-default{
        background-color: #005599;
    }
    a{
        text-decoration: none;
    }
</style>

<body>
<div id="full">
    <nav class="bg-default navbar navbar-expand-lg">
        <a class="text-white" href="<?= site_url('Logado/index') ?>">Home</a>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">
                     <span class="sr-only"></span></a>
                </li>
                <li class="nav-item dropdown ">
                    <a class="nav-link dropdown-toggle text-white"
                       href="#"
                       id="navbarDropdown"
                       role="button"
                       data-toggle="dropdown"
                       aria-haspopup="true"
                       aria-expanded="false"
                    >
                        Cadastro
                    </a>
                    <div class="dropdown-menu"  aria-labelledby="navbarDropdown" >
                        <a class="dropdown-item" href="#" onclick="wiki.Init()" >Wiki</a>
                    </div>

                </li>

            </ul>
            <ul>
                <li class="list-group text-white">
                    <a href="<?= site_url('Logado/logout') ?>" class="text-white">
                        <i class=" fas fa-sign-out-alt"></i>Sair
                    </a>
                </li>
            </ul>

        </div>
    </nav>
</div>

<div class="text-center mb-5 mt-5">
    <div class="form-label-group">
        <img class="rounded mx-auto d-block" width="550" src="<?= URL_RAIZ() ?>application/assets/js/libs/imagens/look.png">
    </div>

</div>

</body>

<!------------------------------------------------fontawesome------------------------------------------------------------------>
<script type="text/javascript" src="<?= URL_RAIZ() ?>application/assets/js/libs/icons/fontawesome-free-5.10.2-web/js/all.js"></script>
<!----------------------------------------------bootstrap-------------------------------------------------------------->
<script type="text/javascript" src="<?= URL_RAIZ() ?>application/assets/js/libs/bootstrap-4.1.3/js/jquery-3.3.1.slim.min.js"></script>
<script type="text/javascript" src="<?= URL_RAIZ() ?>application/assets/js/libs/bootstrap-4.1.3/dist/js/bootstrap.js"></script>
<!-----------------------------------------jquery-default-sistema------------------------------------------------------>
<script type="text/javascript" src="<?= URL_RAIZ() ?>application/assets/js/libs/jquery-3.4.1/jquery.js"></script>
<!------------------------------------------jquery-ui-p/-modal--------------------------------------------------------->
<script type="text/javascript" src="<?= URL_RAIZ() ?>application/assets/js/libs/jquery-1.12.4/jquery-1.12.4.js"></script>
<!----------------------------------------------jquery-ui-------------------------------------------------------------->
<script type="text/javascript" src="<?= URL_RAIZ() ?>application/assets/js/libs/jquery-ui-1.12.1/jquery-ui.js"></script>
<!---------------------------------------------geral-do-unico---------------------------------------------------------->
<script type="text/javascript" src="<?= URL_RAIZ() ?>js/unico/unico.js"></script>
<!---------------------------------------------cadastro-imagem--------------------------------------------------------->
<script type="text/javascript" src="<?= URL_RAIZ() ?>js/unico/cadastro_imagem.js"></script>
<!---------------------------------------------cadastro-unico---------------------------------------------------------->
<script type="text/javascript" src="<?= URL_RAIZ() ?>js/wiki/wiki.js"></script>
<!---------------------------------------------assets-do-sistema---------------------------------------------------------->
<script type="text/javascript" src="<?= URL_RAIZ() ?>application/assets/js.js"></script>
<!----------------------------------------------------Vue-Js----------------------------------------------------------------->
<!--<script type="text/javascript" src="--><?//= URL_RAIZ() ?><!--application/assets/js/libs/vue.min.js"></script>-->
<script type="text/javascript" src="<?= URL_RAIZ() ?>application/assets/js/libs/vue.js"></script>
<!----------------------------------------pagination--------------------------------------------------------------------->
<script type="text/javascript" src="<?= URL_RAIZ() ?>application/assets/js/libs/pagination/dist/pagination.js"></script>
