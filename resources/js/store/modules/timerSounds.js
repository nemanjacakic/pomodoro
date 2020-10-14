import timerSounds from "~/api/timerSounds.js";

import {
  SET_TIMER_SOUNDS,
} from "~/store/mutation-types";

const store = {
  namespaced: true,
  state: {
    timerSounds: [],
  },
  mutations: {
    [SET_TIMER_SOUNDS](state, timerSounds) {
      state.timerSounds = timerSounds;
    },
  },
  actions: {
    getAll({ commit }) {
      return timerSounds
        .getAll()
        .then(data => {
          commit(SET_TIMER_SOUNDS, data);

          return data;
        })
        .catch(error => {
          return Promise.reject(error);
        });
    }
  }
};

export default store;
