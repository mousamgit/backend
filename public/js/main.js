import { createApp } from 'https://unpkg.com/vue@3.2.47/dist/vue.esm-browser.js';
import LoginForm from './components/auth/LoginForm.js';
import RegistrationForm from './components/auth/RegistrationForm.js';

const app = createApp({});

app.component('login-form', LoginForm);
app.component('registration-form', RegistrationForm);

app.mount('#app');
