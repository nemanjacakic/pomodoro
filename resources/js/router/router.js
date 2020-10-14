import Vue from "vue";
import VueRouter from "vue-router";

import Admin from "~/views/Admin";

import Timer from "~/views/Timer";
import Login from "~/views/auth/Login";

import store from "~/store/store";

import users from "./users";

Vue.use(VueRouter);

const routes = [
  {
    name: "login",
    path: "/admin/login",
    component: Login,
    meta: { requiresGuest: true }
  },
  {
    path: "/admin",
    component: Admin,
    meta: { requiresUser: true },
    children: [
      {
        name: "dashboard",
        path: "dashboard",
        component: Timer
      },
      ...users,
    ]
  }
];

const router = new VueRouter({
  mode: "history",
  routes,
  linkActiveClass: "active"
});

router.beforeEach((to, from, next) => {
  let requiresUser = to.matched.some(record => record.meta.requiresUser);
  let requiresGuest = to.matched.some(record => record.meta.requiresGuest);
  let userLoggedIn = store.getters["auth/isLoggedIn"];

  if ((requiresUser && userLoggedIn) || (requiresGuest && !userLoggedIn)) {
    next();
  } else if (requiresUser && !userLoggedIn) {
    next({
      name: "login"
    });
  } else if (requiresGuest && userLoggedIn) {
    next({
      name: "dashboard"
    });
  }
});

export default router;
