import './bootstrap';
import { createApp } from 'vue';
import App from './App.vue';
import imagePlugin from './plugins/imagePlugin'; // Adjust the import path as necessary

const app = createApp(App);


app.config.globalProperties.$testMethod = () => "Test Method";
app.use(imagePlugin); // Use the plugin

app.mount('#app');

console.log("I'm app.js");
