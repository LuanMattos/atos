<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, shrink-to-fit=9">
    <meta name="description" content="Gambolthemes">
    <meta name="author" content="Gambolthemes">
    <title>Explorar</title>

    <!-- Favicon Icon -->
    <link rel="icon" type="image/png" href="images/fav.png">

    <link href="<?= URL_RAIZ() ?>application/assets/libs/css/responsive.css" rel="stylesheet">
    <link href="<?= URL_RAIZ() ?>application/assets/libs/css/style.css" rel="stylesheet">
    <link href="<?= URL_RAIZ() ?>application/assets/libs/css/datepicker.min.css" rel="stylesheet">
    <link href="<?= URL_RAIZ() ?>application/assets/libs/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= URL_RAIZ() ?>application/assets/libs/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="<?= URL_RAIZ() ?>application/assets/libs/vendor/OwlCarousel/assets/owl.carousel.css" rel="stylesheet">
    <link href="<?= URL_RAIZ() ?>application/assets/libs/vendor/OwlCarousel/assets/owl.theme.default.min.css" rel="stylesheet">


</head>

<body>
<?php
if (isset($dados)):
$data = $dados;
else:
$data = [];
endif;
?>
<?= $this->load->view("menu/menu", compact("data")); ?>
<main class="dashboard-mp" id="div-geral-pessoas-full">
    <?= $this->load->view("area_a/index",compact("data")); ?>
    <?= $this->load->view("area_b/index"); ?>
    <main class="Search-results">
        <div class="main-section">
            <div class="container">
                <div class="row justify-content-md-center">
                    <div class="col-lg-4 col-md-12">
                        <div class="search-bar-main">
                            <input type="text" class="search-1" placeholder="Buscar pessoas">
                            <i class="fas fa-search srch-ic"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="all-search-events">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-3 col-md-6">
                            <div class="user-data full-width">

                                        <div class="user-profile">
                                            <div class="userbg-dt dpbg-1">
                                                <div class="usr-pic">
                                                    <img src="images/find-peoples/user-1.jpg" alt="">
                                                </div>
                                            </div>
                                            <div class="user-main-details">
                                                <h4>Nome</h4>
                                                <span><i class="fas fa-map-marker-alt"></i>India</span>
                                            </div>
                                            <ul class="follow-msg-dt">
                                                <li>
                                                    <div class="msg-dt-sm">
                                                        <button class="msg-btn1">Adicionar</button>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="follow-dt-sm">
                                                        <button class="follow-btn1">Seguir</button>
                                                    </div>
                                                </li>
                                            </ul>
                                            <div class="profile-link">
                                                <a href="user_dashboard_activity.html">Perfil</a>
                                            </div>
                                        </div>


                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="main-loader search-loader">
                                <div class="spinner">
                                    <div class="bounce1"></div>
                                    <div class="bounce2"></div>
                                    <div class="bounce3"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</main>
<!-- Footer Start -->
<!-- Body End -->
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
<script src="<?= URL_RAIZ() ?>application/assets/js.js"></script>
<script src="<?= URL_RAIZ() ?>js/pessoas/pessoas.js"></script>
<script>pessoas.Init()</script>
</body>

</html>