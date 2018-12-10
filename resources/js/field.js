import vueVimeoPlayer from 'vue-vimeo-player'
import VueCarousel from 'vue-carousel'
import VueYoutube from 'vue-youtube'

Nova.booting((Vue, router) => {
  Vue.use(vueVimeoPlayer)
  Vue.use(VueCarousel)
  Vue.use(VueYoutube)
  Vue.component('index-PostContent', require('./components/IndexField'))
  Vue.component('detail-PostContent', require('./components/DetailField'))
  Vue.component('form-PostContent', require('./components/FormField'))
})
