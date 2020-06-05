<!DOCTYPE html>
<html lang="en">

<head>
    <?= $this->load->view('head/css') ?>
</head>
<style>
    .desktop-closed-message-avatar{
        display: none !important;
    }
</style>
<body>
<?php   if(isset($dados)):
    $data = $dados;
else:
    $data = [];
endif;
?>
<div  v-bind:class="display_notification"   style="z-index: 1000;position:fixed;float:bottom;right:1%;bottom:10%" v-cloak>
    <section @click="close_notify()">
        <div class="tn-box tn-box-color-2">
            <p>
                {{name_new_message | firstUpperCase}} enviou uma nova mensagem
                &nbsp; <i class="fas fa-flag-checkered"></i>
            </p>
        </div>
    </section>
</div>
<main class="dashboard-mp">

    <?= $this->load->view("area_a/index",compact("data")); ?>

    <?= $this->load->view("menu/menu",compact("data")); ?>
    <div id="div-geral-dashboard_activity">
        <?= $this->load->view("area_b/index"); ?>
        <?= $this->load->view("area_c_dashboard_activity/index"); ?>

    </div>
</main>
<?= $this->load->view("template/lightbox_image/index"); ?>
<?= $this->load->view("footer/footer"); ?>

<div id="content-chat">
    <?= $this->load->view("chat/index"); ?>
</div>
<div class="content-open-menu-chat">
    <i class="fas fa-comments"></i>
</div>
<?= $this->load->view('chat/menu_chat'); ?>
<!-- Scripts js -->
<?= $this->load->view("head/js"); ?>
<?= $this->load->view("head/chat/assets"); ?>
<?= $this->load->view("head/image_lightbox/assets"); ?>

<script src="<?= URL_RAIZ() ?>js/area_a/area_a.js"></script>
<?php if(isset($dados['externo'])): ?>
    <script src="<?= URL_RAIZ() ?>js/dashboard_activity/dashboard_activity_external.js"></script>
<?php else: ?>
    <script src="<?= URL_RAIZ() ?>js/dashboard_activity/dashboard_activity_local.js"></script>
<?php endif ?>
<?= $this->load->view("head/menu_chat/assets"); ?>



</body>

</html>