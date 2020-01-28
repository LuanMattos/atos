<div class="user-data full-width" >
    <div class="categories-left-heading">
        <h6><a href="<?= site_url("pessoas/Pessoas/index")?>">Conheça </a></h6>
    </div>
    <template v-for="i in users_menu">
        <div class="sugguest-user">
            <div class="sugguest-user-dt">
                <a href="user_dashboard_activity.html">
                    <img class="crop-img-home-mini" :src="i.img_profile.length?i.img_profile:path_img_time_line_default" alt=""></a>
                <a href="user_dashboard_activity.html"><h4>{{i.nome}}</h4></a>
            </div>
            <button class="request-btn"><i class="fas fa-user-plus"></i></button>
        </div>
    </template>
</div>