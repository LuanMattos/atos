<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?= $this->load->view('head/css') ?>
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
    <?= $this->load->view("area_b/index",compact("data")); ?>
    <?= $this->load->view("area_c_dashboard_all_notifications/index"); ?>
</main>
<?= $this->load->view("footer/footer"); ?>
<?= $this->load->view("head/js"); ?>
<script src="<?= URL_RAIZ() ?>js/area_a/area_a.js"></script>

</body>

</html>