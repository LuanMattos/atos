<head>
    <script type="text/javascript" src="<?= site_url("application/assets/js/libs/bootstrap-4.1.3/js/jquery-3.3.1.slim.min.js") ?>"></script>
    <script type="text/javascript" src="<?= site_url("application/assets/js/libs/bootstrap-4.1.3/dist/js/bootstrap.js")?>"></script>
    <link rel="stylesheet" href="<?= site_url("application/assets/js/libs/bootstrap-4.1.3/dist/css/bootstrap.css") ?>">
    <link rel="stylesheet" href="<?= site_url("application/assets/js/libs/icons/fontawesome-free-5.10.2-web/css/all.css") ?>">
    <link href="<?= site_url("application/assets/css/tailwindcss.css") ?>" rel="stylesheet">

</head>
<style>
    .bg {
        background-color: #3e3e3f;
        /*background-image: url(*/<?//= site_url('application/assets/images/svg/graph-paper/texture.svg')  ?>/*);*/
    }

</style>

<body class="bg">
<div id="geral-div-container">
    <div class="row xl:mt-24">
        <div class="col" id="formulario-login">
            <div class="w-full max-w-xs ml-10">
                <form method="POST" class=" w-full max-w-sm"
                      id="form-geral-logado-index"
                      action="<?= site_url('Home/index') ?>">
                    <div class="container p-4">
                        <p class="font-mono text-base text-gray-800 text-left text-white">
                            Entrar
                        </p>

                    </div>
                    <div class="md:flex md:items-center mb-2">
                        <div class="md:w-1/3">
                            <label class="block text-white font-bold md:text-right mb-1 md:mb-0 pr-4"
                                   for="inline-full-name">
                            </label>
                        </div>
                        <div class="md:w-2/1">
                            <input class=" bg-gray-200
                                    appearance-none
                                     border-2
                                      border-gray-200
                                        w-full
                                         py-2
                                          px-4
                                           text-gray-700
                                            leading-tight
                                             focus:outline-none
                                              focus:bg-white
                                               focus:border-gray-400
                                               xl:rounded-0
"
                                   id="inline-full-name"
                                   type="text"
                                   name="login"
                                   placeholder="Login"
                                   autocomplete="off"
                            >
                        </div>
                    </div>
                    <div class="md:flex md:items-center mb-2">
                        <div class="md:w-1/3">
                            <label class="block text-white font-bold md:text-right mb-1 md:mb-0 pr-4"
                                   for="inline-username">

                            </label>
                        </div>
                        <div class="md:w-2/1">
                            <input class="bg-gray-200
                                    appearance-none
                                     border-2
                                      border-gray-200
                                        w-full
                                         py-2
                                          px-4
                                           text-gray-700
                                            leading-tight
                                             focus:outline-none
                                              focus:bg-white
                                               focus:border-gray-400
                                               xl:rounded-0
"
                                   id="inline-username"
                                   type="password"
                                   name="senha"
                                   placeholder="Senha"
                                   autocomplete="off"
                            >

                        </div>
                    </div>

                    <div class="md:flex md:items-center mb-2">
                        <div class="md:w-1/3"></div>
                        <label class="md:w-2/3 block text-gray-500 font-bold">
                            <input class="mr-2 leading-tight cursor-pointer" type="checkbox" name="conectado">
                            <span class="text-sm">Manter conectado</span>
                        </label>
                    </div>
                    <div class="md:flex md:items-center">
                        <div class="md:w-1/3"></div>
                        <div class="md:w-2/1">
                            <input class="shadow bg-gray-300 hover:bg-gray-100 focus:shadow-outline focus:outline-none text-gray-700 font-bold py-2 w-56 xl:rounded-0 cursor-pointer"
                                   value="Acessar"
                                   type="submit">


                        </div>
                    </div>
                    <br>
                    <div class="md:flex md:items-center">
                        <div class="md:w-1/3"></div>
                        <div class="md:w-2/1">
                            <button class="shadow bg-gray-300 hover:bg-gray-100 focus:shadow-outline focus:outline-none text-gray-700 font-bold py-2 w-56 rounded-0"
                                    type="button"
                                    id="comecar"
                            >

                                Começar
                            </button>
                        </div>
                    </div>
                    <br>
                    <div class="ml-24">
                        <p class="text-danger">
                            <?php if (isset($error_senha)) {
                                echo $error_senha;
                            } else {
                                echo " ";
                            } ?>
                        </p>
                    </div>

                </form>
            </div>
        </div>
        <div class="col hide" id="formulario-cadastro">
            <div class="w-full max-w-xs ml-10">
                <div method="POST"
                      class="w-full max-w-sm"
                      id="formulario-geral-cadastro"
                      action="<?= site_url('Home/cadastro') ?>">
                    <div class="container">
                        <p class="font-mono text-base text-gray-800 text-left text-white">
                            Cadastre-se
                        </p>
                        <br>
                        <div class="container cursor-pointer" style="font-size:30px;color:white" id="back">
                            <i class="fas fa-arrow-left" title="Voltar"></i>
                        </div>
                    </div>
                    <div class="md:flex md:items-center mb-2">
                        <div class="md:w-1/3">
                            <label class="block text-white font-bold md:text-right mb-1 md:mb-0 pr-4"
                                   for="inline-full-name">
                            </label>
                        </div>
                        <div class="md:w-2/1">
                            <input class="email bg-gray-200
                                    appearance-none
                                     border-2
                                      border-gray-200
                                        w-64
                                         py-2
                                          px-5
                                           text-gray-700
                                            leading-tight
                                             focus:outline-none
                                              focus:bg-white
                                               focus:border-gray-400
                                               xl:rounded-0
