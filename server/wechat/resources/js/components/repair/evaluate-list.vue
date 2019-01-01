<template>
  <div>
    <van-nav-bar title="历史评价列表" left-text="返回" left-arrow @click-left="onClickLeft" fixed/>
    <mx-repair-evaluate-item class="mx-sign-up"></mx-repair-evaluate-item>
  </div>
</template>

<script>
import backMixin from "../../mixins/back";

import mxRepairActionItem from "../common/mx-repair-evaluate-item";
import {
  ORDER_TYPE,
  ORDER_STATUS,
  ORDER_DEGREE,
  SEQUENCE_TYPE,
  FAULT_TYPE,
  LINE_BROKEN,
  PART_BROKEN,
  MACHINE_TYPE,
  REPAIR_PROCESS,
  REPAIR_NEXT
} from "../../const/repair";
import defaultData from "../../config/repair.js";

export default {
  name: "mx-evaluate-list",
  components: {
    [mxRepairActionItem.name]: mxRepairActionItem
  },
  data() {
    return {
      orderTypes: ORDER_TYPE,
      orderStatus: ORDER_STATUS,
      orderDegree: ORDER_DEGREE,
      faultType: FAULT_TYPE,
      sequenceType: SEQUENCE_TYPE,
      lineBroken: LINE_BROKEN,
      partBroken: PART_BROKEN,
      process: REPAIR_PROCESS,
      repairNext: REPAIR_NEXT
    };
  },
  computed: {
    data() {
      return this.$store.getters.repair;
    },
    causeDocs() {
      return this.$store.getters.causeDocs;
    },
    stepDocs() {
      return this.$store.getters.stepDocs;
    },
    fault() {
      this.$store.getters.fault;
    }
  },
  mounted() {},
  methods: {
    ...backMixin.methods
  },
  mounted() {
    this.$docTitle("工单处理列表");
  }
};
</script>

<style scoped>
.mx-sign-up {
  margin-top: 50px;
}
</style>

