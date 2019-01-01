<template>
  <div>
    <van-nav-bar
      title="客户确认与评价"
      left-text="返回"
      right-text="历史评价>"
      left-arrow
      right-arrow
      @click-left="onClickLeft"
      @click-right="onClickRight"
    />

    <van-cell-group>
      <van-cell :title="noText"></van-cell>
      <van-cell title="处理过程"></van-cell>
      <van-cell v-if="list.length" style="background-color: #EEFAFA">
        <div v-for="info in list" :key="info.id">
          <van-row type="flex" justify="start">
            <van-col span="24">{{info.step_result || '无'}}</van-col>
          </van-row>
          <van-row type="flex" justify="end">
            <van-col span="24" style="text-align:right">{{info.created_at}}</van-col>
          </van-row>
        </div>
      </van-cell>

      <van-cell title="是否解决问题">
        <van-radio-group v-model="data.is_solve">
          <van-radio :name="1" class="inline-block">是</van-radio>
          <van-radio :name="0" class="inline-block">否</van-radio>
        </van-radio-group>
      </van-cell>
      <van-cell title="整体满意度">
        <van-rate v-model="data.overall_satisfaction"/>
      </van-cell>
      <van-cell title="服务及时性">
        <van-rate v-model="data.timeliness"/>
      </van-cell>
      <van-cell title="服务人员满意度">
        <van-rate v-model="data.service_staff_atisfaction"/>
      </van-cell>
      <van-cell title="性价比满意度">
        <van-rate v-model="data.cost_performance"/>
      </van-cell>
      <van-field
        v-model="data.opinions_suggestions"
        label="建议与意见"
        type="textarea"
        placeholder="请输入"
        rows="3"
        :autosize="{ maxHeight: 100, minHeight: 50 }"
      />
    </van-cell-group>

    <van-button @click="onSubmit" type="primary" size="large">提交</van-button>

    <!-- <mx-actions ref="action" :data="data" :from="$route.fullPath"></mx-actions> -->
  </div>
</template>

<script>
import backMixin from "../../mixins/back";
import Action from "../actions";
import actionMixin from "../../mixins/action";
import { repairEvaluateLast, fetchRepairRepairList } from "../../api/repair.js";

import dayjs from "dayjs";

const defaultData = {
  is_solve: 1,
  overall_satisfaction: 5,
  timeliness: 5,
  service_staff_atisfaction: 5,
  cost_performance: 5,
  opinions_suggestions: ""
};

export default {
  name: "mx-evaluate",
  components: {
    [Action.name]: Action
  },
  mixins: [backMixin, actionMixin],
  data() {
    return {
      data: {
        ...defaultData
      },
      list: []
    };
  },
  computed: {
    serviceOrder() {
      return this.$store.getters.serviceOrder;
    },
    noText() {
      if (this.serviceOrder) {
        return "工单号：" + this.serviceOrder.number;
      }
      return "工单号：";
    }
  },
  async beforeRouteEnter(to, from, next) {
    // 如果是有ID，那么说明需要重新获取工单内容
    if (to.query.last) {
      try {
        const data = await repairEvaluateLast();
        window.store.commit("set_service_order", data);
        const list = await fetchRepairRepairList(data.id);
        // window.store.commit("set_service_order_repairs", list);
        next(vm => {
          vm.list = list;
        });
      } catch (e) {
        next("/403");
        return;
      }
      return;
    }

    // 获取处理过程
    try {
      const serviceOrder = window.store.getters.serviceOrder;
      const list = await fetchRepairRepairList(serviceOrder.id);
      next(vm => {
        vm.list = list;
      });
    } catch (e) {
      next("/403");
    }
  },
  methods: {
    onClickRight() {
      this.$router.push("/evaluate/list");
    },
    onMore(item) {
      this.data = item;
      this.$refs["action"].open();
    },
    async onSubmit() {
      try {
        const { data } = await this.$api.saveEvaluate(
          this.$store.getters.order.id || 1,
          this.data
        );
        this.data = { ...defaultData };
      } catch (e) {
        console.log("e", e);
      }
    }
  },
  mounted() {
    this.$docTitle("评价");
  }
};
</script>

<style scoped>
.inline-block {
  display: inline-block;
}
</style>
