<template>
  <div>
    <van-nav-bar
      title="服务单详情"
      left-text="返回"
      right-text="按钮"
      left-arrow
      @click-left="onClickLeft"
      @click-right="onClickRight"
    />
    <van-cell-group>
      <van-cell title="工单单号" is-link :value="serviceOrder.number"/>
      <van-cell title="当前状态" is-link value="GD-12173237-2323"/>
      <van-cell title="服务类别" is-link value="GD-12173237-2323"/>
      <van-cell title="受理方式" is-link value="GD-12173237-2323"/>
      <van-cell title="受理时间" is-link value="GD-12173237-2323"/>
      <van-cell title="受理人" is-link value="GD-12173237-2323">
        <span class="mx-text-danger" slot="title">受理人</span>
      </van-cell>
      <van-cell title="服务号" is-link value="GD-12173237-2323">
        <span class="mx-text-danger" slot="title">客户名称</span>
      </van-cell>
      <van-cell title="报修人" is-link value="GD-12173237-2323"/>
      <van-cell title="报修电话" is-link value="GD-12173237-2323"/>
      <van-cell title="联系地址" is-link value="GD-12173237-2323"/>
      <van-cell title="所属区域" is-link value="GD-12173237-2323"/>
      <van-cell title="技术员" is-link value="GD-12173237-2323"/>
    </van-cell-group>

    <van-collapse v-model="activeNames" class="mt-20">
      <van-collapse-item title="故障信息" name="1">提供多样店铺模板，快速搭建网上商城</van-collapse-item>
    </van-collapse>

    <van-collapse v-model="activeNames" class="mt-20">
      <van-collapse-item title="机器信息" name="1">提供多样店铺模板，快速搭建网上商城</van-collapse-item>
    </van-collapse>

    <van-collapse v-model="activeNames" class="mt-20">
      <van-collapse-item title="其他信息" name="1">提供多样店铺模板，快速搭建网上商城</van-collapse-item>
    </van-collapse>

    <van-panel class="mt-20">
      <div slot="header" class="mx-flex p-10">
        <van-row type="flex" justify="space-between">
          <span>备注</span>
          <span class="mx-flex-1 text-right">工单受理完成，直接派工</span>
        </van-row>
      </div>
      <div slot="footer">
        <van-row type="flex" justify="space-between">
          <van-col span="6">
            <van-button size="small" @click="onAttendance(item)">签到</van-button>
          </van-col>
          <van-col span="6">
            <van-button size="small" @click="onAttendance(item)">处理</van-button>
          </van-col>
          <van-col span="6">
            <van-button size="small" @click="onAttendance(item)">附件</van-button>
          </van-col>
          <van-col span="6">
            <van-button size="small" @click="onMore(item)">更多</van-button>
          </van-col>
        </van-row>
      </div>
    </van-panel>
    <mx-actions ref="action" :data="data" :from="$route.fullPath"></mx-actions>
  </div>
</template>

<script>
import backMixin from "../../mixins/back";
import Action from "../actions";
import actionMixin from "../../mixins/action";

import { repairInfo } from "../../api/repair.js";

export default {
  name: "mx-detail",
  components: {
    [Action.name]: Action
  },
  mixins: [backMixin, actionMixin],
  data() {
    return {
      activeNames: [1],
      data: {}
    };
  },
  beforeRouteEnter(to, from, next) {
    if (to.query.id) {
      repairInfo(to.query.id)
        .then(data => {
          window.store.commit("set_service_order", data);
          next();
        })
        .catch(e => {
          next(false);
        });
      return;
    }
    next();
  },
  methods: {
    onClickLeft() {
      Toast("返回");
    },
    onClickRight() {
      Toast("按钮");
    },
    onMore(item) {
      this.data = item;
      this.$refs["action"].open();
    }
  },
  computed: {
    order() {
      return this.$store.getters.serviceOrder;
    }
  }
};
</script>

<style scoped>
</style>
