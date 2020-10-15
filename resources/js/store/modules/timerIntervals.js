import timerIntervals from "~/api/timerIntervals.js";

import {
  SET_TIMER_INTERVALS,
  REMOVE_TIMER_INTERVALS
} from "~/store/mutation-types";

const store = {
  namespaced: true,
  state: {
    timerIntervals: []
  },
  mutations: {
    [SET_TIMER_INTERVALS](state, timerIntervals) {
      state.timerIntervals = timerIntervals;
    },
    [REMOVE_TIMER_INTERVALS](state, id) {
      state.timerIntervals = state.timerIntervals.filter(page => id !== page.id);
    }
  },
  actions: {
    getAll({ commit }) {
      return timerIntervals
        .getAll()
        .then(data => {
          commit(SET_TIMER_INTERVALS, data);

          return data;
        })
        .catch(error => {
          return Promise.reject(error);
        });
    },
    store({}, intervals) {
      return timerIntervals
        .store(intervals)
          .then(data => {
            return data;
          })
          .catch(error => {
            return Promise.reject(error);
          });
    },
    destroy({ commit }, id) {
      return timerIntervals
        .destroy(id)
        .then(data => {
          commit(REMOVE_TIMER_INTERVALS, id);

          return data;
        })
        .catch(error => {
          return Promise.reject(error);
        });
    }
  }
};

export default store;
