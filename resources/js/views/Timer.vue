<template>
<div class="row pomodoro">
  <div class="timer col-md-9">
      <div class="timer-sound">
          <i
            class="fas"
            :class="{
                'fa-volume-up': settings['timerSoundEnabled'],
                'fa-volume-mute': !settings['timerSoundEnabled']
            }"
            @click="toggleSound()"
            ></i>
      </div>
    <div class="timer__time">
        {{ formatTime(activeTimer.timeLeft) }}
    </div>

      <div class="form-group timer__title">
          <label for="timer-title">Title</label>
    <input type="text" class="form-control" name="timer-title" v-model="activeTimer.title">
    </div>
    <div class="timer__buttons">
        <button type="button" class="timer__btn btn btn-lg btn-primary" :disabled="timerIsOn" @click="startTimer()">Start</button>
        <button type="button" class="timer__btn btn btn-lg btn-success" :disabled="timerIsOn || activeTimer.duration === activeTimer.timeLeft" @click="saveCurrentTimer()">Save</button>
        <button type="button" class="timer__btn btn btn-lg btn-secondary" :disabled="timerIsOff" @click="stopTimer()">Pause</button>
        <button type="button" class="timer__btn btn btn-lg btn-danger" :disabled="timerIsOff && activeTimer.duration === activeTimer.timeLeft" @click="resetTimer()">Reset</button>
    </div>

    <div class="mt-4 btn-group btn-group-toggle">
        <button type="button" class="btn btn-info" :disabled="timerIsOn" @click="setActiveTimer(timer)" :title="timer.duration" v-for="(timer, index) in timers" :key="index">{{ timer.name }}</button>
    </div>

  </div>

<div class="timer-interval-list col-md-3">
    <h3>Intervals finished:</h3>
    <ul class="list-unstyled">
        <li v-for="(interval, index) in timerIntervals" :key="index"><i @click="removeTimerInterval(index)" class="fas fa-times-circle mr-2"></i>{{ interval.type }} : {{ interval.duration }} <span v-if="interval.title !== ''">{{ interval.title }}</span></li>
    </ul>

    <button v-if="timerIntervals.length > 0" type="button" class="btn btn-success" @click="createTimerIntervals()">Save</button>
    <button v-if="timerIntervals.length > 0" type="button" class="btn btn-danger" @click="clearUnsavedTimerIntervals()">Clear</button>
</div>
  </div>
</template>

<script>

import {
  mapState,
  mapMutations,
  mapActions
} from "vuex";

import {
  FULL_PAGE_LOADING,
  LOADING
} from "~/store/mutation-types";

import WebPush from "~/services/webpush";

import time from "~/mixins/time";

const TIMER_INTERVALS = 'timer-intervals';

