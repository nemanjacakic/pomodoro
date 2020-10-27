import axios from "axios";

export default {
  get(id) {
    return axios
      .get("timers/" + id)
      .then(({ data }) => {
        return data.data;
      })
      .catch(error => {
        return Promise.reject(error);
      });
  },
  getAll() {
    return axios
      .get("timers")
      .then(({ data }) => {
        return data.data;
      })
      .catch(error => {
        return Promise.reject(error);
      });
  },
  store({...data}) {
    return axios
      .post("timers", data)
      .then(({ data }) => {
        return data.data;
      })
      .catch(error => {
        return Promise.reject(error);
      });
  },
  update({ id, ...data }) {
    return axios
      .put("timers/" + id, data)
      .then(({ data }) => {
        return data.data;
      })
      .catch(error => {
        return Promise.reject(error);
      });
  },
  destroy(id) {
    return axios
      .delete("timers/" + id)
      .then(({ data }) => {
        return data.data;
      })
      .catch(({ response }) => {
        return Promise.reject(response.data.error);
      });
  }
};
