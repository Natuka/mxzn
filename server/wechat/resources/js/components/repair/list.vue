<template>
  <div>
    <van-nav-bar
      fixed
      title="工单"
      left-text="返回"
      right-text="提报"
      left-arrow
      @click-left="onClickLeft"
      @click-right="onClickRight"
    />
    <van-search v-model="value" placeholder="请输入搜索关键词" show-action @search="onSearch">
      <div slot="action" @click="onSearch">搜索</div>
    </van-search>
    <van-tabs v-model="active">
      <van-tab v-for="menu in menus" :title="menu.name" :key="menu.type">
        <mx-repair-item :type="menu.type" :key="'item-' + menu.type"></mx-repair-item>
      </van-tab>
    </van-tabs>

    <mx-actions ref="action" :data="data" :from="$route.fullPath"></mx-actions>
  </div>
</template>

<script>
import { list } from "../../const/repair";
import Action from "../actions";
import actionMixin from "../../mixins/action";
import infoMixin from "../../mixins/service-info";

import { Toast } from "vant";

import MxRepairItem from "../common/mx-repair-item";

export default {
  name: "mx-repair-list",
  components: {
    [Action.name]: Action,
    [MxRepairItem.name]: MxRepairItem
  },
  mixins: [actionMixin, infoMixin],
  data() {
    return {
      active: 2,
      list: [],
      loading: false,
      finished: false,
      menus: list,
      isLoading: false,
      value: "",
      data: {},
      page: 1,
      isRefresh: false
    };
  },
  methods: {
    onClickLeft() {
      this.$toast("返回");
    },
    onSearch() {},
    onClickRight() {
      this.$router.push("/repair/create");
    },
    mounted() {
      this.$docTitle("工单列表");
    }
  },
  mounted() {
    this.active = this.$store.getters.orderType;
  },
  watch: {
    active(active) {
      this.$store.commit("setOrderType", active);
      console.log("watch active", active);
    }
  }
};
</script>

<style scoped>
.text-right {
  text-align: right;
}
</style>
