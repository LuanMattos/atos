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
<?= $this->load->view("area_a/index"); ?>
<?= $this->load->view("menu/menu", compact("data")); ?>
<?= $this->load->view("area_b/index",compact("data")); ?>
<main class="dashboard-mp" id="div-geral-pessoas-full">
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
            </div >
            <div class="all-search-events" >
                <div class="container" >
                    <div class="row" v-if="data_users.length > 0">
                        <div class="col-lg-3 col-md-6"  v-for="(i,l) in data_users" v-if="i">
                             <div class="user-data full-width">

                                                <div class="user-profile ">
                                                    <div class="username-dt dpbg-1 ">
                                                        <div class="my-dp-dash crop-img-card-full-pessoas cursor-pointer " v-bind:style="i[0].img_cover.length?'background-image:url(' + i[0].img_cover + ');':''">
                                                            <img class="crop-img-home-mini" :src="i[0].img_profile.length?i[0].img_profile:default_img_profile" alt="">
                                                        </div>
                                                    </div>
                                                    <div class="user-main-details">
                                                        <div class="row ml-3">
                                                            <div class="col-10 text-truncate" v-cloak >
                                                                    {{i[0].nome}}
                                                            </div>
                                                        </div>
                                                        <span v-cloak="">
                                                            <i class="fas fa-map-marker-alt"></i>
                                                             <div class="row ml-3">
                                                                <div class="col-10 text-truncate" v-cloak >
                                                                        {{i[0].endereco}}
                                                                </div>
                                                            </div>
                                                            <div class="row ml-3">
                                                                <div class="col-10 text-truncate" v-cloak >
                                                                        {{i[0].sobrenome}}

                                                                </div>
                                                            </div>
                                                        </span>
                                                    </div>
                                                    <ul class="follow-msg-dt">
                                                        <li>
                                                            <div class="msg-dt-sm card-button-pessoa" >
                                                                <div class="amizade-buttom" style="display: none">
                                                                      <button  class=" msg-btn2  " data-toggle="dropdown">Amigos </button>
                                                                      <div class="dropdown-menu">
                                                                            <span class="dropdown-item cursor-pointer" @click="delete_amizade(i[0]._id,l)">Excluir amizade</span>
                                                                       </div>
                                                                </div>
                                                                    <template v-if="i[0].amigo_solicitante">
                                                                        <button  class="msg-btn3 btn-confirmar-amizade" @click="aceitar_pessoa(i[0]._id,l)" data-id-btn="$index">Confirmar </button>
                                                                    </template>
                                                                    <template v-else>
                                                                        <button  class="btn-cancelar-amizade" v-bind:class="i[0].sol?'msg-btn2 ' + ' button-add-person':'msg-btn1 ' + ' button-add-person'" @click="add_person(i[0]._id,l)" data-id-btn="$index">{{i[0].sol?'Cancelar ':'Adicionar'}}</button>
                                                                    </template>
                                                                        <button  class="btn-adicionar-amizade" style="display: none" @click="add_person(i[0]._id,l)" data-id-btn="$index">Adicionar</button>

                                                            </div>
                                                        </li>
                                                        <li>
                                                            <template v-if="i[0].amigo_solicitante">
                                                                <div class="follow-dt-sm">
                                                                    <button class="follow-btn1">Recusar</button>
                                                                </div>
                                                            </template>
                                                            <template v-else>
                                                                <div class="follow-dt-sm">
                                                                    <button class="follow-btn1">Seguir</button>
                                                                </div>
                                                            </template>
                                                        </li>
                                                    </ul>
                                                    <div class="profile-link">
                                                        <a href="user_dashboard_activity.html">Perfil</a>
                                                    </div>
                                                </div>
                                    </div>
                        </div>
                        <div class="col-md-12" v-if="loading">
                            <mugen-scroll :handler="getPosts" :should-handle="loading">
                                <div class="spinner">
                                    <div class="bounce1"></div>
                                    <div class="bounce2"></div>
                                    <div class="bounce3"></div>
                                </div>
                            </mugen-scroll>
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
<script src="<?= URL_RAIZ() ?>application/assets/js/libs/vue.js"></script>
<script src="<?= URL_RAIZ() ?>application/assets/js/libs/vue-mugen-scroll/vue-mugen-scroll.min.js"></script>
<script src="<?= URL_RAIZ() ?>application/assets/js.js"></script>
<script src="<?= URL_RAIZ() ?>js/area_a/area_a.js"></script>
<script src="<?= URL_RAIZ() ?>js/pessoas/pessoas.js"></script>
<script src="<?= URL_RAIZ() ?>js/menu.js"></script>

</body>

</html>