<style lang="scss" scoped></style>

<template>
  <div class="login-page">
    <div class="login-box">
      <div class="login-logo">
        <a href="#"><b>ADMIN</b></a>
      </div>

      <div class="card">
        <div class="card-body login-card-body">
          <p class="login-box-msg">Sign in</p>

          <div class="callout callout-danger" v-if="error">
            <p>{{ error }}</p>
          </div>

          <form @submit.prevent="loginUser">
            <div class="input-group mb-3">
              <input
                type="email"
                class="form-control"
                placeholder="Email"
                v-model="email"
              />
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-envelope"></span>
                </div>
              </div>
            </div>
            <div class="input-group mb-3">
              <input
                type="password"
                class="form-control"
                placeholder="Password"
                v-model="password"
              />
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-lock"></span>
                </div>
              </div>
            </div>
            <div class="form-group">
                <div class="form-check text-center">
                    <input class="form-check-input" type="checkbox" v-model="remember">
                    <label class="form-check-label">Remember me</label>
                </div>
            </div>
            <div class="row">
              <!-- /.col -->
              <div class="col-12">
                <button
                  type="submit"
                  class="btn btn-primary btn-block btn-flat"
                >
                  Sign In
                </button>
              </div>
              <!-- /.col -->
            </div>
          </form>
        </div>
        <!-- /.login-card-body -->
      </div>
    </div>
    <!-- /.login-box -->
  </div>
</template>

<script>
import { mapState, mapActions } from "vuex";

import Notification from "laravel-file-manager/src/components/blocks/Notification";

export default {
  data() {
    return {
      email: "",
      password: "",
      remember: "",
      error: false
    };
  },
  computed: {
    ...mapState("auth", ["user"])
  },
  components: {
    Notification
  },
  methods: {
    ...mapActions("auth", ["login"]),
    loginUser() {
      this.error = "";

      this.login({ email: this.email, password: this.password, remember: this.remember })
        .then(() =>
          this.$alertify.success(
            "Welcome " + this.user.first_name + " " + this.user.last_name
          )
        )
        .catch(() => {
          this.error = "Email or password is wrong";
        });
    }
  }
};
</script>
