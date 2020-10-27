import Vue from "vue";

import VueAlertify from "./plugins/VueAlertify";

import VModal from "vue-js-modal";

import VueGoodTablePlugin from 'vue-good-table';

import "~/init/axios";

window.$ = window.jQuery = require("jquery");

require("bootstrap");
require("admin-lte");

// import the styles
import 'vue-good-table/dist/vue-good-table.css'

Vue.use(VueGoodTablePlugin);

Vue.use(VueAlertify, {
  notifier: {
    // auto-dismiss wait time (in seconds)
    delay: 5,
    // default position
    position: "top-right",
    // adds a close button to notifier messages
    closeButton: false
  },
  theme: {
    ok: "btn btn-primary",
    cancel: "btn btn-danger",
    input: "form-control"
  }
});

Vue.use(VModal, { dynamic: true });
