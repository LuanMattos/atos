<!DOCTYPE html>
<html lang="pt-br">

<head>
   <?php $this->load->view('head/css') ?>
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
<!--                                    <img src="--><?//= URL_RAIZ() ?><!--application/assets/libs/images/home.svg" style="width:100%">-->
                                    <img src="<?= URL_RAIZ() ?>application/assets/images/home.png" style="width:70%;padding: 5%;margin-left: 10%">
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
                                        <form action="<?= site_url('Login/start_login') ?>" method="POST">
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
<!--                                            <div class="container text-black">-->
<!--                                                Continuar conectado <input type="checkbox" name="conectado">-->
<!--                                            </div>-->
                                        </form>
                                        <a href="#" class="forgot-link">Esqueceu a senha?</a>
                                        <div class="regstr-link">Não é registrado?
                                            <a href="<?= site_url('sign/up') ?>">Registre-se Agora</a></div>
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

<script src="<?= URL_RAIZ() ?>application/assets/libs/js/jquery.min.js"></script>
<script type="text/javascript" src="<?= site_url("application/assets/js/libs/jquery-ui-1.12.1/jquery-ui.js") ?> "></script>
<script src="<?= URL_RAIZ() ?>application/assets/libs/js/jquery.nice-select.js"></script>
<script src="<?= URL_RAIZ() ?>application/assets/js/libs/jquery.mask.js"></script>
<script src="<?= URL_RAIZ() ?>application/assets/libs/js/skills-search.js"></script>
<script src="<?= URL_RAIZ() ?>application/assets/libs/js/datepicker.min.js"></script>
<script src="<?= URL_RAIZ() ?>application/assets/libs/js/i18n/datepicker.en.js"></script>
<script src="<?= URL_RAIZ() ?>application/assets/libs/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?= URL_RAIZ() ?>application/assets/libs/vendor/OwlCarousel/owl.carousel.js"></script>
<script src="<?= URL_RAIZ() ?>application/assets/libs/js/custom1.js"></script>
<script src="<?= URL_RAIZ() ?>application/assets/js/libs/axios.js"></script>
<script src="<?= URL_RAIZ() ?>application/assets/js/libs/underscore.js"></script>
<script src="<?= URL_RAIZ() ?>application/assets/js/libs/vue.js"></script>
<script src="<?= URL_RAIZ() ?>application/assets/js.js"></script>

<script src="<?= URL_RAIZ() ?>application/assets/mascaras.js"></script>
<script src="<?= URL_RAIZ() ?>application/assets/libs/js/i18n/datepicker.pt-BR.js"></script>


</body>

</html>