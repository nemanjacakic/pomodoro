import timerIntervals from "~/api/timerIntervals.js";

import {
  SET_TIMER_INTERVALS,
  ADD_TIMER_INTERVAL,
  UPDATE_TIMER_INTERVAL,
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
    [ADD_TIMER_INTERVAL](state, interval){
      state.timerIntervals.unshift(interval);
    },
    [UPDATE_TIMER_INTERVAL](state, updatedTimerInterval) {
      state.timerIntervals = state.timerIntervals.map(timerInterval =>
        timerInterval.id === updatedTimerInterval.id ? updatedTimerInterval : timerInterval
      );
    },
    [REMOVE_TIMER_INTERVALS](state, id) {
      state.timerIntervals = state.timerIntervals.filter(page => id !== page.id);
    }
  },
  actions: {
    get({}, id) {
      return timerIntervals
        .get(id)
        .then(data => {
          return data;
        })
        .catch(error => {
          return Promise.reject(error);
        });
    },
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
    store({ commit }, data) {
      return timerIntervals
        .store(data)
          .then(response => {
            if ( !Array.isArray(response) ) {
              commit(ADD_TIMER_INTERVAL, response);
            }

            return response;
          })
          .catch(({ response })  => {
            return Promise.reject(response.data);
          });
    },
    update({ commit }, timerInterval) {
      return timerIntervals
        .update(timerInterval)
        .then(response => {
          commit(UPDATE_TIMER_INTERVAL, response);

          return response;
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
