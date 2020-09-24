import axios from "axios";

export default {
  get(id) {
    return axios
      .get("users/" + id)
      .then(({ data }) => {
        return data.data;
      })
      .catch(error => {
        return Promise.reject(error);
      });
  },
  update({
    id,
    first_name,
    last_name,
    email,
    bio,
    old_password,
    new_password,
    new_password_confirmation,
  }) {
    return axios
      .put("users/" + id, {
        first_name,
        last_name,
        email,
        bio,
        old_password,
        new_password,
        new_password_confirmation,
      })
      .then(({ data }) => {
        return data.data;
      })
      .catch(({ response }) => {
        return Promise.reject(response.data);
      });
  }
};
