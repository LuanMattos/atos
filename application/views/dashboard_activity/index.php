<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, shrink-to-fit=9">
    <meta name="description" content="Gambolthemes">
    <meta name="author" content="Gambolthemes">
    <title>Goeveni - My Dashbaord Activity</title>

    <!-- Favicon Icon -->
    <link rel="icon" type="image/png" href="images/fav.png">

    <!-- Stylesheets -->
    <link href="<?= URL_RAIZ() ?>application/assets/libs/css/responsive.css" rel="stylesheet">
    <link href="<?= URL_RAIZ() ?>application/assets/libs/css/style.css" rel="stylesheet">
    <link href="<?= URL_RAIZ() ?>application/assets/libs/css/datepicker.min.css" rel="stylesheet">
    <link href="<?= URL_RAIZ() ?>application/assets/libs/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= URL_RAIZ() ?>application/assets/libs/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="<?= URL_RAIZ() ?>application/assets/libs/vendor/OwlCarousel/assets/owl.carousel.css" rel="stylesheet">
    <link href="<?= URL_RAIZ() ?>application/assets/libs/vendor/OwlCarousel/assets/owl.theme.default.min.css" rel="stylesheet">

    <!-----CHAT------>
    <link href="<?= URL_RAIZ() ?>application/assets/libs/css/modules/msg_usuarios/style.css" rel="stylesheet">
    <link href="<?= URL_RAIZ() ?>application/assets/libs/css/jquery.mCustomScrollbar.min.css" rel="stylesheet">



</head>

<body>
<?php   if(isset($dados)):
    $data = $dados;
else:
    $data = [];
endif;
?>
<main class="dashboard-mp">

    <?= $this->load->view("area_a/index",compact("data")); ?>

    <?= $this->load->view("menu/menu",compact("data")); ?>
    <div id="div-geral-dashboard_activity">
        <?= $this->load->view("area_b/index"); ?>
        <?= $this->load->view("area_c_dashboard_activity/index"); ?>
    </div>
</main>
<div id="content-chat" >
    <?= $this->load->view("chat/index"); ?>
</div>

<!-- Body End -->
<!-- Footer Start -->
<?= $this->load->view("footer/footer"); ?>
<!-- Footer End -->
<!-- Scripts js -->
<?= $this->load->view("head/js"); ?>

<?php if(isset($dados['externo'])): ?>
    <script src="<?= URL_RAIZ() ?>js/dashboard_activity/dashboard_activity_external.js"></script>
<?php else: ?>
    <script src="<?= URL_RAIZ() ?>js/dashboard_activity/dashboard_activity_local.js"></script>
<?php endif ?>

<!-----CHAT------>

<script type="module" src="<?= URL_RAIZ()  ?>js/chat/chat.js" ></script>



</body>

</html>