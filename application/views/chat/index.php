<div class="chat-content" >
    <div class="chat" v-bind:class="minimize_class">
        <div class="chat-title-notification" >
            <figure class="avatar">
                <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/156381/profile/profile-80.jpg" />
            </figure>
            <h1>Maria Silva</h1>
            <h2>Pereira</h2>
            <i class="fas fa-comment-alt"></i>
        </div>
        <div class="chat-title" >
            <figure class="avatar">
                    <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/156381/profile/profile-80.jpg" />
            </figure>
            <h1>Fabio Ottaviani</h1>
            <h2>Supah</h2>
            <div class="ico-minimize-maximize" @click="minimize_maximize()">
                <i v-bind:class="ico_minimize_maximise"></i>
            </div>
<!--                <i class="far fa-window-maximize"></i>-->
            <div class="ico-close" @click="close($event)">
                 <i class="fas fa-times"></i>
            </div>
        </div>
        <div class="messages">
            <div class="messages-content"></div>
        </div>
        <div class="message-box">
            <textarea type="text" class="message-input" placeholder="Digite algo aqui.." ></textarea>
            <button type="submit" class="message-submit" @click="insertMessage()">Enviar</button>
        </div>
    </div>
    <div class="bg"></div>
</div>
