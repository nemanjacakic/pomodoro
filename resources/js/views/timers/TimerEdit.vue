<template>
  <div class="crud-form card mt-3">
    <div class="card-header">
      <h3 class="card-title">Update Timer</h3>
    </div>
    <!-- /.card-header -->

    <!-- form start -->
    <form @submit.prevent="updateTimer" role="form" v-show="!loading">
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
        timer: {
          id: "",
          name: "",
          duration: "",
          order: ""
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
    this.loading = true;
    this.get(this.id)
      .then((timer) => {
        this.timer.id = timer.id;
        this.timer.name = timer.name;
        this.timer.duration = timer.duration;
        this.timer.order = timer.order;

        //console.log();

        this.loading = false;
      })
      .catch(() => this.loading = false);
    },
  methods: {
    ...mapMutations([LOADING]),
    ...mapActions("timers", ["get", "update"]),
    updateTimer() {
      this.LOADING(true);

      this.update(this.timer)
        .then(() => {
          this.LOADING(false);

          this.$alertify.success("Timer updated");

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
