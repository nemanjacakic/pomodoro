<template>
  <header>
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#"
            ><i class="fas fa-bars"></i
          ></a>
        </li>
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <!-- Messages Dropdown Menu -->
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#" @click.prevent="showSettingsModal()">
            <i class="fas fa-cog"></i>
          </a>
        </li>
        <li class="dropdown user user-menu open">
          <a
            href="#"
            class="dropdown-toggle"
            data-toggle="dropdown"
            aria-expanded="true"
          >
            <img :src="user.avatar" class="user-image" alt="User Image" />
            <span class="hidden-xs">{{
              user.first_name + " " + user.last_name
            }}</span>
          </a>
          <ul class="dropdown-menu">
            <!-- User image -->
            <li class="user-header">
              <img :src="user.avatar" class="img-circle" alt="User Image" />

              <p>
                {{ user.first_name + " " + user.last_name }}
                <br />
                {{ user.email }}
              </p>
            </li>
            <!-- Menu Footer-->
            <li class="user-footer">
              <div class="container">
                <div class="row flex-grow-1">
                  <div class="col-sm-6">
                    <router-link
                      :to="{ name: 'users.edit', params: { id: user.id } }"
                      class="btn btn-info btn-flat"
                    >
                      Profile
                    </router-link>
                  </div>
                  <div class="col-sm-6 text-right">
                    <LogoutButton />
                  </div>
                </div>
              </div>
            </li>
          </ul>
        </li>
      </ul>
    </nav>
  </header>
</template>

<script>
import { mapGetters } from "vuex";
import LogoutButton from "~/views/auth/Logout";
import SettingsModal from "~/views/SettingsModal";

export default {
  components: {
    LogoutButton,
    SettingsModal
  },
  computed: {
    ...mapGetters("auth", ["user"])
  },
  methods: {
    showSettingsModal() {
      this.$modal.show(SettingsModal, {}, { width: "80%", height: "auto", pivotY: 0.1, scrollable: true });
    }
  }
};
</script>
