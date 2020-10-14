import axios from "axios";

export default {
  store(intervals) {
    return axios
      .post("timer-intervals", {
        intervals
      })
      .then(({ data }) => {
        return data.data;
      })
      .catch(error => {
        return Promise.reject(error);
      });
  }
};
