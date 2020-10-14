import timerIntervals from "~/api/timerIntervals.js";

const store = {
  namespaced: true,
  state: {},
  mutations: {
  },
  actions: {
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
  }
};

export default store;
