import '@fortawesome/fontawesome-free/css/all.css';
import { createApp } from "vue";
// import "./bootstrap";
import App from "./App.vue";
import router from "./router";
import "vuetify/styles";
import { createVuetify } from "vuetify";
import * as components from "vuetify/components";
import * as directives from "vuetify/directives";
import { aliases, fa } from 'vuetify/iconsets/fa'
import store from './store';
import { abilitiesPlugin } from '@casl/vue';
import ability from './services/ability';

const vuetify = createVuetify({
    components,
    directives,
    theme: {
        defaultTheme: "dark",
    },
    icons: {
        defaultSet: 'fa',
        aliases,
        sets: {
          fa,
        },
      },
});

const app = createApp(App);
app.use(router);
app.use(store);
app.use(vuetify);
app.use(abilitiesPlugin, ability,{
    useGlobalProperties : true
});
app.mount("#app");
