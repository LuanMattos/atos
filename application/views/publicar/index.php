<form>
    <div class="add-activity">
        <div class="activity-group">
            <div class="maine-activity-img">
                <img src="<?= URL_RAIZ() ?>application/assets/libs/images/event-view/user-1.jpg" alt="">
            </div>
            <textarea class="add-activity-des" placeholder="O que tem de novo ai <?= isset($data['nome'])?$data['nome']:'' ?>?"></textarea>
        </div>
        <div class="activity-button">
            <button class="act-btn-post" type="submit">Publicar</button>
        </div>
    </div>
</form>
