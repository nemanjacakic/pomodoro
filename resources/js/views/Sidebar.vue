<template>
  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
      <img
        src="../assets/AdminLogo.png"
        alt="Admin Logo"
        class="brand-image img-circle elevation-3"
        style="opacity: .8"
      />
      <span class="brand-text font-weight-light">Admin</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img
            :src="user.avatar"
            class="img-circle elevation-2"
            alt="User Image"
          />
        </div>
        <div class="info">
          <router-link
            :to="{ name: 'users.edit', params: { id: user.id } }"
            class="d-block"
          >
            {{ user.first_name + " " + user.last_name }}</router-link
          >
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul
          class="nav nav-pills nav-sidebar flex-column"
          data-widget="treeview"
          role="menu"
          data-accordion="false"
        >
          <li class="nav-item">
            <router-link :to="{ name: 'dashboard' }" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link :to="{ name: 'timerIntervals.list' }" class="nav-link">
              <i class="far fa-calendar-alt"></i>
              <p>
                Timer Intervals
              </p>
            </router-link>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
</template>

<script>
import { mapGetters } from "vuex";

export default {
  computed: {
    ...mapGetters("auth", ["user"])
  }
};
</script>
