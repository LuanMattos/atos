<?php if(isset($data['externo'])): ?>
    <div class="dash-todo-thumbnail-area1 " id="content-area-a">
        <div class="todo-thumb1 dash-bg-image1 dash-bg-overlay crop-img-home" style="background-image:url('<?= set_val($data['img_cover']) ?>')">
            <div class="float-right mr-4" style="margin-top: 60px">
            </div>
        </div>
        <div class="dash-todo-header1">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="my-profile-dash">
                            <div class="my-dp-dash">
                                <div class=" container-avatar">
                                    <img src="<?= isset($data['img_profile']) && !empty($data['img_profile'])?$data['img_profile']:URL_RAIZ(). '/application/assets/libs/images/event-view/user-1.jpg' ?>" class="image_avatar crop-img-home">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="dash-todo-thumbnail-area1 crop-img-home dash-bg-image1 dash-bg-overlay" id="content-area-a" v-bind:style="img_cover.length?'background-image:url(' + img_cover + ')':'background-image:url('+path_img_cover_default +')' ">
        <div class="todo-thumb1 dash-bg-image1 dash-bg-overlay " >
            <div class="float-right mr-4" style="margin-top: 60px">
                <div class="icon-home-cover cursor-pointer" >
                    <i class="fas fa-camera" @click="openfilecover"></i>
                </div>
            </div>
            <input type="file" id="input-file-img-cover" name="fileimagemcover" style="display:none" @change="update_img_cover">
        </div>
        <div class="dash-todo-header1">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="my-profile-dash">
                            <div class="my-dp-dash">
                                <div class=" container-avatar">
                                    <img :src="img_profile.length?img_profile:path_img_profile_default" class="image_avatar crop-img-home">
                                    <div class="overlay-avatar-home" @click="openfile">
                                        <div class="icon-home-profile cursor-pointer">
                                            <i class="fas fa-camera home-profile"></i>
                                        </div>
                                    </div>
                                    <input type="file" id="input-file-img-profile" name="fileimagemprofile" style="display:none" @change="update_img_profile">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
