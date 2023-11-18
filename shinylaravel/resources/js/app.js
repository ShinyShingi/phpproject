import './bootstrap';
import  'bootstrap/dist/css/bootstrap.css';
import 'bootstrap/dist/js/bootstrap.js'
import { createApp } from 'vue';
import App from './App.vue';
import imagePlugin from './plugins/imagePlugin'; // Adjust the import path as necessary

const app = createApp(App);


app.config.globalProperties.$testMethod = () => "Test Method";
app.use(imagePlugin); // Use the plugin
app.mount('#books');
