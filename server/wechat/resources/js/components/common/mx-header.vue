<template>
  <van-nav-bar title="工单处理" left-text="返回" left-arrow @click-left="back" :fixed="fixed"/>
</template>

<script>
export default {
  props: {
    fixed: {
      type: Boolean,
      default: true
    },
    title: {
      type: String,
      default: ""
    }
  },
  methods: {
    back() {}
  }
};
</script>

<style >
</style>