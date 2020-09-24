<template>
  <div class="crud-form card mt-3">
    <div class="card-header">
      <h3 class="card-title">Edit Profile</h3>
    </div>
    <!-- /.card-header -->

    <!-- form start -->
    <form @submit.prevent="updateUser" role="form">
      <div class="card-body">
        <FormErrors :errors="errors" />
        <div class="form-group">
          <label>First Name:</label>
          <input
            v-model="user.first_name"
            type="text"
            class="form-control"
            placeholder="First Name"
          />
        </div>
        <div class="form-group">
          <label>Last Name:</label>
          <input
            v-model="user.last_name"
            type="text"
            class="form-control"
            placeholder="Last Name"
          />
        </div>
        <div class="form-group">
          <label>Email:</label>
          <input
            type="email"
            class="form-control"
            placeholder="Email"
            v-model="user.email"
          />
        </div>
        <div class="form-group">
          <label>Old Password:</label>
          <input
            v-model="user.old_password"
            type="password"
            class="form-control"
            placeholder="Password"
          />
        </div>
        <div class="form-group">
          <label>New Password:</label>
          <input
            v-model="user.new_password"
            type="password"
            class="form-control"
            placeholder="Password"
          />
        </div>
        <div class="form-group">
          <label>New Password Confirmation:</label>
          <input
            v-model="user.new_password_confirmation"
            type="password"
            class="form-control"
            placeholder="Password Confirmation"
          />
        </div>
        <div class="form-group">
          <label>Bio:</label>
          <textarea
            v-model="user.bio"
            class="form-control"
            rows="10"
            placeholder="Bio"
          ></textarea>
        </div>
      </div>
      <!-- /.card-body -->

      <div class="card-footer">
        <button type="submit" class="btn btn-primary">Update</button>
      </div>
    </form>
  </div>
  <!-- /.card -->
</template>

<script>
import { mapState, mapGetters, mapMutations, mapActions } from "vuex";

import { FULL_PAGE_LOADING, LOADING, SET_USER } from "~/store/mutation-types";

import router from "~/router/router";

export default {
  data() {
    return {
      user: {
        first_name: "",
        last_name: "",
        email: "",
        bio: "",
        old_password: "",
        new_password: "",
        new_password_confirmation: "",
      },
      errors: {}
    };
  },
  mounted() {
    this.FULL_PAGE_LOADING(true);
    this.get(this.$route.params.id).then(data => {
      this.user = data;
          this.FULL_PAGE_LOADING(false);
      })
      .catch(() => this.FULL_PAGE_LOADING(false));
  },
  methods: {
    ...mapMutations([LOADING, FULL_PAGE_LOADING]),
    ...mapMutations("auth", [SET_USER]),
    ...mapActions("users", ["get", "update"]),
    updateUser() {
      this.LOADING(true);

      this.update(this.user)
        .then((user) => {
          this.SET_USER(user);

          this.LOADING(false);

          this.$alertify.success("User updated");

        })
        .catch(data => {
          this.LOADING(false);

          this.errors = data.errors;
        });
    }
  }
};
</script>
