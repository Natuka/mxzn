<template></template>

<script>
import backMixin from "../../mixins/back";

export default {
  mixins: [backMixins],
  name: "document",
  mounted() {
    this.$docTitle("文档");
  }
};
</script>

<style scoped>
</style>
