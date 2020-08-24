<template lang="html">
    <div class="Status">
        <input v-if="hasActiveStatus" type="hidden" name="status" v-bind:value="activeStatus">
        <h2 class="util-instruction-heading">Where are you going?</h2>
        <div v-bind:class="{'Status__selection': true, 'is-active': hasActiveStatus}"><span v-if="hasActiveStatus">{{ activeStatus }}</span></div>
        <div class="Status__grid">
            <div v-for="status in statuses" class="Status__box">
                <div v-tap v-on:click="updateStatus(status)" v-bind:class="{'Status__label': true, 'is-active': status.active}">{{ status.label }}</div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
  data() {
    return {
      statuses: generateStatuses(),
    };
  },

  computed: {
    hasActiveStatus() {
      return this.statuses.some(status => status.active);
    },
    activeStatus() {
      const status = this.statuses.find(status => status.active);
      return status ? status.label : 'Other';
    },
  },

  methods: {
    updateStatus(selected_status) {
      this.statuses = this.statuses.map(status => {
        return {
          label: status.label,
          active: status.label === selected_status.label,
        };
      });
    },
  },
};

const generateStatuses = function generateStatuses() {
  let statuses = [
    'Lunch/Coffee',
    'Gym or fresh air',
    'Half-day off',
    'Medical appt.',
    'Personal errands',
    'Agency errands',
    'Client/Rep meeting',
    'Organised event',
    'Studio, shoot or recording',
    'Sick or going home sick',
    'Working from home',
    'Smoko',
    'Stuck in the elevator',
    'At the pub',
    'Having a baby',
  ].map((status, index) => {
    return {
      label: status,
      active: index == 0,
    };
  });

  statuses.push({
    label: 'Other',
    active: false,
  });

  return statuses;
};
</script>
