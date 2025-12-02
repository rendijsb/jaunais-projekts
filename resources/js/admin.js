import './bootstrap';
import { createApp } from 'vue';
import LoginForm from './components/admin/LoginForm.vue';
import Dashboard from './components/admin/Dashboard.vue';

const app = createApp({});

app.component('LoginForm', LoginForm);
app.component('AdminDashboard', Dashboard);

app.mount('#admin-app');
