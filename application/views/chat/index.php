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
            <h1 v-html="user"></h1>
            <h2 >Supah</h2>
            <template v-for="x in  status">
                <span v-bind:style="'color:' + x.color  + ';' + 'font-size:8px'" v-cloak>{{x.text}}</span>
            </template>
            <div class="ico-minimize-maximize" @click="minimize_maximize()">
                <i v-bind:class="ico_minimize_maximise"></i>
            </div>
<!--                <i class="far fa-window-maximize"></i>-->
            <div class="ico-close" @click="close($event)">
                 <i class="fas fa-times"></i>
            </div>
        </div>
        <div class="messages">
            <div class="messages-content" >
                <template v-for="message in messages">
                    <span class="date" >{{ message.date }}</span>
                    <span class="name" >{{ message.user }}:</span>
                    <span class="text" >
                        {{ message.text }}
                    </span>
                    <br>

                </template>
            </div>
        </div>
        <div class="message-box">
            <textarea type="text" class="message-input" placeholder="Digite algo aqui.." v-model="text" @keyup.enter="sendMessage">{{text}}</textarea>
            <button type="submit" class="message-submit" @click="sendMessage">Enviar</button>
        </div>
    </div>
    <div class="bg"></div>
</div>
