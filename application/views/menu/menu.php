<header id="teste" class="fixed-top">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <nav class="navbar navbar-expand-lg navbar-light bg-dark1 justify-content-sm-start">
                    <a class="order-1 order-lg-0 ml-lg-0 ml-3 mr-auto " href="index.html">
                        <a class="text-white padding-smal" href="<?= site_url('Home/Logged') ?>"></a>
                        <button class="navbar-toggler align-self-start" type="button">
                            <i class="fas fa-bars " style="font-size:25px"></i>
                        </button>

                        <div class="collapse navbar-collapse d-flex flex-column flex-lg-row flex-xl-row justify-content-lg-start bg-dark1 p-3 p-lg-0 mt1-5 mt-lg-0 mobileMenu"
                             id="navbarSupportedContent">
                            <a class="text-white " href="<?= site_url('Home/Logged') ?>">
                                <b style="font-size: 25px">atos</b>
                            </a>
                        </div>
                        <div class="collapse navbar-collapse d-flex flex-column flex-lg-row flex-xl-row justify-content-lg-start bg-dark1 p-3 p-lg-0 mt1-5 mt-lg-0 mobileMenu">
                            <div class="col-lg-12 col-md-12">
                                    <input class="appearance-none  bg-gray-200 text-gray-700 border border-gray-200 rounded-0 py-1 px-4"
                                           type="text"
                                           placeholder="Buscar"
                                           style="width: 100%"
                                    >
