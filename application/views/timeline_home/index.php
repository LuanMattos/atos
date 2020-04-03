<!--col-lg-12 col-md-12-->
<div class="">
    <div v-if="posts" v-cloak>
        <div class="col-sm-12" v-for="(post, index) in posts" style="margin-bottom: 30px">
            <div class="main-tabs ">
                <div class="tab-content">
                    <div class="tab-pane active" id="tab-upcoming">
                        <div class="main-posts">
                            <div class="event-main-post">
                                <div class="event-top">
                                    <div class="activity-group">
                                        <div class="event-top-left">
                                            <table>
                                                <tr>
                                                    <td>
                                                        <div class="maine-activity-img" >
                                                            <img class='crop-img-home' :src="post.img_profile?post.img_profile:path_img_time_line_default">
                                                        </div>
                                                    </td>
                                                    <td width="400px">
                                                        <a href="#" >
                                                            <span class="name-user-post">{{post.nome}}</span>
                                                            <div class="title-post">{{post.text}}</div>
                                                        </a>
                                                    </td>
                                                    <td>
                                                       <div class="post-dt-dropdown dropdown">
                                                                <span class="dropdown-toggle-no-caret" role="button"
                                                                      data-toggle="dropdown">
                                                                     <i class="fas fa-ellipsis-v"></i>
                                                                </span>
                                                                <div class="dropdown-menu post-rt-dropdown dropdown-menu-right">
                                                                    <a class="post-link-item" href="#">Ocultar</a>
                                                                    <?php if(!isset($data['externo'])): ?>
                                                                        <a class="post-link-item" href="javascript:void(0)"  @click="excluir_postagem(post._id,posts,index)">Excluir</a>
                                                                    <?php endif; ?>
                                                                    <a class="post-link-item" href="#">Detalhes</a>
                                                                    <a class="post-link-item" href="#">Perfil usuário</a>
                                                                    <a class="post-link-item" href="#">Reportar</a>
                                                                </div>
                                                            </div>
                                                    </td>
                                                </tr>
                                            </table>

                                        </div>
                                    </div>
                                </div>
                                <div class="event-main-image">
                                    <div class="main-photo" >
                                        <img class="crop-img-center" :src="post.path">
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
                                        <template v-if="post.like">
                                            <template v-if="post.like.length">
                                                <template v-for="(i,l) in post.like">
                                                    <a href="javascript:void(0)" class="like-item" title="Curtida" @click="compute_like(post,index)">
                                                        <i v-bind:class="action_like  + ' ' + (post.id_local === i._id.$oid ? 'text-like':'')" ></i>
                                                        <span> 251</span>
                                                    </a>
                                                </template>
                                            </template>
                                            <template v-if="!post.like.length">
                                                <a href="javascript:void(0)" class="like-item" title="Curtida" @click="compute_like(post,index)">
                                                    <i v-bind:class="action_like " ></i>
                                                    <span> 251</span>
                                                </a>
                                            </template>
                                        </template>
                                        <template v-else>
                                            <a href="javascript:void(0)" class="like-item" title="Curtida" @click="compute_like(post,index)">
                                                <i v-bind:class="action_like " ></i>
                                                <span> 251</span>
                                            </a>
                                        </template>
                                        <a href="#" class="like-item lc-left" title="Comment">
                                            <i class="fas fa-comment-alt"></i>
                                            <span> 10</span>
                                        </a>
                                    </div>
                                    <div class="right-comments">
                                        <a href="#" class="like-item" title="Share">
                                            <i class="fas fa-share-alt"></i>
                                            <span> 21</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
<!--        <mugen-scroll :handler="getPosts" :should-handle="!loading">-->
<!--            <div class="container">-->
<!--                <div class="spinner">-->
<!--                    <div class="bounce1"></div>-->
<!--                    <div class="bounce2"></div>-->
<!--                    <div class="bounce3"></div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </mugen-scroll>-->
    </div>
</div>