"
                                   id="inline-full-name"
                                   type="text"
                                   name="email"
                                   v-model="form.email"
                                   placeholder="E-mail"
                                   autocomplete="off"

                            >
                            <br>
                            <span class=' font-mono text-red-600 text-xs'>{{error.email}}</span>
                        </div>
                    </div>
                    <div class="md:flex md:items-center mb-2">
                        <div class="md:w-1/3">
                            <label class="block text-white font-bold md:text-right mb-1 md:mb-0 pr-4"
                                   for="inline-full-name">
                            </label>
                        </div>
                        <div class="md:w-2/1">
                            <input class="bg-gray-200
                                    appearance-none
                                     border-2
                                      border-gray-200
                                        w-64
                                         py-2
                                          px-5
                                           text-gray-700
                                            leading-tight
                                             focus:outline-none
                                              focus:bg-white
                                               focus:border-gray-400
                                               xl:rounded-0
"
                                   type="text"
                                   name="nome"
                                   v-model="form.nome"
                                   placeholder="Nome"
                                   autocomplete="off"

                            >
                            <br>
                            <span class=' font-mono text-red-600 text-xs'>{{error.nome}}</span>
                        </div>
                    </div>
                    <div class="md:flex md:items-center mb-2">
                        <div class="md:w-1/3">
                            <label class="block text-white font-bold md:text-right mb-1 md:mb-0 pr-4"
                                   for="inline-full-name">
                            </label>
                        </div>
                        <div class="md:w-2/1">
                            <input class="bg-gray-200
                                    appearance-none
                                     border-2
                                      border-gray-200
                                        w-64
                                         py-2
                                          px-5
                                           text-gray-700
                                            leading-tight
                                             focus:outline-none
                                              focus:bg-white
                                               focus:border-gray-400
                                               xl:rounded-0
"
                                   type="text"
                                   name="sobrenome"
                                   v-model="form.sobrenome"
                                   placeholder="Sobrenome"
                                   autocomplete="off"

                            >
                            <br>
                            <span class=' font-mono text-red-600 text-xs'>{{error.sobrenome}}</span>
                        </div>
                    </div>
                    <div class="md:flex md:items-center mb-2">
                        <div class="md:w-1/3">
                            <label class="block text-white font-bold md:text-right mb-1 md:mb-0 pr-4"
                                   for="inline-username">

                            </label>
                        </div>
                        <div class="md:w-2/1">
                            <input class="bg-gray-200
                                    appearance-none
                                     border-2
                                      border-gray-200
                                        w-64
                                         py-2
                                          px-5
                                           text-gray-700
                                            leading-tight
                                             focus:outline-none
                                              focus:bg-white
                                               focus:border-gray-400
                                               xl:rounded-0
"
                                   id="inline-username"
                                   autocomplete="false"
                                   type="password"
                                   v-model="form.senhacadastro"
                                   name="senhacadastro"
                                   placeholder="Senha"
                            >
                            <br>
                            <span class=' font-mono text-red-600 text-xs'>{{error.senhacadastro}}</span>
                            <span class=' font-mono text-red-600 text-xs'>{{error.igualdadepass}}</span>
                        </div>
                    </div>
                    <div class="md:flex md:items-center mb-2">
                        <div class="md:w-1/3">
                            <label class="block text-white font-bold md:text-right mb-1 md:mb-0 pr-4"
                                   for="inline-username">

                            </label>
                        </div>
                        <div class="md:w-2/1">
                            <input class="bg-gray-200
                                    appearance-none
                                     border-2
                                      border-gray-200
                                        w-64
                                         py-2
                                          px-5
                                           text-gray-700
                                            leading-tight
                                             focus:outline-none
                                              focus:bg-white
                                               focus:border-gray-400
                                               xl:rounded-0
