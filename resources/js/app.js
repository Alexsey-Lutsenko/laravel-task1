/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");
import { createApp } from "vue";
import router from "./router/router";
import store from "./store";
import App from "./views/App";
import components from "./components/ui";
// import PrimeVue from "primevue/config";

// import "primevue/resources/themes/bootstrap4-light-blue/theme.css";
// import "primevue/resources/primevue.min.css";
// import "primeicons/primeicons.css";

const app = createApp(App);

components.forEach((component) => {
    app.component(component.name, component);
});

app.use(router).use(store).mount("#app");
