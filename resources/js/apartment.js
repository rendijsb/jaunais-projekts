import './bootstrap';
import { createApp } from 'vue';
import ApartmentPage from './components/ApartmentPage.vue';

const app = createApp(ApartmentPage);
const mountElement = document.getElementById('apartment-app');
app.provide('flatNumber', mountElement.dataset.flatNumber);
app.mount('#apartment-app');