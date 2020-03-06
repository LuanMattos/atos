<div class="dash-dts">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="event-title">
                    <div class="my-dash-dt">
                        <h3><?= isset($data['nome'])?$data['nome']:"" ?></h3>
                        <span><?= isset($data['sobrenome'])?$data['sobrenome']:"" ?></span>
                        <span><i class="fas fa-map-marker-alt"></i>
                            <?= set_val($data['address']) ?>
                        </span>
                    </div>

                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <ul class="right-details">
                    <li>
                        <div class="my-all-evnts">
                            <a href="my_dashboard_events.html">Amigos?</a>
                        </div>
                    </li>
                    <li>
                        <div class="all-dis-evnt">
                            <div class="dscun-txt">Amigos</div>
                            <div class="dscun-numbr">22</div>
                        </div>
                    </li>
                    <li>
                        <div class="content-ico-msg" title="Iniciar conversa">
                            <i class="far fa-comments"></i>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        </div>
</div>