<div class="user-data full-width" >
    <div class="categories-left-heading">
        <h6><a href="<?= site_url("pessoas/Pessoas/index")?>">Sugestões </a></h6>
    </div>
    <template v-for="(i,l) in users_menu">
        <div class="sugguest-user">
            <div class="sugguest-user-dt">
                <a href="user_dashboard_activity.html">
                    <img class="crop-img-home-mini" :src="i.img_profile.length?i.img_profile:path_img_time_line_default" alt=""></a>
                <a href="user_dashboard_activity.html"><h4>{{i.nome}}</h4></a>
            </div>

            <button   :class="i.sol?'hide':'' + 'request-btn btn-enviar-solicitacao'" @click="add_person(i._id,l); verify_click('enviar',l)"><i class="fas fa-user-plus" ></i></button>

            <div :class="!i.sol?'hide':'' + 'dropdown div-confirmada-solicitacao' " >
                    <button class="dropdown-toggle request-confirme-btn  " id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-check"></i></button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <span class="dropdown-item cursor-pointer " @click="add_person(i._id,l); verify_click('cancelar',l)" >Cancelar solicitação</span>
                        <span class="dropdown-item cursor-pointer" >Enviar mensagem</span>
                        <span class="dropdown-item cursor-pointer" >Bloquear</span>
                    </div>
            </div>






        </div>
    </template>
</div>