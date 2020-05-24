var App = {}

    /**
    * Url padrão Codegniter com Modulos
    **/

    App.url = function (modulo, controller, methods, params) {

        if (modulo === '') {
            if(typeof (params) !== 'undefined'){
                return window.origin +  "/"  + controller + "/" + methods + "/" + params
            }
            return window.origin +  "/"  + controller + "/" + methods
        }
        if (typeof (params) !== 'undefined') {
            return window.origin + "/" + modulo + "/" + controller + "/" + methods + "/" + params
        } else {
        return window.origin + "/"  + modulo + "/" + controller + "/" + methods
        }
    },

    /**
     * Busca todas as informações do Form, inclusive os com attributo disabled
    **/

    App.form_data = function(form){

        function getDisableInput(form) {
            var input = $(form + " input:disabled");
            var result = '';
            $.each(input, function (key, val) {
                result += "&" + val.name + '=' + val.value;
            });
            return result;
        }

        var disableInput = getDisableInput(form);
        return $(form).serialize() + disableInput;

    // if(typeof form != "undefined"){
    //     return $(form).serializeArray();
    // }
    }

$(document).ready(function(){
    $(".content-open-menu-chat").on("click",function(){
        $(".content-menu-chat").toggleClass('hide-transition');
    })

})

Vue.filter('firstUpperCase', function (value) {
    function pri_mai(text){
        if(!_.isUndefined(text)) {
            var str = text;
            qtd = text.length;
            prim = str.substring(0, 1);
            resto = str.substring(1, qtd);
            str = prim.toUpperCase() + resto;
            text = str;
            return text;
        }
    }
    return pri_mai(value)
})

