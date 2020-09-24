<template>
  <button @click="logout" class="btn btn-danger btn-flat">Sign out</button>
</template>

<script>
import { mapActions } from "vuex";

export default {
  methods: {
    ...mapActions("auth", ["logout"])
  }
};
</script>
