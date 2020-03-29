<style id="dynamic-styles"></style>
<div id="hangout" class="content-menu-chat hide-transition">
    <div id="content">
        <div class="list-account">
            <div class="meta-bar">
                <input class="nostyle search-filter" type="text" placeholder="Buscar"/>
            </div>
            <ul class="list mat-ripple">
                <template v-for="amigo in amigos">
                    <li @click="open_chat(amigo)">
                        <img v-bind:src="amigo.img_profile" class="crop-img-home-mini">
                        <span class="name">{{amigo.nome}} {{amigo.sobrenome}}</span><i class="mdi mdi-menu-down"></i>
                    </li>
                </template>
            </ul>
        </div>
    </div>
</div>

