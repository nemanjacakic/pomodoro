<template>
  <div>
    <div class="crud-form card mt-3">
      <div class="card-header">
        <h3 class="card-title">Settings</h3>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <FormErrors :errors="errors" />
        <h4 class="mb-3">Timers:</h4>
        <div class="form-group" v-for="timer in timers" :key="timer.id">
          <div class="row">
            <div class="col-md-6">
            <input class="form-control" type="text" v-model="timer.name">
            </div>
            <div class="col-md-6">
              <!-- <input class="form-control" type="text" v-model="timer.duration"> -->
              <VueTimepicker format="HH:mm:ss" v-model="timer.duration"></VueTimepicker>
            </div>
          </div>
        </div>
      </div> <!-- /.card-body -->

      <div class="card-body">
        <h4 class="mb-3">Notifications:</h4>
          <div class="form-group">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" v-model="settings['showNotifications']">
              <label class="form-check-label">Show notifications</label>
            </div>
          </div>
      </div> <!-- /.card-body -->

      <div class="card-body">
        <h4 class="mb-3">Sound:</h4>
          <div class="form-group">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" v-model="settings['timerSoundEnabled']">
              <label class="form-check-label">Sound enabled</label>
            </div>
          </div>
          <div class="form-group">
            <label>Select sound</label>
            <select class="form-control" v-model="settings['timerSound']">
              <option v-for="sound in timerSounds" :key="sound.id" :value="sound.path">{{ sound.name }}</option>
            </select>
            <button type="button" class="btn btn-info mt-2" @click="playSelectedSound">Play sound</button>
          </div>
      </div> <!-- /.card-body -->
      <!-- form start -->
      <form @submit.prevent="updateSettingsModal" role="form">
        <div class="card-footer">
          <button type="submit" class="btn btn-primary">Update</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import { mapState, mapMutations, mapActions } from "vuex";

import { FULL_PAGE_LOADING, LOADING } from "~/store/mutation-types";
import VueTimepicker from 'vue2-timepicker/src/vue-timepicker.vue';

import axios from "axios";

import { playSound } from "~/helpers";

export default {
  data() {
    return {
      errors: {}
    }
  },
  components: {
    VueTimepicker
  },
  mounted() {
    let queries = [ this.getAllTimerSounds() ];

    if ( this.timers.length === 0 ) {
      queries.push(this.getAll());
    }

    if ( this.settings.length === 0 ) {
      queries.push(this.getAllSettings());
    }

    this.LOADING(true);
    Promise.all(queries)
        .then(() => {
          this.LOADING(false);
        })
        .catch(() => {
           this.LOADING(false);
        });
  },
  computed: {
    ...mapState("timers", ["timers"]),
    ...mapState("settings", ["settings"]),
    ...mapState("timerSounds", ["timerSounds"])
  },
  methods: {
    ...mapMutations([LOADING, FULL_PAGE_LOADING]),
    ...mapActions("timers", ["getAll"]),
    ...mapActions("settings", { getAllSettings: "getAll", updateSettings: "update" }),
    ...mapActions("timerSounds", { getAllTimerSounds: "getAll" }),
    playSelectedSound() {
      playSound(this.settings['timerSound']);
    },
    updateSettingsModal() {
      this.LOADING(true);

      axios.patch('/settings-modal', {
        timers: this.timers,
        settings: this.settings
      }).then(() => {
          this.LOADING(false);

          this.$alertify.success(
            "Settings updated"
          );
      }).catch(({ response }) => {
          this.LOADING(false);

          this.errors = response.data.errors;
      });
    }
  }
};
</script>
