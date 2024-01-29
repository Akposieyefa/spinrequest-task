import {createApp} from 'vue/dist/vue.esm-bundler'
import Application from './App.vue'
import Router from './router'
import Store from  './store'
import {Vue3ProgressPlugin} from '@marcoschulte/vue3-progress';
import Vue3Toasity from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
import '@marcoschulte/vue3-progress/dist/index.css';


const app = createApp({});

app.component('app', Application);
app.use(Router);
app.use(Store);
app.use(Vue3ProgressPlugin, {disableGlobalInstance: true});
app.use(Vue3Toasity,
    {
        autoClose: 3000,
        // ...
    })
app.mount('#app');
