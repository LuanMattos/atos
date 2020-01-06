<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, shrink-to-fit=9">
    <meta name="description" content="Gambolthemes">
    <meta name="author" content="Gambolthemes">
    <title>Goeveni - My All Notifications</title>

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

</head>

<body>
<?php   ;if(isset($dados)):
    $data = $dados;
else:
    $data = [];
endif;

?>
<?= $this->load->view("menu/menu",compact("data","pais_cidade")); ?>


<!-- Header End -->
<!-- Body Start -->
<main class="dashboard-mp">
    <?= $this->load->view("area_a/index"); ?>
    <?= $this->load->view("area_b/index",compact("data")); ?>
    <?= $this->load->view("area_c_dashboard_all_notifications/index"); ?>
</main>
<!-- Body End -->
<!-- Footer Start -->
<?= $this->load->view("footer/footer"); ?>
<!-- Footer End -->
<!-- Scripts js -->
<script src="<?= URL_RAIZ() ?>application/assets/libs/js/jquery.min.js"></script>
<script src="<?= URL_RAIZ() ?>application/assets/libs/js/skills-search.js"></script>
<script src="<?= URL_RAIZ() ?>application/assets/libs/js/jquery.nice-select.js"></script>
<script src="<?= URL_RAIZ() ?>application/assets/libs/js/datepicker.min.js"></script>
<script src="<?= URL_RAIZ() ?>application/assets/libs/js/i18n/datepicker.en.js"></script>
<script src="<?= URL_RAIZ() ?>application/assets/libs/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?= URL_RAIZ() ?>application/assets/libs/vendor/OwlCarousel/owl.carousel.js"></script>
<script src="<?= URL_RAIZ() ?>application/assets/libs/js/custom1.js"></script>

</body>

</html>