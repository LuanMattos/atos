<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, shrink-to-fit=9">
    <meta name="description" content="Gambolthemes">
    <meta name="author" content="Gambolthemes">
    <title>Configurações da conta</title>

    <!-- Favicon Icon -->
    <link rel="icon" type="image/png" href="images/fav.png">

    <!-- Stylesheets -->
    <link href="<?= URL_RAIZ() ?>application/assets/libs/css/responsive.css" rel="stylesheet">
    <link href="<?= URL_RAIZ() ?>application/assets/libs/css/style.css" rel="stylesheet">
    <link href="<?= URL_RAIZ() ?>application/assets/libs/css/datepicker.min.css" rel="stylesheet">
    <link href="<?= URL_RAIZ() ?>application/assets/libs/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= URL_RAIZ() ?>application/assets/libs/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="<?= URL_RAIZ() ?>application/assets/libs/vendor/OwlCarousel/assets/owl.carousel.css" rel="stylesheet">
    <link href="<?= URL_RAIZ() ?>application/assets/libs/vendor/OwlCarousel/assets/owl.theme.default.min.css"
          rel="stylesheet">



</head>

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC6bqIsYACsiTkx2B2-8dDaKcuvq3ArXC4&libraries=places"></script>



<body>
<?php if (isset($dados)):
    $data = $dados;
else:
    $data = [];
endif;

?>
<?= $this->load->view("menu/menu", compact("data")) ?>
<!-- Header End -->
<!-- Body Start -->
<main class="dashboard-mp" style="margin-top: 80px;" id="main-config-account-settings">
    <div class="dash-tab-links">
        <div class="container">
            <div class="setting-page mb-20">
                <div class="row">
                    <?= $this->load->view("menu_config/index"); ?>
                    <!--                    #div-geral-config-informacoes-pessoais-index-->
                    <?= $this->load->view("config_informacoes_pessoais/index",compact("data","location")); ?>
                    <!--                    #div-geral-config-perfil-index-->
                    <?= $this->load->view("config_perfil/index",compact("data")); ?>
                    <!--                    #div-geral-config-requisicoes-amizades-->
                    <?= $this->load->view("config_requisicoes_amizades/index",compact("data")); ?>
                    <!--                    #div-geral-config-redes-sociais-->
                    <?= $this->load->view("config_redes_sociais/index",compact("data")); ?>
                    <!--                    #div-geral-config-email-->
                    <?= $this->load->view("config_email/index",compact("data")); ?>
                    <!--                    #div-geral-config-notificacoes-->
                    <?= $this->load->view("config_notificacoes/index",compact("data")); ?>
                    <!--                    #div-geral-config-mudar-senha-->
                    <?= $this->load->view("config_mudar_senha/index",compact("data")); ?>
                    <!--                    #div-geral-desativar-conta-->
                    <?= $this->load->view("config_desativar_conta/index",compact("data")); ?>
                </div>
            </div>
        </div>
    </div>

</main>

<?= $this->load->view("footer/footer"); ?>


<script src="<?= URL_RAIZ() ?>application/assets/libs/js/jquery.min.js"></script>
<script src="<?= URL_RAIZ() ?>application/assets/libs/js/skills-search.js"></script>
<script src="<?= URL_RAIZ() ?>application/assets/libs/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?= URL_RAIZ() ?>application/assets/libs/vendor/OwlCarousel/owl.carousel.js"></script>
<script src="<?= URL_RAIZ() ?>application/assets/libs/js/custom1.js"></script>
<script src="<?= URL_RAIZ() ?>application/assets/js.js"></script>
<script src="<?= URL_RAIZ() ?>js/config/config.js"></script>
<script src="<?= URL_RAIZ() ?>js/maps/maps_google_account_settings.js"></script>
<script src="<?= URL_RAIZ() ?>application/assets/js/libs/jquery.mask.js"></script>
<script src="<?= URL_RAIZ() ?>application/assets/mascaras.js"></script>
<script src="<?= URL_RAIZ() ?>application/assets/libs/js/datepicker.min.js"></script>
<script src="<?= URL_RAIZ() ?>application/assets/libs/js/i18n/datepicker.en.js"></script>
</body>

</html>