<template></template>

<script>
import backMixin from "../../mixins/back";
export default {
  name: "engineer",
  mixins: [backMixin],
  mounted() {
    this.$docTitle("工程师");
  }
};
</script>

<style scoped>
</style>
