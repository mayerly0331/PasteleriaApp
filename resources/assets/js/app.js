/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('cliente', require('./components/Cliente.vue'));
Vue.component('rol', require('./components/Rol.vue'));
Vue.component('ventas', require('./components/Ventas.vue'));
Vue.component('producto', require('./components/Producto.vue'));
Vue.component('usuarios', require('./components/Usuario.vue'));
Vue.component('proveedor', require('./components/Proveedor.vue'));
Vue.component('encargo', require('./components/Encargos.vue'));


const app = new Vue({
    el: '#app',
    data: {
        menu: 0
    }
});