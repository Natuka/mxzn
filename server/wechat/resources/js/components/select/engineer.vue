<template>
  <div>
    <van-nav-bar title="工程师选择" left-text="返回" right-text left-arrow @click-left="onClickLeft"/>
    <van-search placeholder="请输入搜索关键词" v-model="name" @search="onSearch"/>
    <van-pull-refresh v-model="isLoading" @refresh="onRefresh">
      <van-list v-model="loading" :finished="finished" @load="onLoad">
        <van-panel
          @click.native="handleClick(item)"
          :key="key"
          v-for="(item, key) in data"
          :title="getTitle(item)"
          :status="getStatus(item)"
        ></van-panel>
      </van-list>
    </van-pull-refresh>
  </div>
</template>

<script>
import backMixin from "../../mixins/back";

export default {
  name: "cancel",
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
    getTitle(item) {
      return item.staff_name;
    },
    getStatus(item) {
      if (this.$store.getters.isSelectedEngineer(item)) {
        return "已选择";
      }
      return "";
    },

    handleClick(item) {
      this.$store.commit("toggleEngineer", item);
      // this.$router.go(-1);
    },

    onSearch() {
      this.onRefresh();
    },

    async onRefresh() {
      this.isRefresh = true;
      await this.loadData();
      await this.onLoad();
    },

    async loadData() {
      let dataWrap = this.data;
      if (this.isRefresh) {
        this.loading = true;
        this.finished = false;
        this.page = 1;
      } else {
        this.finished = false;
      }

      try {
        let {
          data,
          current_page,
          last_page,
          per_page
        } = await this.$api.fetchEngineerList(this.name, this.page);
        if (this.isRefresh) {
          this.data = [];
        }

        this.page++;
        this.data.push(...data);
        if (!data.length || data.length < per_page) {
          this.finished = true;
        }
      } catch (e) {
        console.log("e", e);
        this.finished = true;
      } finally {
        this.loading = false;
      }
    },

    async onLoad() {
      this.isRefresh = false;
      await this.loadData();
    }
  }
};
</script>

<style scoped>
</style>
