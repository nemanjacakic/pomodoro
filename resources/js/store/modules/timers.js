import timers from "~/api/timers.js";

import {
  SET_TIMERS,
  ADD_TIMER,
  UPDATE_TIMER,
  REMOVE_TIMER,
  SORT_TIMERS
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
    [SORT_TIMERS](state) {
      state.timers = state.timers.sort( (a, b) => {
        return a.order - b.order;
      } );
    },
    [ADD_TIMER](state, timer){
      state.timers.unshift(timer);
    },
    [UPDATE_TIMER](state, updatedTimer) {
      state.timers = state.timers.map(timer =>
        timer.id === updatedTimer.id ? updatedTimer : timer
      );
    },
    [REMOVE_TIMER](state, id) {
      state.timers = state.timers.filter(timer => id !== timer.id);
    }
  },
  actions: {
    get({}, id) {
      return timers
        .get(id)
        .then(data => {
          return data;
        })
        .catch(error => {
          return Promise.reject(error);
        });
    },
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
    },
    store({ commit }, data) {
      return timers
        .store(data)
          .then(response => {
            commit(ADD_TIMER, response);
            commit(SORT_TIMERS);

            return response;
          })
          .catch(({ response })  => {
            return Promise.reject(response.data);
          });
    },
    update({ commit }, timer) {
      return timers
        .update(timer)
        .then(response => {
          commit(UPDATE_TIMER, response);
          commit(SORT_TIMERS);

          return response;
        })
        .catch(error => {
          return Promise.reject(error);
        });
    },
    destroy({ commit }, id) {
      return timers
        .destroy(id)
        .then(response => {
          commit(REMOVE_TIMER, id);

          return response;
        })
        .catch(error => {
          return Promise.reject(error);
        });
    }
  }
};

export default store;
