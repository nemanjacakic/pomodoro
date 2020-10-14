import settings from "~/api/settings.js";

import {
  SET_SETTINGS,
} from "~/store/mutation-types";


const store = {
  namespaced: true,
  state: {
    settings: [],
  },
  mutations: {
    [SET_SETTINGS](state, settings) {
      state.settings = settings;
    },
  },
  actions: {
    getAll({ commit }) {
      return settings
        .getAll()
        .then(data => {
          commit(SET_SETTINGS, data);

          return data;
        })
        .catch(error => {
          return Promise.reject(error);
        });
    },
    get({}, key) {
      return settings
        .get(key)
        .then(data => {
          return data;
        })
        .catch(error => {
          return Promise.reject(error);
        });
    },
    update({}, data) {
      return settings
        .update(data)
        .then(data => {
          return data;
        })
        .catch(error => {
          return Promise.reject(error);
        });
    }
  }
};

export default store;
