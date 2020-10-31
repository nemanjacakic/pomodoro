<template>
  <div class="crud-form card mt-3">
    <div class="card-header">
      <h3 class="card-title">Add Interval Manually</h3>
    </div>
    <!-- /.card-header -->

    <!-- form start -->
    <form @submit.prevent="createTimerInterval" role="form">
      <div class="card-body">
        <FormErrors :errors="errors" />
          <div class="form-group">
            <label>Select timer</label>
            <select class="form-control" v-model="interval.timer_id">
              <option :value="null"></option>
              <option v-for="timers in timers" :key="timers.id" :value="timers.id">{{ timers.name }}</option>
            </select>
          </div>
        <div class="form-group">
          <label>Title:</label>
          <input
            v-model="interval.title"
            type="text"
            class="form-control"
            placeholder="Title"
          />
        </div>
        <div class="form-group">
          <label>Duration:</label>

          <div><VueTimepicker format="HH:mm:ss" input-class="form-control--timepicker" v-model="interval.duration"></VueTimepicker></div>
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
      interval: {
        timer_id: null,
        title: "",
        duration: "",
      },
      errors: {}
    };
  },
  components: {
    VueTimepicker
  },
  mounted() {
    if ( this.timers.length === 0 ) {
      this.getAllTimers();
    }
  },
  computed: {
    ...mapState("timers", ["timers"]),
  },
  methods: {
    ...mapMutations([LOADING, FULL_PAGE_LOADING]),
    ...mapActions("timers", { getAllTimers: "getAll" }),
    ...mapActions("timerIntervals", ["store"]),
    createTimerInterval() {
      this.store(this.interval)
        .then(() => {
          this.LOADING(false);

          this.$alertify.success("Interval created");

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
