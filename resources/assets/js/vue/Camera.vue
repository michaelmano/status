<template>
    <section>
        <div v-show="loading" class="Loader"></div>
        <div class="FSPanel__container">
            <h2 v-for="(error, index) in errors" :key="index" class="util-instruction-heading" v-text="error.message"></h2>
            <div class="Camera" v-show="!loading && predictions.length <= 0">
                <video ref="video" class="Camera__video" autoplay></video>
                <button class="Button Button--sign-out" @click.prevent="takePhoto"><span>Take Photo</span></button>
            </div>
            <div v-show="predictions.length >= 1" class="Camera__response Namepad">
                <h2 class="util-instruction-heading">Sign out the following people?</h2>
                <ul class="Camera__users">
                    <li class="Camera__user Form Form--flex Form--list" :key="key" v-for="(prediction, key) in predictions">
                        <vue-avatar class="Camera__avatar" :photo="photo" :coordinates="prediction.coordinates" />
                        <select class="Form__input" @change="updatePrediction($event, key)">
                            <option value="" :selected="prediction.name == 'unknown'" disabled="disabled"> - Please Select -</option>
                            <option v-for="(employee, index) in employees" :key="index" v-text="employee" :selected="prediction.name == employee" :value="employee"></option>
                        </select>
                        <input type="hidden" name="names[]" :value="prediction.name">
                        <input type="hidden" name="coordinates[]" :value="prediction.coordinates.toString()">
                        <button class="Button Button--remove" @click.prevent="removePrediction(key)"></button>
                    </li>
                </ul>
                <input type="hidden" :value="facerecid" name="facerec_id">
            </div>
        </div>
    </section>
</template>
<script>
import VueAvatar from './Avatar.vue';

export default {
  components: {
    VueAvatar,
  },
  data() {
    return {
      facerecid: null,
      errors: [],
      predictions: [],
      loading: true,
      photo: new Image(),
    };
  },
  props: {
    names: {
      default: null,
      type: Array,
    },
  },
  mounted() {
    this.employees = this.names.map(name => {
      return this.formatName(name, ' ');
    });

    const video = this.$refs['video'];

    navigator.mediaDevices
      .getUserMedia({ video: true })
      .then(stream => {
        try {
          video.srcObject = stream;
        } catch (error) {
          video.src = URL.createObjectURL(stream);
        }
      })
      .then(() => {
        video.onloadedmetadata = () => {
          this.loading = false;
        };
      });
  },
  methods: {
    takePhoto() {
      this.errors = [];
      this.facerecid = null;
      this.predictions = [];
      this.loading = true;
      const canvas = document.createElement('canvas');
      const video = this.$refs['video'];
      const aspect = this.calculateAspectRatioFit(video.clientWidth, video.clientHeight);
      canvas.width = aspect.width;
      canvas.height = aspect.height;
      canvas.getContext('2d').drawImage(video, 0, 0, aspect.width, aspect.height);

      return this.makePrediction(canvas.toDataURL());
    },
    makePrediction(photo) {
      axios
        .post('/api/camera', {
          image: photo,
        })
        .then(response => {
          if (response.data.errors.length >= 1) {
            this.loading = false;
            this.errors = response.data.errors;
          } else {
            this.facerecid = response.data.id;
            this.photo.src = response.data.image_url;
            this.photo.onload = () => {
              this.loading = false;
              this.formatResponse(response.data.predictions);
            };
          }
        })
        .catch(error => {
            this.errors = error;
            this.loading = false;
        });
    },
    updatePrediction(event, index) {
      return (this.predictions[index].name = this.formatName(
        event.target.value,
        ' ',
      ));
    },
    removePrediction(index) {
      return this.predictions.splice(this.predictions.indexOf(index), 1);
    },
    formatResponse(predictions) {
      this.predictions = predictions.map(prediction => {
        return {
          name: this.formatName(prediction.name, '_'),
          coordinates: prediction.coordinates,
        };
      });
    },
    formatName(name, separator) {
      if (name == 'unknown') return name;
      return name
        .split(separator)
        .map(n => {
          return n.charAt(0).toUpperCase() + n.slice(1);
        })
        .join(' ');
    },
    calculateAspectRatioFit(srcWidth, srcHeight) {
        const MAX_WIDTH = 320;
        const MAX_HEIGHT = 240;
        var ratio = Math.min(MAX_WIDTH / srcWidth, MAX_HEIGHT / srcHeight);
        
        return { width: srcWidth*ratio, height: srcHeight*ratio };
    }
  },
};
</script>