var chat = {
    Url: function (metodo, params) {
        return App.url("area_a", "Area_a", metodo, params);
    }
}
var vue_instance_chat = new Vue({
    el:"#content-chat",
    data:{
        data_users               : [],
        img_profile              : '',
        img_cover                : '',
        path_img_profile_default : location.origin + '/application/assets/libs/images/my-dashboard/my-dp.jpg',
        path_img_cover_default   : location.origin + '/application/assets/libs/images/event-view/my-bg.jpg',
        messages_content:'',
        Fake : [
            'Hi there, I\'m Fabio and you?',
            'Nice to meet you',
            'How are you?',
            'Not too bad, thanks',
            'What do you do?',
            'That\'s awesome',
            'Codepen is a nice place to stay',
            'I think you\'re a nice person',
            'Why do you think that?',
            'Can you explain?',
            'Anyway I\'ve gotta go now',
            'It was a pleasure chat with you',
            'Time to make a new codepen',
            'Bye',
            ':)'
        ]

    },
    mounted:function(){
        var self_vue  = this;
        // ------------------profile-------------------
        var url  = chat.Url("get_img");
        $.post(url, {type:"profile"}, function(response){self_vue.$data.img_profile = response.path;},'json');
        // ------------------cover------------------
        var url  = chat.Url("get_img");
        $.post(url, {type:"cover"}, function(response){self_vue.$data.img_cover = response.path;},'json');

        var $messages = $('.messages-content'),
          d, h, m,
          i = 0;
        $messages.mCustomScrollbar();
        setTimeout(function() {
            fakeMessage();
        }, 100);

    },
    methods:{
        fakeMessage : function(){
            var i = 0;
            var self = this;
            if ($('.message-input').val() != '') {
                return false;
            }
            $('<div class="message loading new"><figure class="avatar"><img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/156381/profile/profile-80.jpg" /></figure><span></span></div>').appendTo($('.mCSB_container'));
            this.updateScrollbar();

            setTimeout(function() {
                $('.message.loading').remove();
                $('<div class="message new"><figure class="avatar"><img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/156381/profile/profile-80.jpg" /></figure>' + self.Fake[i] + '</div>').appendTo($('.mCSB_container')).addClass('new');
                self.setDate();
                self.updateScrollbar();
                i++;
            }, 1000 + (Math.random() * 20) * 100);
        },
        setDate:function(){
           var d = new Date();
           var m = '';
            if (m != d.getMinutes()) {
                m = d.getMinutes();
                $('<div class="timestamp">' + d.getHours() + ':' + m + '</div>').appendTo($('.message:last'));
            }
        },
        minimizar:function(){
        },
        updateScrollbar:function(){
            var messages_content = $('.messages-content');
            messages_content.mCustomScrollbar("update").mCustomScrollbar('scrollTo', 'bottom', {
                    scrollInertia: 10,
                    timeout: 0
                });
        },
        insertMessage:function(){
            var msg = $('.message-input').val();
            var self = this;
            if ($.trim(msg) == '') {
                return false;
            }
            $('<div class="message message-personal">' + msg + '</div>').appendTo($('.mCSB_container')).addClass('new');
            this.setDate();

            $('.message-input').val(null);
            this.updateScrollbar();
            setTimeout(function() {
                self.fakeMessage();
            }, 1000 + (Math.random() * 20) * 100);
        }

    },computed:{
        tester_submit:function(){
            // if (this.which == 13) {
            //     insertMessage();
            //     return false;
            // }

        }
    }
});

// var $messages = $('.messages-content'),
//     d, h, m,
//     i = 0;

$(document).ready(function() {

});

// function updateScrollbar() {
//     $messages.mCustomScrollbar("update").mCustomScrollbar('scrollTo', 'bottom', {
//         scrollInertia: 10,
//         timeout: 0
//     });
// }

// function setDate(){
//     d = new Date()
//     if (m != d.getMinutes()) {
//         m = d.getMinutes();
//         $('<div class="timestamp">' + d.getHours() + ':' + m + '</div>').appendTo($('.message:last'));
//     }
// }

function insertMessage() {
    // var msg = $('.message-input').val();
    // if ($.trim(msg) == '') {
    //     return false;
    // }
    // $('<div class="message message-personal">' + msg + '</div>').appendTo($('.mCSB_container')).addClass('new');
    //
    // setDate();
    // $('.message-input').val(null);
    // updateScrollbar();
    // setTimeout(function() {
    //     fakeMessage();
    // }, 1000 + (Math.random() * 20) * 100);
}

// $('.message-submit').click(function() {
//     insertMessage();
// });

$(window).on('keydown', function(e) {
    // if (e.which == 13) {
    //     insertMessage();
    //     return false;
    // }
})

var Fake = [
    'Hi there, I\'m Fabio and you?',
    'Nice to meet you',
    'How are you?',
    'Not too bad, thanks',
    'What do you do?',
    'That\'s awesome',
    'Codepen is a nice place to stay',
    'I think you\'re a nice person',
    'Why do you think that?',
    'Can you explain?',
    'Anyway I\'ve gotta go now',
    'It was a pleasure chat with you',
    'Time to make a new codepen',
    'Bye',
    ':)'
]

function fakeMessage() {
    // if ($('.message-input').val() != '') {
    //     return false;
    // }
    // $('<div class="message loading new"><figure class="avatar"><img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/156381/profile/profile-80.jpg" /></figure><span></span></div>').appendTo($('.mCSB_container'));
    // updateScrollbar();
    //
    // setTimeout(function() {
    //     $('.message.loading').remove();
    //     $('<div class="message new"><figure class="avatar"><img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/156381/profile/profile-80.jpg" /></figure>' + Fake[i] + '</div>').appendTo($('.mCSB_container')).addClass('new');
    //     setDate();
    //     updateScrollbar();
    //     i++;
    // }, 1000 + (Math.random() * 20) * 100);

}

