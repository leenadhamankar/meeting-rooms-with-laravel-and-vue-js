import './bootstrap';
import { createApp } from 'vue';
import StartComponent from './components/StartComponent.vue'
import axios from "axios";

const app = createApp()
app.component('example-component', ExampleComponent)
app.mount('#app');

const api = axios.create({
    baseURL: "http://127.0.0.1:8000/api",
    withCredentials: true,
    headers: {
        "Content-Type": "application/json",
        Accept: "application/json",
    },
});

export default api;