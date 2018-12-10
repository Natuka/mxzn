<template>
  <div>
    <van-nav-bar
      title="服务项目选择"
      left-text="返回"
      right-text
      left-arrow
      @click-left="onClickLeft"
      @click-right="onClickRight"
    />
    <van-search placeholder="请输入搜索关键词" v-model="name" @search="onSearch"/>
    <van-pull-refresh v-model="isLoading" @refresh="onRefresh">
      <van-list v-model="loading" :finished="finished" @load="onLoad">
        <van-panel
          :key="key"
          v-for="(item, key) in data"
          :title="getTitle(item)"
          :status="getStatus(item)"
          :desc="getDesc(item)"
          @click.native="handleClick(item)"
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
      return `${item.name} ${item.number}`;
    },
    getStatus(item) {
      return `${item.workday} ${item.unit}`;
    },

    getDesc(item) {
      return item.content;
    },

    handleClick(item) {
      this.$store.commit("setProject", item);
      this.$router.go(-1);
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
        } = await this.$api.fetchProjectList(this.name, this.page);
        if (this.isRefresh) {
          this.data = [];
        }

        this.page++;
        this.data.push(...data);
        if (!data.length || data.length < per_page) {
          this.finished = true;
        }
      } catch (e) {
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
