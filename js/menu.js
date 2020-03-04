var menu = {
    Url: function (metodo, params) {
        return App.url("", "Home", metodo, params);
    }
}

const Autocomplete = {
    name: "autocomplete",
    template: "#autocomplete",
    props: {
        items: {
            type: Array,
            required: false,
            default: () => []
        },
        isAsync: {
            type: Boolean,
            required: false,
            default: false
        },
        ariaLabelledBy: {
            type: String,
            required: true,
        },
    },

    data() {
        return {
            isOpen: false,
            results: [],
            teste:false,
            search: "",
            isLoading: false,
            arrowCounter: -1,
            activedescendant: '',
            path_img_search_default   : location.origin + '/application/assets/libs/images/event-view/user-1.jpg',

        };
    },

    methods: {
        onChange() {
            this.$emit("input", this.search);

            if (this.isAsync) {
                this.isLoading = true;
            } else {
                this.filterResults();
                this.isOpen = true;
            }
        },

        filterResults() {
            this.results = this.items.filter(item => {
                return item.toLowerCase().indexOf(this.search.toLowerCase()) > -1;
            });
        },
        setResult(result) {
            this.search = result;
            this.isOpen = false;
        },
        onArrowDown(evt) {
            if (this.arrowCounter < this.results.length) {
                this.arrowCounter = this.arrowCounter + 1;
                this.setActiveItem();

            }
        },
        onArrowUp() {
            if (this.arrowCounter > 0) {
                this.arrowCounter = this.arrowCounter - 1;
                this.setActiveItem();
            }
        },
        onEnter() {
            this.search = this.results[this.arrowCounter];
            this.isOpen = false;
            this.arrowCounter = -1;
        },
        handleClickOutside(evt) {
            if (!this.$el.contains(evt.target)) {
                this.isOpen = false;
                this.arrowCounter = -1;
                this.activedescendant = '';
            }
        },
        setActiveItem() {
            this.activedescendant = this.getId(this.arrowCounter);
        },

        isSelected(index) {
            return index === this.arrowCounter;
        },
        getId(index) {
            return `result-option-${index}`;
        }
    },
    watch: {
        items: function(val, oldValue) {
            if (val.length !== oldValue.length) {
                this.results = val;
                this.isLoading = false;
            }
        }
    },
    mounted() {
        document.addEventListener("click", this.handleClickOutside);
    },
    destroyed() {
        document.removeEventListener("click", this.handleClickOutside);
    }
};


var vue_instance_menu = new Vue({
    el: "#content-menu",
    data: {
        itens:['aaaaaaaaaaa','bbbbbbbbbbbb','ccccccccccccc','aaaaaabbbbbbbbbbbbbb'],
        img_profile : '',
        data_user_local : "",
        path_img_time_line_default : location.origin + '/application/assets/libs/images/dp.jpg',
        amigos      : [],
        result      :[]

    },
    components: {
        autocomplete: Autocomplete
    },
    mounted:function(){
        var self_vue  = this;
        var url       = App.url("area_a", "Area_a", "get_img");
        // ------------------profile-------------------
        $.post(url, {type:"profile"}, function(response){self_vue.$data.img_profile = response.path;},'json');
        var url       = App.url("pessoas", "Amigos", "solicitacoes_by_usuario_limit");
        // ------------------profile-------------------
        $.post(url, {}, function(response){self_vue.$data.amigos = response.data;},'json');
        var url       = App.url("area_a", "Area_a", "data_user_local");
        // ------------------profile-------------------
        $.post(url, {}, function(response){
            self_vue.$data.data_user_local = response.data;
            },'json');
    },
    methods:{
        aceitar_pessoa:function(id,l){

            $.post(
                App.url("pessoas","Amigos","aceitar_pessoa"),
                {
                    id:id
                },
                function(json){
                    if(json.info){

                        $(".card-list-solicitacao:eq("+l+")").remove();

                    }

                },'json')
        }
    }
})
// -----------------------------------------------Autocomplete----------------------------------------------------------


// new Vue({
//     el: "#autocomplete-app",
//     data:{
//         itens:['aaaaaaaaaaa','bbbbbbbbbbbb','ccccccccccccc','aaaaaabbbbbbbbbbbbbb'],
//     },
//     // name: "autocomplete",
//     components: {
//         autocomplete: Autocomplete
//     }
// });





