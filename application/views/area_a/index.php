<div class="dash-todo-thumbnail-area1" style="margin-top: 80px">
    <div class="todo-thumb1 dash-bg-image1 dash-bg-overlay" style="background-image:url(images/event-view/my-bg.jpg);"></div>
    <div class="dash-todo-header1">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="my-profile-dash">
                        <div class="my-dp-dash ">
                            <img class="crop-img-home cursor-pointer"
                                 :src="img_profile.length?img_profile:path_img_profile_default"
                                 alt=""
                                 @click="openfile"
                            >
                            <input type="file" id="input-file-img-profile" name="fileimagemprofile" style="display:none" @change="update_img_profile">
                            <span class="cursor-pointer input-file-photo" style="font-size:25px">
                        </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>