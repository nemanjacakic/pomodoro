<template>
  <div class="crud-form card mt-3">
    <div class="card-header">
      <h3 class="card-title">Update Interval Manually</h3>
    </div>
    <!-- /.card-header -->

    <!-- form start -->
    <form @submit.prevent="updateTimerInterval" role="form" v-show="!loading">
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
        <button type="submit" class="btn btn-primary">Update</button>
      </div>
    </form>


    <Loader v-show="loading"/>
  </div>

  <!-- /.card -->
</template>

<script>
import { mapMutations, mapActions, mapState } from "vuex";

import { LOADING } from "~/store/mutation-types";

import VueTimepicker from 'vue2-timepicker/src/vue-timepicker.vue';
import Loader from "~/components/Loader";

  export default {
    props: {
      id: Number
    },
    data() {
      return {
        interval: {
          id: "",
          timer_id: null,
          title: "",
          duration: "",
        },
        errors: {},
        loading: false
      };
    },
    components: {
      Loader,
      VueTimepicker
    },
    mounted() {
      let queries = [ this.get(this.id) ];

      if ( this.timers.length === 0 ) {
        queries.push(this.getAllTimers());
      }

    this.loading = true;
    Promise.all(queries)
      .then(([interval]) => {
        if ( interval.timer !== null ) {
            this.interval.timer_id = interval.timer.id;
        }

        this.interval.id = interval.id;
        this.interval.title = interval.title;
        this.interval.duration = interval.duration;

        this.loading = false;
      })
      .catch(() => this.loading = false);
    },
  computed: {
    ...mapState("timers", ["timers"]),
  },
  methods: {
    ...mapMutations([LOADING]),
    ...mapActions("timers", { getAllTimers: "getAll" }),
    ...mapActions("timerIntervals", ["get", "update"]),
    updateTimerInterval() {
      this.LOADING(true);

      this.update(this.interval)
        .then(() => {
          this.LOADING(false);

          this.$alertify.success("Interval updated");

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
