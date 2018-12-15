<template>
  <div>
    <van-nav-bar
      title="签到"
      left-text="返回"
      right-text
      left-arrow
      @click-left="onClickLeft"
      @click-right="onClickRight"
    />

    <van-cell-group class="mx-sign-up">
      <van-cell title="姓名" :value="user.name"/>
      <van-cell title="时间" :value="currentDatetime"/>
      <van-cell icon="location" title="点击获取" :value="geo.address"/>
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
  computed: {
    geo() {
      return this.$store.getters.geo;
    },
    order() {
      return this.$store.getters.serviceOrder;
    }
  },
  methods: {
    async onSign() {
      try {
        const { data } = await this.$api.postRepairAttendance(
          this.order.id,
          this.geo
        );
        this.$toast.success("签到成功");
        this.$router.go(-1);
      } catch (e) {
        this.$toast.fail(e.message);
      }
    },

    onMore(item) {
      this.data = item;
      this.$refs["action"].open();
    }
  },
  mounted() {
    this.$docTitle("签到");
  }
};
</script>

<style scoped>
</style>