"
                                   id="inline-username"
                                   autocomplete="off"
                                   type="password"
                                   name="repsenha"
                                   v-model="form.repsenha"
                                   placeholder="Rep. Senha"
                            >
                            <br>
                            <span class=' font-mono text-red-600 text-xs'>{{error.repsenha}}</span>
                        </div>
                    </div>
                    <div class="md:flex md:items-center mb-2">
                        <div class="md:w-1/3">
                            <label class="block text-white font-bold md:text-right mb-1 md:mb-0 pr-4"
                                   for="inline-username">

                            </label>
                        </div>
                        <div class="md:w-2/1">
                            <input class=" bg-gray-200
                                    appearance-none
                                     border-2
                                      border-gray-200
                                        w-64
                                         py-2
                                          px-5
                                           text-gray-700
                                            leading-tight
                                             focus:outline-none
                                              focus:bg-white
                                               focus:border-gray-400
                                               xl:rounded-0
"
                                   id="inline-username"
                                   autocomplete="false"
                                   type="date"
                                   name="datanasc"
                                   v-model="form.datanasc"
                                   title="Data de nascimento, deve ser de maior (de acordo com a lei em seu país)"
                                   placeholder="Data Nasc."
                            >
                            <br>
                            <span class=' font-mono text-red-600 text-xs'>{{error.datanasc}}</span>
                        </div>
                    </div>
                    <div class="md:flex md:items-center mb-2">
                        <div class="md:w-1/3">
                            <label class="block text-white font-bold md:text-right mb-1 md:mb-0 pr-4"
                                   for="inline-username">

                            </label>
                        </div>
                        </div>
                    <br>

                    <div class="flex flex-wrap -mx-3 mb-2">
                        <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                            <div class="relative w-12">
                                <select class="block border-2  bg-gray-200  border-gray-200 text-gray-700 py-2 px-3 pr-8 rounded-0 focus:outline-none focus:bg-white border-gray-500  hover:border-white"
                                        id="grid-state"
                                        style="margin-left:60px"
                                        v-model="form.telcodpais"
                                >
                                    <option>55</option>
                                    <option>1</option>
                                    <option>2</option>
                                </select>

                            </div>

                        </div>
                        <br>
                        <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                            <div class="md:w-2/2">

                                <input class="
                                    phone_br
                                    bg-gray-200
                                    appearance-none
                                     border-2
                                      border-gray-200
                                         py-2
                                          px-1
                                           text-gray-700
                                            leading-tight
                                             focus:outline-none
                                              focus:bg-white
                                               focus:border-gray-400
                                               xl:rounded-0

"
                                       id="cadastro-phone"
                                       autocomplete="off"
                                       type="text"
                                       style="width:180px;margin-left:20px"
                                       name="telcel"

                                >
                            </div>
                        </div>
                    </div>
                    <div class="md:flex md:items-center mb-2">
                        <div class="md:w-1/3">
                            <label class="block text-white font-bold md:text-left mb-1 md:mb-0 pr-4"
                                   for="inline-username">

                            </label>
                        </div>
                        <div class="md:w-2/1">
                        <span class=' font-mono text-red-600 text-xs'>{{error.telcel}}</span>
                        </div>
                    </div>
                </div>

                    <div class="md:flex md:items-center">
                        <div class="md:w-1/3"></div>
                        <div class="md:w-2/1">
                            <input class="cursor-pointer shadow bg-gray-300 hover:bg-gray-100 focus:shadow-outline focus:outline-none text-gray-700 font-bold py-2 w-64 rounded-0"
                                   type="submit"
                                   value="Pronto"
                                   id="pronto"
                            >
                        </div>
                    </div>
                    <br>
                </form>
            </div>
        </div>
        <div class="col">
            <div class="img-home">
                <img src="<?= URL_RAIZ() . 'application/assets/images/svg/home.svg' ?>" style="width: 450px">
            </div>
        </div>
    </div>
</div>
</body>
<script type="text/javascript" src="<?=  site_url("js/index.js") ?>"></script>
<!-----------------------------------------jquery-default-sistema------------------------------------------------------>
<script type="text/javascript" src="<?= site_url("application/assets/js/libs/jquery-3.4.1/jquery.js") ?>"></script>
<!------------------------------------------jquery-ui-p/-modal--------------------------------------------------------->
<script type="text/javascript" src="<?= site_url("application/assets/js/libs/jquery-1.12.4/jquery-1.12.4.js") ?>"></script>
<!----------------------------------------------jquery-ui-------------------------------------------------------------->
<script type="text/javascript" src="<?= site_url("application/assets/js/libs/jquery-ui-1.12.1/jquery-ui.js") ?> "></script>
<script type="text/javascript" src="<?= site_url("application/assets/js/libs/vue.js") ?>"></script>
<script type="text/javascript" src="<?= site_url("application/assets/js.js") ?>" ></script>
<script type="text/javascript" src="<?= site_url("application/assets/mascaras.js") ?> "></script>
<script type="text/javascript" src="<?= site_url("application/assets/js/libs/jquery.mask.js") ?> "></script>
<script type="text/javascript" src="<?= site_url("application/assets/js/libs/icons/fontawesome-free-5.10.2-web/js/all.js") ?> "></script>
