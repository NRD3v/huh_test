import Vue from 'vue'
import Vuetify from 'vuetify'
import App from './components/App.vue'
import store from './store'

Vue.use(Vuetify);

const app = new Vue({
    el: '#app',
    store,
    render: h => h(App)
});
