import auth from "~/api/auth.js";
import router from "~/router/router";

import {
  LOADING,
  LOGIN_USER,
  LOGOUT_USER,
  SET_USER,
  VERIFY_USER
} from "~/store/mutation-types";

const store = {
  namespaced: true,
  state: {
    user: false,
    loggedIn: false,
    error: false
  },
  getters: {
    user: state => state.user,
    isLoggedIn: state => state.loggedIn,
    isVerified: state => state.user.email_verified_at !== null
  },
  mutations: {
    [LOGIN_USER](state, data) {
      state.loggedIn = true;
      state.user = data.user;
    },
    [LOGOUT_USER](state) {
      state.loggedIn = false;
      state.user = false;
    },
    [SET_USER](state, user) {
      state.loggedIn = true;
      state.user = user;
    },
    [VERIFY_USER](state, email_verified_at) {
      state.user.email_verified_at = email_verified_at;
    }
  },
  actions: {
    login({ commit }, { email, password, remember }) {
      commit(LOADING, true, { root: true });
      return auth
        .login(email, password, remember)
        .then(data => {
          commit(LOGIN_USER, data);

          router.push({ name: "dashboard" });

          commit(LOADING, false, { root: true });
        })
        .catch(error => {
          commit(LOADING, false, { root: true });

          return Promise.reject(error);
        });
    },
    logout({ commit }) {
      commit(LOADING, true, { root: true });

      return auth.logout().then(() => {
        commit(LOGOUT_USER);

        router.push({ name: "login" });

        commit(LOADING, false, { root: true });
      });
    },
    setUser({ commit }) {
      return new Promise((resolve, reject) => {
        return auth
          .getUser()
          .then(data => {
            commit(SET_USER, data);

            return resolve(data);
          })
          .catch(response => {
            commit(LOGOUT_USER);

            return reject(response);
          });
      });
    }
  }
};

export default store;
