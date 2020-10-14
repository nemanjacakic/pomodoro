import timers from "~/api/timers.js";

import {
  SET_TIMERS,
} from "~/store/mutation-types";

const store = {
  namespaced: true,
  state: {
    timers: [],
  },
  mutations: {
    [SET_TIMERS](state, timers) {
      state.timers = timers;
    },
  },
  actions: {
    getAll({ commit }) {
      return timers
        .getAll()
        .then(data => {
          commit(SET_TIMERS, data);

          return data;
        })
        .catch(error => {
          return Promise.reject(error);
        });
    }
  }
};

export default store;
