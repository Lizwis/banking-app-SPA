import { createApp } from 'vue'
import { createPinia } from 'pinia'



import App from './App.vue'
import router from './router'

import "bootstrap";
import "bootstrap/dist/css/bootstrap.min.css";

import "element-plus/dist/index.css";
import "@element-plus/theme-chalk/dist/index.css";   

const app = createApp(App)

app.use(createPinia())
app.use(router)

app.mount('#app')
