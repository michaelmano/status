require('./bootstrap');

import Q from 'qoob';
import Vue from 'vue';
import Tap from 'vtap';
import VueNamepad from './vue/Namepad.vue';
import VueCamera from './vue/Camera.vue';
import VueStatus from './vue/Status.vue';
import VueTimepad from './vue/Timepad.vue';
import overlay from './vanilla/Overlay.js';
import forms from './vanilla/forms.js';
import list from './vanilla/list.js';
import inactivity from './vanilla/inactivity.js';


Vue.use(Tap);

new Vue({
    el: '#app',
    data() {
        return {
            type: null,
            removeEmployeeID: null,
            beta: window.location.search.substr(1).includes('beta')
        }
    },
    components: {
        VueCamera,
        VueNamepad,
        VueStatus,
        VueTimepad,
    },
    methods: {
        confirmEmployeeRemoval() {
            let select = this.$refs['employee_removal_id'];
            console.log(select.value)
            this.removeEmployeeID = select.value;
        }
    }
});

Q.documentReady(() => {
    overlay();
    forms();
    list();
    inactivity();
});