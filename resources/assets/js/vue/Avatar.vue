<template>
    <div>
        <canvas ref="avatar" width="120" height="120"></canvas>
        <input type="hidden" name="avatar[]" :value="avatar">
    </div>
</template>

<script>
export default {
  data() {
    return {
        avatar: null
    };
  },
  props: {
    photo: {
      default: null,
      type: HTMLImageElement,
    },
    coordinates: {
      default: null,
      type: Array,
    },
  },
  methods: {
    cropAvatar() {
      const canvas = this.$refs['avatar'];
      let [top, right, bottom, left] = this.coordinates;
      const width = right - left;
      const height = bottom - top;

      const size = (width >= height ? width : height) * 1.7;

      top = top - height / 2;
      left = left - width / 2;

      canvas
        .getContext('2d')
        .drawImage(
          this.photo,
          left,
          top,
          size,
          size,
          0,
          0,
          canvas.width,
          canvas.height,
        );

        this.avatar = canvas.toDataURL();
    },
  },
  mounted() {
    this.cropAvatar();
  },
};
</script>