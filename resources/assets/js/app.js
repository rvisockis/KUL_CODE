import './bootstrap';
import Vuetify from 'vuetify';
import 'admin-lte';
import router from './routes';
import App from './components/App.vue';
import Multiselect from 'vue-multiselect';
import FullCalendar from '@fullcalendar/vue'
import dayGridPlugin from '@fullcalendar/daygrid'
import timeGridPlugin from '@fullcalendar/timegrid'
import interactionPlugin from '@fullcalendar/interaction'
// import ElementUI from 'element-ui';
// import 'element-ui/lib/theme-chalk/index.css';
// import 'material-design-icons-iconfont';
import '@mdi/font/css/materialdesignicons.css'
import Select2 from 'select2'
Vue.component('select2', Select2)

Vue.component('multiselect', Multiselect)

Vue.component('FullCalendar', FullCalendar)

Vue.component('dayGridPlugin', dayGridPlugin)

Vue.component('timeGridPlugin', timeGridPlugin)

Vue.component('interactionPlugin', interactionPlugin)

Vue.component('home', require('./components/HomeKitas.vue'));
Vue.use(Vuetify)
export const serverBus = new Vue(); //eventbus israsui
new Vue({
    el: '#app',
    components: {
        App
    },
    vuetify : new Vuetify(),
    // template: '<App/>',
    router
})
