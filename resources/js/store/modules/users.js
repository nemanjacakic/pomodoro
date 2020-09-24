import users from "~/api/users.js";

const store = {
  namespaced: true,
  actions: {
    get({}, id) {
      return users
        .get(id)
        .then(data => {
          return data;
        })
        .catch(error => {

          return Promise.reject(error);
        });
    },
    update({}, user) {
      return users
        .update(user)
        .then(data => {
          return data;
        })
        .catch(error => {
          return Promise.reject(error);
        });
    }
  }
};

export default store;
