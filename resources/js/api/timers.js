import axios from "axios";

export default {
  getAll() {
    return axios
      .get("timers")
      .then(({ data }) => {
        return data.data;
      })
      .catch(error => {
        return Promise.reject(error);
      });
  }
};
