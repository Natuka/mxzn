<template></template>

<script>
import backMixin from "../../mixins/back";

export default {
  name: "service.vue",
  mixins: [backMixin],

  mounted() {
    this.$docTitle("服务");
  }
};
</script>

<style scoped>
</style>
