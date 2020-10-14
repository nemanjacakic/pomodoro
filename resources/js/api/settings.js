import axios from "axios";

export default {
  get(field) {
    return axios
      .get("settings/" + field)
      .then(({ data }) => {
        return data.data;
      })
      .catch(error => {
        return Promise.reject(error);
      });
  },
  getAll() {
    return axios
      .get("settings")
      .then(({ data }) => {
        return data.data;
      })
      .catch(error => {
        return Promise.reject(error);
      });
  },
  update(settings) {
    return axios
      .patch("settings", settings)
      .then(({ data }) => {
        return data.data;
      })
      .catch(({ response }) => {
        return Promise.reject(response.data);
      });
  }
};
