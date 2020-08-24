<template lang="html">
  <div class="Timepad">
      <input v-if="hasSelection" type="hidden" name="minutes" v-bind:value="this.selection">
      <input v-if="hasSelection" type="hidden" name="rest-of-day" v-bind:value="this.gone_for_the_day">
      <h2 class="util-instruction-heading">How long will you be gone for?</h2>
      <div v-bind:class="{'Timepad__selection': true, 'is-active': hasSelection}"><span v-if="hasSelection">{{ humanizedTime }}</span></div>
      <div class="Timepad__grid">
          <div class="Timepad__box">
              <div v-tap v-on:click="updateSelection(5)" class="Timepad__label is-active">+5 mins</div>
          </div>
          <div class="Timepad__box">
              <div v-tap v-on:click="updateSelection(30)" class="Timepad__label is-active">+30 mins</div>
          </div>
          <div class="Timepad__box">
              <div v-tap v-on:click="updateSelection(60)" class="Timepad__label is-active">+1 hour</div>
          </div>
          <div class="Timepad__box">
              <div v-tap v-on:click="selectRestOfTheDay()" class="Timepad__label is-active">Rest of the day</div>
          </div>
          <div class="Timepad__box">
              <div v-tap v-on:click="updateSelection(-5)" v-bind:class="{'Timepad__label': true, 'is-active': hasSelection}">-5 mins</div>
          </div>
          <div class="Timepad__box">
              <div v-tap v-on:click="updateSelection(-30)" v-bind:class="{'Timepad__label': true, 'is-active': hasSelection}">-30 mins</div>
          </div>
          <div class="Timepad__box">
              <div v-tap v-on:click="updateSelection(-60)" v-bind:class="{'Timepad__label': true, 'is-active': hasSelection}">-1 hour</div>
          </div>
          <div class="Timepad__box">
              <div v-tap v-on:click="clearSelection()" v-bind:class="{'Timepad__label': true, 'Timepad__label--clear': true, 'is-active': hasSelection}">Clear</div>
          </div>
      </div>
  </div>
</template>

<script>
export default {
    data() {
        return {
            selection: 0,
            gone_for_the_day: false,
        };
    },

    computed: {
        hasSelection() {
            return this.selection > 0 || this.gone_for_the_day;
        },

        humanizedTime() {
            return humanizeMinutes(this.selection, this.gone_for_the_day);
        },
    },

    methods: {
        clearSelection() {
            this.selection = 0;
            this.gone_for_the_day = false;
        },

        updateSelection(amount) {
            if (this.gone_for_the_day) {
                this.gone_for_the_day = false;
                this.selection = 0;
            }
            this.selection = this.selection + amount;
        },

        selectRestOfTheDay() {
            this.gone_for_the_day = true;
            this.selection = 0;
        },
    },
};

const humanizeMinutes = function humanizeMinutes(minutes, gone_for_the_day) {
    if (gone_for_the_day) return 'Rest of the day';

    const hours = Math.floor(minutes / 60);

    if (hours >= 1) {
        const label = hours === 1 ? 'hour' : 'hours';
        return toHoursAndMinutes(label, hours, minutes - hours * 60);
    }

    return `${minutes} minutes`;
};

const toHoursAndMinutes = function toHoursAndMinutes(label, hours, minutes) {
    if (minutes === 0) {
        return `${hours} ${label}`;
    }

    return `${hours} ${label} and ${minutes} mins`;
};
</script>
