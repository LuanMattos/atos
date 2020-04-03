var vue_lightbox = new Vue({
  el: '#lightbox',
  data: {
    visible: false,
    imgs: [

    ]
  },
  methods: {
    showImg (index) {
      this.index = index
      this.visible = true
    },
    handleHide () {
      this.visible = false
    }
  }
})