export default {
  data() {
    return {
      timerIntervals: [],
      timer: null,
      activeTimer: {
        type: "",
        duration: "",
        title: "",
        timeLeft: ""
      },
      timerSound: null,
      unwatchTimerSoundChange: null,
      notification: {
        title: 'Timer finished!',
      },
      oldPageTitle: ''
    }
  },
  mixins: [
      time
  ],
  mounted() {
    this.oldPageTitle = document.title;

    this.unwatchTimerSoundChange = this.$store.watch((state, getters) => state.settings.settings.timerSound, (newValue, oldValue) => {
        this.timerSound = new Audio(this.settings['timerSound']);
      },
    );

    this.loadUnsavedTimerIntervals();

    this.FULL_PAGE_LOADING(true);

    Promise.all([ this.getAll(), this.getAllSettings() ])
      .then(([ timers, settings ]) => {
        this.setActiveTimer(this.timers[0]);

        this.FULL_PAGE_LOADING(false);

        if ( WebPush.hasBrowserSupport() ) {
          WebPush.registerServiceWorker('/service-worker.js').then( () => {
              WebPush.getNotificationPermissionState().then((permissionState) => {
                if ( !WebPush.permissionIsGranted(permissionState)) {
                  WebPush.askPermission();
                }
              });
          });
        }
    }).catch(() => this.FULL_PAGE_LOADING(false));
  },
  beforeDestroy() {
    this.unwatchTimerSoundChange();
  },
  computed: {
    ...mapState("timers", ["timers"]),
    ...mapState("settings", ["settings"]),
    timerIsOn: function () {
      return this.timer !== null;
    },
    timerIsOff: function () {
      return this.timer === null;
    },
  },
  methods: {
    ...mapMutations([LOADING, FULL_PAGE_LOADING]),
    ...mapActions("timers", ["getAll"]),
    ...mapActions("timerIntervals", ["store"]),
    ...mapActions("settings", { getAllSettings: "getAll", updateSettings: "update" }),
    toggleSound(){
      this.settings['timerSoundEnabled'] = !this.settings['timerSoundEnabled'];

      this.updateSettings({
        timerSoundEnabled: this.settings['timerSoundEnabled']
      });
    },
    setActiveTimer(timer) {
      this.activeTimer.timerID = timer.id;
      this.activeTimer.type = timer.name;
      this.activeTimer.duration = timer.duration;
      this.activeTimer.timeLeft = timer.duration;
    },
    startTimer() {
      document.title = this.activeTimer.timeLeft;

      if ( this.countdownNotFinished() ) {
        this.timer = setInterval(() => {
          this.countDown();

          document.title = this.activeTimer.timeLeft;

          if (this.countdownFinished()) {
            this.saveTimerIntervalsLocaly();

            this.resetTimer();

            if (this.settings['showNotifications']) {
              WebPush.showNotification(this.notification.title, this.notification.options);
            }

            if (this.settings['timerSoundEnabled']) {
              this.timerSound.play();
            }
          }
        }, 1000);
      }

    },
    saveCurrentTimer() {
          this.saveTimerIntervalsLocaly();

          this.resetTimer();
    },
    stopTimer() {
      clearInterval(this.timer);

      this.timer = null;
    },
    resetTimer() {
      document.title = this.oldPageTitle;

      if (this.timerIsOn) {
        this.stopTimer();
      }

      this.activeTimer.timeLeft = this.activeTimer.duration;
    },
    countDown() {
      this.activeTimer.timeLeft = this.subtractTime(this.activeTimer.timeLeft, "00:00:01");
    },
    countdownFinished() {
      return this.activeTimer.timeLeft === "00:00:00";
    },
    countdownNotFinished() {
      return this.activeTimer.timeLeft !== "00:00:00";
    },
    loadUnsavedTimerIntervals() {
      let unsavedPomodors = localStorage.getItem(TIMER_INTERVALS);

      if (unsavedPomodors !== null) {
        this.timerIntervals = JSON.parse(unsavedPomodors);
      }

    },
    removeTimerInterval(indexToRemove) {
      this.timerIntervals = this.timerIntervals.filter((el, index) => index !== indexToRemove);

      localStorage.setItem(TIMER_INTERVALS, JSON.stringify(this.timerIntervals));
    },
    clearUnsavedTimerIntervals() {
      this.$alertify.confirmWithTitle(
        "Are you sure ?",
        "This will delete all unsaved timer intervals",
        () => {
          this.removeLocalTimerIntervals();
        },
        () => {}
      );
    },
    removeLocalTimerIntervals() {
      localStorage.removeItem(TIMER_INTERVALS);
      this.timerIntervals = [];
    },
    saveTimerIntervalsLocaly() {
      this.timerIntervals.push({
        timer_id: this.activeTimer.timerID,
        type: this.activeTimer.type,
        title: this.activeTimer.title,
        duration: this.subtractTime(this.activeTimer.duration, this.activeTimer.timeLeft)
      });

      localStorage.setItem(TIMER_INTERVALS, JSON.stringify(this.timerIntervals));
    },
    createTimerIntervals() {
      this.store(this.timerIntervals)
        .then(() => {
          this.removeLocalTimerIntervals();

          this.$alertify.success("Timer intervals saved");
        })
        .catch(data => {
          this.errors = data.errors;
        });
    }
  }
};
</script>
