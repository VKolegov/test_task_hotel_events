import { createPinia } from 'pinia';
import { Dialog, Quasar } from 'quasar';
import quasarIconSet from 'quasar/icon-set/svg-mdi-v7';
import quasarLang from 'quasar/lang/ru';
import { createApp } from 'vue';

// Import icon libraries
import '@quasar/extras/material-icons/material-icons.css';

// A few examples for animations from Animate.css:
// import @quasar/extras/animate/fadeIn.css
// import @quasar/extras/animate/fadeOut.css

// Import Quasar css
import 'quasar/dist/quasar.css';

// Assumes your root component is App.vue
// and placed in same folder as main.js
import App from './App.vue';
import router from './router';

const app = createApp(App);

app.use(createPinia());
app.use(router);

app.use(Quasar, {
  config: {
    dark: 'auto',
  },
  plugins: {
    Dialog,
  }, // import Quasar plugins and add here
  lang: quasarLang,
  iconSet: quasarIconSet,
});

// Assumes you have a <div id="app"></div> in your index.html
app.mount('#app');
