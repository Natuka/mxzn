<template>
  <div>
    <van-nav-bar title="工单处理过程" left-text="返回" left-arrow @click-left="onClickLeft"/>

    <van-cell-group class="mx-sign-up">
      <van-cell title="姓名" :value="user.name"/>
      <van-cell title="时间" :value="currentDatetime"/>

      <van-cell icon="location" title="点击获取" value="思明区" is-link/>
    </van-cell-group>

    <br>
    <br>
    <van-button :loading="loading" size="large" type="primary" @click="onSign">立即签到</van-button>
  </div>
</template>

<script>
import backMixin from "../../mixins/back";

export default {
  name: "attendance",
  mixins: [backMixin],
  data() {
    return {};
  },
  methods: {
    onSign() {},
    onMore(item) {
      this.data = item;
      this.$refs["action"].open();
    }
  },
  mounted() {
    this.$docTitle("工单处理列表");
  }
};
</script>

<style scoped>
</style>
