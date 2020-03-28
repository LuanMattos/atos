<div class="chat-content hide" v-bind:class="minimize_class">
    <div class="chat" >
<!--        <div class="chat-title-notification" >-->
<!--            <figure class="avatar">-->
<!--                <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/156381/profile/profile-80.jpg" />-->
<!--            </figure>-->
<!--            <h1>Maria Silva</h1>-->
<!--            <h2>Pereira</h2>-->
<!--            <i class="fas fa-comment-alt"></i>-->
<!--        </div>-->
        <div class="chat-title">
             <div class="row">
                 <div class="col-1">
                        <figure class="avatar crop-img-center">
                            <img v-bind:src="img_profile" />
                        </figure>
                 </div>
                 <div class="col-7">
                     <div style="margin-top: 10px">
                         <h1 v-if="data_user" v-cloak>{{data_user.usuario.nome}}</h1>
                         <h2 v-if="data_user" v-cloak>{{data_user.usuario.sobrenome}}</h2>
                     </div>
                 </div>
                 <div class="col-1">
<!--                        <div class="ico-minimize-maximize" @click="minimize_maximize()">-->
<!--                            <i v-bind:class="ico_minimize_maximise + ' cursor-pointer min-max'"></i>-->
<!--                        </div>-->
                 </div>
                 <div class="col-1">
                        <i class="fas fa-times cursor-pointer" @click="close($event)" style="margin-top: 7px"></i>
                    </div>
             </div>
            <div class="row" style="margin-top: 10px">
                <div class="col">
                    <template v-for="x in  status">
                        <span v-bind:style="'color:' + x.color  + ';' + 'font-size:8px'" v-cloak>{{x.text}}</span>
                    </template>
                </div>
            </div>
        </div>
        <div class="messages" >
            <div  class="messages-content">
                <template v-for="message in messages" >
                   <div v-bind:class="message.recebendo?'message new':'message message-personal new'" class="crop-img-pessoas-mini">
                        <figure class="avatar" v-if="message.recebendo">
                                <img v-bind:src="message.img_profile ? message.img_profile : img_profile" />
                        </figure>
                        <span class="date" >{{ message.date }}</span>
                        <span class="name" >{{ message.user }}:</span>
                        <span class="text" >{{ message.text }}</span>
                    </div>
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
