<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php $this->load->view('head/css') ?>
</head>

<body>
<?php  if(isset($dados)):
    $data = $dados;
else:
    $data = [];
endif;
?>
<?php $this->load->view("menu/menu",compact("data")) ?>
<main class="dashboard-mp">

    <?php $this->load->view("area_b/index"); ?>
    <?php $this->load->view("area_c_dashboard_msg/index"); ?>
</main>
<!-- Body End -->
<!-- Footer Start -->
<?php $this->load->view("footer/footer"); ?>
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
<script src="<?= URL_RAIZ() ?>application/assets/js/libs/vue.js"></script>
<script src="<?= URL_RAIZ() ?>application/assets/js/libs/vue-mugen-scroll/vue-mugen-scroll.min.js"></script>

<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-mousewheel/3.1.13/jquery.mousewheel.min.js"></script>
<script src="<?= URL_RAIZ() ?>application/assets/libs/js/jquery.mCustomScrollbar.js"></script>
<script src="<?= URL_RAIZ() ?>application/assets/libs/js/Scrollbar.js"></script>
<script src="<?= URL_RAIZ() ?>application/assets/libs/js/custom1.js"></script>
<script src="<?= URL_RAIZ() ?>application/assets/js.js"></script>
<script src="<?= URL_RAIZ() ?>js/area_a/area_a.js"></script>
<script src="<?= URL_RAIZ() ?>js/menu.js"></script>
<script src="<?= URL_RAIZ() ?>js/menu.js"></script>


<?php if(isset($dados['externo'])): ?>
    <script src="<?= URL_RAIZ() ?>js/dashboard_activity/dashboard_activity_external.js"></script>
<?php else: ?>
    <script src="<?= URL_RAIZ() ?>js/dashboard_activity/dashboard_activity_local.js"></script>
<?php endif ?>


</body>

</html>