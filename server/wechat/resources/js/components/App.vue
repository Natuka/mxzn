<template>
  <div>
    <router-view></router-view>
  </div>
</template>

<script>
export default {
  data() {
    return {
      count: 0,
      isLoading: false
    };
  },

  methods: {
    onRefresh() {
      setTimeout(() => {
        this.$toast("刷新成功");
        this.isLoading = false;
        this.count++;
      }, 500);
    }
  },
  // 加载微信，在这边进行初始化
  async mounted() {
    try {
      let data = await this.$api.getWXConfig();
      let res = await this.$wx.configAsync(data);

      console.log("wechat config", data);
      console.log("wechat config set result", res);

      this.$wx.getLocation({
        type: "wgs84", // 默认为wgs84的gps坐标，如果要返回直接给openLocation用的火星坐标，可传入'gcj02'
        success: res => {
          this.$store.commit("setLng", res.longitude);
          this.$store.commit("setLat", res.latitude);
          this.$store.dispatch("fetchGeo");

          //   this.$api.fetchGeo(res.longitude, res.latitude).then(data => {
          //     console.log("fetchGeo", data);
          //   });
          var latitude = res.latitude; // 纬度，浮点数，范围为90 ~ -90
          var longitude = res.longitude; // 经度，浮点数，范围为180 ~ -180。
          var speed = res.speed; // 速度，以米/每秒计
          var accuracy = res.accuracy; // 位置精度
        }
      });
    } catch (e) {}

    this.$store.dispatch("init");
  }
};
</script>
