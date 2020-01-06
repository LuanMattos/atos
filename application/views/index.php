<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, shrink-to-fit=9">
    <meta name="description" content="Gambolthemes">
    <meta name="author" content="Gambolthemes">
    <title> &nbsp</title>

    <!-- Favicon Icon -->
    <link rel="icon" type="image/png" href="<?= URL_RAIZ() ?>application/assets/libs/images/home-title.svg">

    <!-- Stylesheets -->
    <link href="<?= URL_RAIZ() ?>application/assets/libs/css/responsive.css" rel="stylesheet">
    <link href="<?= URL_RAIZ() ?>application/assets/libs/css/style.css" rel="stylesheet">
    <link href="<?= URL_RAIZ() ?>application/assets/libs/css/datepicker.min.css" rel="stylesheet">
    <link href="<?= URL_RAIZ() ?>application/assets/libs/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= URL_RAIZ() ?>application/assets/libs/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="<?= URL_RAIZ() ?>application/assets/libs/vendor/OwlCarousel/assets/owl.carousel.css" rel="stylesheet">
    <link href="<?= URL_RAIZ() ?>application/assets/libs/vendor/OwlCarousel/assets/owl.theme.default.min.css" rel="stylesheet">

</head>

<body class="body-bg">
<main class="register-mp">
    <div class="main-section">
        <div class="container">
            <div class="row justify-content-md-center">
                <div class="col-md-12">
                    <div class="login-register-bg">
                        <div class="row no-gutters">
                            <div class="col-lg-6" style="background-color: #3a3e3e; ">
                                <div class="text-white">
                                    <img src="<?= URL_RAIZ() ?>application/assets/libs/images/home.svg" style="width:120%">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="lr-right">
<!--                                    <div class="social-logins">-->
<!--                                        <button class="social-f-btn"><i class="fab fa-facebook-f"></i>Continue com facebook</button>-->
<!--                                        <button class="social-g-btn"><i class="fab fa-google"></i>Continue com Google</button>-->
<!--                                    </div>-->
<!--                                    <div class="or">Ou</div>-->
                                    <div class="login-register-form">
                                        <form action="<?= site_url('Home/index') ?>" method="POST">
                                            <div class="form-group">
                                                <input class="title-discussion-input"
                                                       type="email"
                                                       placeholder="Email ou Telefone"
                                                       name="login"
                                                       autocomplete="off"
                                                >
                                            </div>
                                            <div class="form-group">
                                                <input class="title-discussion-input"
                                                       type="password"
                                                       placeholder="Senha"
                                                       name="senha"
                                                       autocomplete="off"
                                                >
                                            </div>
                                            <button class="login-btn" type="submit">Logar</button>
                                            <div class="container text-black">
                                                Continuar conectado <input type="checkbox" name="conectado">
                                            </div>
                                        </form>
                                        <a href="#" class="forgot-link">Esqueceu a senha?</a>
                                        <div class="regstr-link">Não é registrado?
                                            <a href="<?= site_url('Home/register') ?>">Registre-se Agora</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
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