import axios from "axios";

export default {
  get(id) {
    return axios
      .get("timer-intervals/" + id)
      .then(({ data }) => {
        return data.data;
      })
      .catch(error => {
        return Promise.reject(error);
      });
  },
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
  store(data) {
    let postData = {};

    if ( Array.isArray(data) ) {
      postData.intervals = data;
    } else {
      postData = { ...data };
    }

    return axios
      .post("timer-intervals", postData)
      .then(({ data }) => {
        return data.data;
      })
      .catch(error => {
        return Promise.reject(error);
      });
  },
  update({ id, ...data }) {
    return axios
      .put("timer-intervals/" + id, data)
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
