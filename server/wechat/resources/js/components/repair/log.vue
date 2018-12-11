<template></template>

<script>
import backMixin from "../../mixins/back";
export default {
  name: "log",
  mixins: [backMixin],

  mounted() {
    this.$docTitle("操作记录");
  }
};
</script>

<style scoped>
</style>
