<template>
  <div class="crud-form card mt-3">
    <div class="card-header">
      <h3 class="card-title">Add Timer</h3>
    </div>
    <!-- /.card-header -->

    <!-- form start -->
    <form @submit.prevent="createTimer" role="form">
      <div class="card-body">
        <FormErrors :errors="errors" />
        <div class="form-group">
          <label>Name:</label>
          <input
            v-model="timer.name"
            type="text"
            class="form-control"
            placeholder="Name"
          />
        </div>
        <div class="form-group">
          <label>Duration:</label>

          <div><VueTimepicker format="HH:mm:ss" input-class="form-control--timepicker" v-model="timer.duration"></VueTimepicker></div>
        </div>
        <div class="form-group">
          <label>Order:</label>
          <input
            v-model="timer.order"
            type="text"
            class="form-control"
            placeholder="Order"
          />
        </div>
      </div>
      <!-- /.card-body -->

      <div class="card-footer">
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
    </form>
  </div>
  <!-- /.card -->
</template>

<script>
import { mapMutations, mapActions, mapState } from "vuex";

import { FULL_PAGE_LOADING, LOADING } from "~/store/mutation-types";

import VueTimepicker from 'vue2-timepicker/src/vue-timepicker.vue';

export default {
  data() {
    return {
      timer: {
        name: "",
        duration: "",
        order: ""
      },
      errors: {}
    };
  },
  components: {
    VueTimepicker
  },
  methods: {
    ...mapMutations([LOADING, FULL_PAGE_LOADING]),
    ...mapActions("timers", ["store"]),
    createTimer() {
      this.store(this.timer)
        .then(() => {
          this.LOADING(false);

          this.$alertify.success("Timer created");

          this.$emit('close');
        })
        .catch(data => {
          this.LOADING(false);

          this.errors = data.errors;
        });
    }
  }
};
</script>
