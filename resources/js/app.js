import Vue from "vue";

import App from "~/App.vue";

import router from "~/router/router";
import store from "~/store/store";

import "~/bootstrap";
import "~/components";

Vue.config.productionTip = false;

store.dispatch("auth/setUser").finally(() => {
  new Vue({
    router,
    store,
    render: h => h(App)
  }).$mount("#app");
});
