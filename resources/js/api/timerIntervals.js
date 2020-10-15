import axios from "axios";

export default {
  getAll() {
    return axios
      .get("timer-intervals")
      .then(({ data }) => {
        return data.data;
      })
      .catch(error => {
        return Promise.reject(error);
      });
  },
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
  },
  destroy(id) {
    return axios
      .delete("timer-intervals/" + id)
      .then(({ data }) => {
        return data.data;
      })
      .catch(({ response }) => {
        return Promise.reject(response.data.error);
      });
  }
};
