<template>
  <div>
    <van-nav-bar title="内容不存在" left-text="返回" right-text left-arrow @click-left="onClickLeft"/>
    <div class="container">
      <van-icon name="close" color="#f44" size="4rem"/>
      <h3>访问的内存不存在</h3>
      <van-button type="primary" @click="handleClick">返回我的工单</van-button>
    </div>
  </div>
</template>

<script>
import backMixin from "../mixins/back";

export default {
  name: "404",
  mixins: [backMixin],
  data() {
    return {
      isLoading: false,
      loading: false,
      finished: false,
      data: [],
      page: 1,
      name: ""
    };
  },
  methods: {
    onClickLeft() {
      this.$router.push("/repair/list");
    },
    handleClick(item) {
      this.$router.push("/repair/list");
    }
  },
  mounted() {
    this.$docTitle("404-页面不存在");
  }
};
</script>

<style scoped>
.container {
  height: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
  padding-top: 50%;
}
</style>
