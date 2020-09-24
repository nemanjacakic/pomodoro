import Vue from "vue";
import Vuex from "vuex";

import auth from "./modules/auth.js";
import users from "./modules/users.js";


import NProgress from "nprogress";

import { LOADING, FULL_PAGE_LOADING } from "~/store/mutation-types";

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    loading: false,
    fullPageLoading: false
  },
  mutations: {
    [LOADING](state, loading) {
      state.loading = loading;

      if (loading === true) {
        NProgress.start();
      } else {
        NProgress.done();
        NProgress.remove();
      }
    },
    [FULL_PAGE_LOADING](state, fullPageLoading) {
      state.fullPageLoading = fullPageLoading;

      if (fullPageLoading === true) {
        NProgress.start();
      } else {
        NProgress.done();
        NProgress.remove();
      }
    }
  },
  modules: {
    auth,
    users
  }
});
