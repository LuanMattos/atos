<head>
    <script type="text/javascript"
            src="<?= site_url("application/assets/js/libs/bootstrap-4.1.3/js/jquery-3.3.1.slim.min.js") ?>"></script>
    <script type="text/javascript"
            src="<?= site_url("application/assets/js/libs/bootstrap-4.1.3/dist/js/bootstrap.js") ?>"></script>
    <link rel="stylesheet" href="<?= site_url("application/assets/js/libs/bootstrap-4.1.3/dist/css/bootstrap.css") ?>">
    <link rel="stylesheet"
          href="<?= site_url("application/assets/js/libs/icons/fontawesome-free-5.10.2-web/css/all.css") ?>">
    <link href="<?= site_url("application/assets/css/tailwindcss.css") ?>" rel="stylesheet">

</head>
<style>
    .bg {
        background-color: #3e3e3f;
    }

</style>

<body class="bg">
<div id="general-verification-container">
    <div class="col">
        <div class="img-home">
            <img src="<?= URL_RAIZ() . 'application/assets/images/svg/home.svg' ?>" style="width: 450px">
        </div>
    </div>
    <div class="font-thin text-base text-gray-800 text-left text-white w-75 ">
        <p class="text-left ml-10 text-lg mb-4">Para prosseguir, precisamos validar sua conta, preencha com o código de
            verificação que você recebeu em seu e-mail e/ou telefone</p>
    </div>
    <div class="row d-flex  justify-content-center">
        <div class="col-md-6">
            <div class="w-75">
                <input type="text"
                       class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded-0 py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                       placeholder="Código de verificação"
                       v-model="form.codevalidation"
                >
            </div>
        </div>
    </div>
    <div class="row d-flex  justify-content-center">
        <div class="col-md-6">
            <div class="w-75">
                <button class="shadow bg-gray-300 hover:bg-gray-100 focus:shadow-outline focus:outline-none text-gray-700 font-bold py-2 w-100 rounded-0"
                        type="button"
                        id="comecar"
                >
                    Enviar
                </button>
                <br>
                <span class=' font-mono text-red-600 text-xs'>{{form.error.codigov}}</span>
            </div>
        </div>
    </div>
</div>
</body>
<script type="text/javascript" src="<?= site_url("js/verification/verification.js") ?>"></script>
<!-----------------------------------------jquery-default-sistema------------------------------------------------------>
<script type="text/javascript" src="<?= site_url("application/assets/js/libs/jquery-3.4.1/jquery.js") ?>"></script>
<!------------------------------------------jquery-ui-p/-modal--------------------------------------------------------->
<script type="text/javascript" src="<?= site_url("application/assets/js/libs/jquery-1.12.4/jquery-1.12.4.js") ?>"></script>
<!----------------------------------------------jquery-ui-------------------------------------------------------------->
<script type="text/javascript"
        src="<?= site_url("application/assets/js/libs/jquery-ui-1.12.1/jquery-ui.js") ?> "></script>
<script type="text/javascript" src="<?= site_url("application/assets/js/libs/vue.js") ?>"></script>
<script type="text/javascript" src="<?= site_url("application/assets/js.js") ?>"></script>
<script type="text/javascript" src="<?= site_url("application/assets/mascaras.js") ?> "></script>
<script type="text/javascript" src="<?= site_url("application/assets/js/libs/jquery.mask.js") ?> "></script>
<script type="text/javascript"
        src="<?= site_url("application/assets/js/libs/icons/fontawesome-free-5.10.2-web/js/all.js") ?> "></script>
