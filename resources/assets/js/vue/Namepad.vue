<template lang="html">
    <div class="Namepad">
        <input v-if="selection_complete" type="hidden" name="names[]" v-bind:value="selection">
        <input v-if="markers.length > 0" v-for="marker in markers" type="hidden" name="names[]" v-bind:value="marker">
        <h2 class="util-instruction-heading">Who's signing out?</h2>
        <ul class="Namepad__markers">
            <li class="Namepad__marker" v-for="marker in markers">{{ marker }}</li>
        </ul>
        <div v-bind:class="{'Namepad__selection': true, 'is-active': selection_complete}">{{ selection }}</div>
        <div class="Namepad__grid">
            <div v-for="key in keyTable" class="Namepad__grid-box">
                <div v-tap v-on:click="updateSelection(key.letter, key.active)" v-bind:class="{'Namepad__key': true, 'is-active': key.active}">
                    {{ getKeyLabel(key) }}
                </div>
            </div>
            <div class="Namepad__grid-box">
                <div v-tap v-on:click="clearSelection()" class="Namepad__key Namepad__key--clear is-active">CL</div>
            </div>
            <div class="Namepad__grid-box Namepad__grid-box--extra-wide">
                <div v-tap v-on:click="confirmSelection()" v-bind:class="{'Namepad__key': true, 'Namepad__key--confirm': true, 'is-active': selection_complete}">Add another</div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
  data() {
    return {
      keys: generateKeys(),
      markers: [],
      employees: [],
      selection: '',
      selection_complete: false,
    };
  },

  props: {
    names: {
      type: Array,
      default: [],
    },
  },

  mounted() {
    this.$nextTick(() => {
      this.update();
    });
  },

  computed: {
    keyTable() {
      return this.keys;
    },
  },

  methods: {
    update() {
      this.employees = this.names.map(name => {
        return {
          active: true,
          name: name.toLowerCase(),
        };
      });
      const any_active_employees = this.updateListOfEmployees();
      const available_letters = this.getAvailableLetters();

      if (!any_active_employees) {
        this.selection_complete = false;
        return this.updateAvailableKeys([]);
      }

      this.selection_complete = available_letters.length === 0;

      if (available_letters.length === 1) {
        return this.updateSelection(available_letters[0]);
      }

      this.updateAvailableKeys(available_letters);
    },
    updateSelection(letter, active = true) {
      if (!active) return;
      this.selection = this.selection + letter;
      this.update();
    },
    clearSelection() {
      this.selection = '';
      this.update();
    },
    confirmSelection() {
      if (!this.selection_complete) return;
      this.markers.push(this.selection);
      this.selection = '';
      this.update();
    },
    updateAvailableKeys(available_letters) {
      this.keys = this.keys.map(key => {
        return Object.assign({}, key, {
          active: available_letters.includes(key.letter),
        });
      });
    },
    getAvailableLetters() {
      let unique_letters = {};
      return this.employees
        .filter(employee => employee.active)
        .filter(employee => employee.name.length > this.selection.length)
        .map(employee => {
          return employee.name.slice(this.selection.length);
        })
        .map(str => str.slice(0, 1))
        .filter(letter => {
          return unique_letters.hasOwnProperty(letter)
            ? false
            : (unique_letters[letter] = true);
        });
    },
    anyActiveEmployees() {
      return this.employees.some(employee => employee.active);
    },
    updateListOfEmployees() {
      this.employees = this.employees.map(employee => {
        return {
          active:
            !this.markers.includes(employee.name) &&
            employee.name.startsWith(this.selection),
          name: employee.name,
        };
      });
      return this.anyActiveEmployees();
    },
    getKeyLabel(key) {
      return key.label || key.letter;
    },
  },
};

const generateKeys = function generateKeys() {
  let keys = [...Array(26).keys()].map(code => {
    return {
      active: false,
      label: null,
      letter: String.fromCharCode(code + 65).toLowerCase(),
    };
  });

  keys.push({
    active: false,
    label: '＿',
    letter: ' ',
  });

  return keys;
};
</script>
