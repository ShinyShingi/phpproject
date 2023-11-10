import './bootstrap';

import {createApp} from 'vue'
import App from './App.vue';

const app = createApp({
    /* root component options */
})

console.log("I'm app.js")
createApp(App).mount('#app')