<!--                                    <button class="search-btn" type="submit" style="width: 3em">-->
<!--                                        <i class="fas fa-search"></i>-->
<!--                                    </button>-->
                            </div>
                        </div>

                        <ul class="group-icons">
                            <li>
                                <a href="<?= site_url('Home/search') ?>" class="icon-set" title="Explorar">
                                    <i class="fab fa-searchengin" style="font-size: 25px"></i>
                                </a>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="icon-set dropdown-toggle-no-caret" role="button"
                                   data-toggle="dropdown">
                                    <i class="fas fa-user-plus"></i>
                                </a>
                                <div class="dropdown-menu user-request-dropdown dropdown-menu-right">
                                    <div class="user-request-list">
                                        <div class="request-users">
                                            <div class="user-request-dt">
                                                <a href="#">
                                                    <img src="<?= URL_RAIZ() ?>application/assets/libs/images/user-dp-1.jpg"
                                                         alt="">
                                                </a>
                                                <a href="#" class="user-title">Jassica William</a>
                                            </div>
                                            <button class="accept-btn">Aceitar</button>
                                        </div>
                                    </div>
                                    <div class="user-request-list">
                                        <div class="request-users">
                                            <div class="user-request-dt">
                                                <a href="#">
                                                    <img src="<?= URL_RAIZ() ?>application/assets/libs/images/user-dp-1.jpg"
                                                         alt="">
                                                </a>
                                                <a href="#" class="user-title">Rock Smith</a>
                                            </div>
                                            <button class="accept-btn">Aceitar</button>
                                        </div>
                                    </div>
                                    <div class="user-request-list">
                                        <div class="request-users">
                                            <div class="user-request-dt">
                                                <a href="#">
                                                    <img src="<?= URL_RAIZ() ?>application/assets/libs/images/user-dp-1.jpg"
                                                         alt="">
                                                </a>
                                                <a href="#" class="user-title">Joy Doe</a>
                                            </div>
                                            <button class="accept-btn">Aceitar</button>
                                        </div>
                                    </div>
                                    <div class="user-request-list">
                                        <a href="<?= site_url('my_dashboard_all_requests/My_dashboard_all_requests/index') ?>"
                                           class="view-all">Visualizar todos convites</a>
                                    </div>
                                </div>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="icon-set dropdown-toggle-no-caret" role="button"
                                   data-toggle="dropdown">
                                    <i class="fas fa-comment-dots"></i>
                                </a>
                                <div class="dropdown-menu message-dropdown dropdown-menu-right">
                                    <div class="user-request-list">
                                        <div class="request-users">
                                            <div class="user-request-dt">
                                                <a href="#">
                                                    <img src="<?= URL_RAIZ() ?>application/assets/libs/images/user-dp-1.jpg"
                                                         alt="">
                                                    <div class="user-title1">Jassica William</div>
                                                    <span>Hey How are you John Doe...</span>
                                                </a>
                                            </div>
                                            <div class="time5">2 min ago</div>
                                        </div>
                                    </div>
                                    <div class="user-request-list">
                                        <div class="request-users">
                                            <div class="user-request-dt">
                                                <a href="#">
                                                    <img src="<?= URL_RAIZ() ?>application/assets/libs/images/user-dp-1.jpg"
                                                         alt="">
                                                    <div class="user-title1">Rock Smith</div>
                                                    <span>Interesting Event! I will join this...</span>
                                                </a>
                                            </div>
                                            <div class="time5">5 min ago</div>
                                        </div>
                                    </div>
                                    <div class="user-request-list">
                                        <div class="request-users">
                                            <div class="user-request-dt">
                                                <a href="#">
                                                    <img src="<?= URL_RAIZ() ?>application/assets/libs/images/user-dp-1.jpg"
                                                         alt="">
                                                    <div class="user-title1">Joy Doe</div>
                                                    <span>Hey Sir! What about you...</span>
                                                </a>
                                            </div>
                                            <div class="time5">10 min ago</div>
                                        </div>
                                    </div>
                                    <div class="user-request-list">
                                        <a href="<?= site_url('dashboard_msg/Dashboard_msg/index') ?>" class="view-all">Visualizar
                                            todas mensagens</a>
                                    </div>
                                </div>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="icon-set dropdown-toggle-no-caret" role="button"
                                   data-toggle="dropdown">
                                    <i class="fas fa-bell"></i>
                                </a>
                                <div class="dropdown-menu notification-dropdown dropdown-menu-right">
                                    <div class="user-request-list">
                                        <div class="request-users">
                                            <div class="user-request-dt">
                                                <a href="#">
                                                    <img src="<?= URL_RAIZ() ?>application/assets/libs/images/user-dp-1.jpg"
                                                         alt="">
                                                    <div class="user-title1">Jassica William</div>
                                                    <span>comment on your video.</span>
                                                </a>
                                            </div>
                                            <div class="time5">2 min ago</div>
                                        </div>
                                    </div>
                                    <div class="user-request-list">
                                        <div class="request-users">
                                            <div class="user-request-dt">
                                                <a href="#">
                                                    <img src="<?= URL_RAIZ() ?>application/assets/libs/images/user-dp-1.jpg"
                                                         alt="">
                                                    <div class="user-title1">Rock Smith</div>
                                                    <span>your order is accepted.</span>
                                                </a>
                                            </div>
                                            <div class="time5">5 min ago</div>
                                        </div>
                                    </div>
                                    <div class="user-request-list">
                                        <div class="request-users">
                                            <div class="user-request-dt">
                                                <a href="#">
                                                    <img src="<?= URL_RAIZ() ?>application/assets/libs/images/user-dp-1.jpg"
                                                         alt="">
                                                    <div class="user-title1">Joy Doe</div>
                                                    <span>your bill slip sent on your email.</span>
                                                </a>
                                            </div>
                                            <div class="time5">10 min ago</div>
                                        </div>
                                    </div>
                                    <div class="user-request-list">
                                        <a href="<?= site_url('my_dashboard_all_notifications/My_dashboard_all_notifications/index') ?>"
                                           class="view-all">Visualizar todas notificações</a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <div class="account order-1 dropdown">
                            <a href="#" class="account-link dropdown-toggle-no-caret" role="button"
                               data-toggle="dropdown">
                                <div class="user-dp">
                                    <img src="<?= URL_RAIZ() ?>application/assets/libs/images/dp.jpg" alt=""></div>
                                <span><?= isset($data['nome']) ? $data['nome'] : ""; ?> </span>
                                <i class="fas fa-angle-down"></i>
                            </a>
                            <div class="dropdown-menu account-dropdown dropdown-menu-right">
                                <a class="link-item" href="<?= site_url('Home/dashboard_activity') ?>">Perfil</a>
                                <a class="link-item" href="<?= site_url('account_settings/Account_settings/index') ?>">Configurações
                                    da conta</a>
                                <a class="link-item" href="<?= site_url('invite/Invite/index') ?>">Convite</a>
                                <a class="link-item" href="<?= site_url('Home/logout') ?>">Sair</a>
                            </div>
                        </div>
                </nav>
                <div class="overlay"></div>
            </div>
        </div>
    </div>
</header>

<script src="<?= URL_RAIZ() ?>application/assets/js/libs/vue.js"></script>
<script src="<?= URL_RAIZ() ?>js/menu.js"></script>