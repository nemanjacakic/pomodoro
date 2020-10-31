export default {
  methods: {
    formatTime(time) {
      return time.replace(/^00:/, '');
    },
    subtractTime(timeA, timeB) {
      let [hoursA, minutesA, secondsA] = timeA.split(':');
      let [hoursB, minutesB, secondsB] = timeB.split(':');

      let numberOfHoursA = Number(hoursA);
      let numberOfMinutesA = Number(minutesA);
      let numberOfSecondsA = Number(secondsA);

      let numberOfHoursB = Number(hoursB);
      let numberOfMinutesB = Number(minutesB);
      let numberOfSecondsB = Number(secondsB);

      if ( numberOfHoursB > numberOfHoursA) {
        throw new Error('Can\'t subtract more time from less');
        return false;
      } if (numberOfHoursB === numberOfHoursA && numberOfMinutesB > numberOfMinutesA) {
        throw new Error('Can\'t subtract more time from less');
        return false;
      } else if (numberOfHoursB === numberOfHoursA && numberOfMinutesB === numberOfMinutesA && numberOfSecondsB > numberOfSecondsA) {
        throw new Error('Can\'t subtract more time from less');
        return false;
      }

      if (numberOfSecondsB > numberOfSecondsA) {

        if ( numberOfMinutesA === 0 ) {
          numberOfHoursA -= 1;
          numberOfMinutesA += 60;
        }

        numberOfMinutesA -= 1;
        numberOfSecondsA += 60;
      }

      if (numberOfMinutesB > numberOfMinutesA) {
          numberOfHoursA -= 1;
          numberOfMinutesA += 60;
      }

      return String(numberOfHoursA - numberOfHoursB).padStart(2, '0') + ":" + String(numberOfMinutesA - numberOfMinutesB).padStart(2, '0') + ":" + String(numberOfSecondsA - numberOfSecondsB).padStart(2, '0');

    }
  }
};
