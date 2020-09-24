import Alertify from "alertifyjs";

let VueAlertify = {};

VueAlertify.install = function(Vue, options) {
  Object.assign(Alertify.defaults, options);

  Object.defineProperty(Vue.prototype, "$alertify", {
    get() {
      return {
        success: function(text) {
          return Alertify.success(text);
        },
        error: function(text) {
          return Alertify.error(text);
        },
        warning: function(text) {
          return Alertify.warning(text);
        },
        message: function(text) {
          return Alertify.message(text);
        },
        alert: function(text, cb) {
          return Alertify.alert(text, cb);
        },
        alertWithTitle: function(title, text, cb) {
          return Alertify.alert(title, text, cb);
        },
        confirm: function(text, ok, cancel) {
          return Alertify.confirm(text, ok, cancel);
        },
        confirmWithTitle: function(title, text, ok, cancel) {
          return Alertify.confirm(title, text, ok, cancel);
        },
        prompt: function(text, defaultValue, ok, cancel) {
          return Alertify.prompt(text, defaultValue, ok, cancel);
        },
        promptWithTitle: function(title, text, defaultValue, ok, cancel) {
          return Alertify.prompt(title, text, defaultValue, ok, cancel);
        }
      };
    }
  });
};

export default VueAlertify;
