<!DOCTYPE html>
<html lang="pt-br">

<head>
   <?= $this->load->view('head/css') ?>
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

<?= $this->load->view('head/js') ?>

</body>

</html>