<div class="col-lg-12 col-md-12 ">
    <div v-show="posts.length" v-cloak>
        <div class="col-sm-12" v-for="(post, index) in posts" style="margin-bottom: 30px">
                    <div class="main-tabs ">
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab-upcoming">
                                <div class="main-posts">
                                    <div class="event-main-post">
                                        <div class="event-top">
                                            <div class="event-top-left">
                                                <a href="#">
                                                    <h4>Nome de quem postou</h4>
                                                    <div >{{post.text}}</div>
                                                </a>
                                            </div>
                                            <div class="event-top-right">
                                                <div class="post-dt-dropdown dropdown">
                                                <span class="dropdown-toggle-no-caret" role="button"
                                                      data-toggle="dropdown">
                                                     <i class="fas fa-ellipsis-v"></i>
                                                </span>
                                                    <div class="dropdown-menu post-rt-dropdown dropdown-menu-right">
                                                        <a class="post-link-item" href="#">Ocultar</a>
                                                        <a class="post-link-item" href="#">Detalhes</a>
                                                        <a class="post-link-item" href="#">Perfil usuário</a>
                                                        <a class="post-link-item" href="#">Reportar</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="event-main-image" >
                                            <div class="main-photo">
                                                <img :src="post.path">
                                            </div>
                                        </div>
                                        <div class="event-city-dt p-2">
                                            <ul class="city-dt-list">
                                                <li>
                                                    <div class="it-items">
                                                        <i class="fas fa-map-marker-alt"></i>
                                                        <div class="list-text-dt">
                                                            <ins>Novo Hamburgo</ins>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="it-items">
                                                        <i class="fas fa-calendar-alt"></i>
                                                        <div class="list-text-dt">
                                                            <ins>21 Nov 2019</ins>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="it-items">
                                                        <i class="fas fa-clock"></i>
                                                        <div class="list-text-dt">
                                                            <ins>6 PM</ins>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="like-comments">
                                            <div class="left-comments">
                                                <a href="#" class="like-item" title="Like">
                                                    <i class="fas fa-heart"></i>
                                                    <span><ins>Gostei</ins> 251</span>
                                                </a>
                                                <a href="#" class="like-item lc-left" title="Comment">
                                                    <i class="fas fa-comment-alt"></i>
                                                    <span><ins>Comentários</ins> 10</span>
                                                </a>
                                            </div>
                                            <div class="right-comments">
                                                <a href="#" class="like-item" title="Share">
                                                    <i class="fas fa-share-alt"></i>
                                                    <span><ins>Compartilhamentos</ins> 21</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

        </div>
        <mugen-scroll :handler="getPosts" :should-handle="!loading">
            <div>
                 Carregando
            </div>
            <div class="spinner">
                 <div class="bounce1"></div>
                 <div class="bounce2"></div>
                 <div class="bounce3"></div>
            </div>
        </mugen-scroll>
<!--        <mugen-scroll :handler="getPosts" :should-handle="!loading">-->
<!--            <div style="padding-bottom:50px ">-->
<!--                <div class="main-loader">-->
<!--                    <div class="spinner">-->
<!--                        <div class="bounce1"></div>-->
<!--                        <div class="bounce2"></div>-->
<!--                        <div class="bounce3"></div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </mugen-scroll>-->
    </div>
</div>
