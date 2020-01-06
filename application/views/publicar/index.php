<div class="col-lg-12 col-md-12 " style="z-index: 1">
    <div class="main-posts" style="z-index: 2">
        <div class="add-activity" style="z-index: 3">
            <div class="activity-group">
                <div class="maine-activity-img">
                    <img src="<?= URL_RAIZ() ?>application/assets/libs/images/event-view/user-1.jpg" alt="">
                </div>
                <textarea style="z-index:0" :class="error_text_area?'border-danger-postagem':''" class="add-activity-des"  id='text-area-postagem' placeholder="O que tem de novo?"></textarea>
            </div>
            <form id="form-input-time-line" method="post" enctype="multipart/form-data">
                <div class="setting-upload">
                    <div class="addpic">
                        <input type="file" id="input-file-postagem" name="file">
                        <span class="cursor-pointer input-file-photo" style="font-size:25px">
                            <i @click="openfile()" class=" fas fa-camera-retro " :class="error_input_file?'danger-input-file':''"></i>
                        </span>
                    </div>
                </div>
                <div class="activity-button">
                    <button class="act-btn-post cursor-pointer" type="submit" @click.prevent="postar">Postar</button>
                </div>
            </form>


        </div>
    </div>
</div>