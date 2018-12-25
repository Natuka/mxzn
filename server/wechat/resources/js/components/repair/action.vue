<template>
  <div>
    <van-nav-bar title="工单处理" left-text="返回" left-arrow @click-left="onClickLeft" fixed/>

    <van-cell-group class="mx-sign-up">
      <van-field
        label="故障描述"
        placeholder="故障描述"
        type="textarea"
        rows="2"
        autosize
        :value="data.cause"
        @input="handleCause"
      />
      <van-cell title="故障原因">
        <span @click="$refs.cause.open()">{{selectFaultValue('cause_id', '请选择',faultType)}}</span>
        <mx-select
          ref="cause"
          :columns="faultType"
          :on-change="(value,index) => this.$store.commit('setCauseId', index)"
        />
      </van-cell>
      <mx-upload ref="cause_doc" title="原因照片" :list="causeDocs" @on-change="handleCauseChange"></mx-upload>
      <van-cell title="处理进度">
        <span @click="$refs.process.open()">{{selectFaultValue('process_id', '请选择',process)}}</span>
        <mx-select
          ref="process"
          :columns="process"
          :on-change="(value,index) => this.$store.commit('setProcessId', index)"
        />
      </van-cell>

      <van-field
        :value="data.step_result"
        label="故障描述"
        type="textarea"
        placeholder="故障描述"
        rows="3"
        :autosize="{ maxHeight: 100, minHeight: 50 }"
        @input="handleStepResult"
      />

      <mx-upload ref="step_doc" title="处理照片" :list="stepDocs" @on-change="handleProcessChange"></mx-upload>
      <mx-datetime-picker
        title="到达时间"
        @on-change="handleArrivedChange"
        :value="data.arrived_at"
        ref="arrived_at"
      ></mx-datetime-picker>
      <mx-datetime-picker
        title="完成时间"
        @on-change="handleCompleteChange"
        :value="data.complete_at"
        ref="complete_at"
      ></mx-datetime-picker>
      <van-cell title="服务项目" @click="handleProject">
        <span>{{$store.getters.projectName || '请选择'}}</span>
      </van-cell>
      <van-cell title="配件耗材" @click="handlePart">
        <span>{{$store.getters.partName || '请选择'}}</span>
      </van-cell>
      <van-cell title="查看历史维修记录" is-link @click="handleHistory"></van-cell>

      <van-cell title="下步处理">
        <span @click="$refs.next.open()">{{selectFaultValue('next_step', '请选择',repairNext)}}</span>
        <mx-select
          ref="next"
          :columns="repairNext"
          :on-change="(value,index) => this.$store.commit('setNextStep', index)"
        />
      </van-cell>
    </van-cell-group>
    <br>
    <br>

    <van-button @click="onSubmit" type="primary" size="large">提交</van-button>
  </div>
</template>

<script>
import backMixin from "../../mixins/back";
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
import MxUpload from "../common/mx-upload";

export default {
  name: "attendance",
  components: { MxUpload },
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
    }
  },
  mounted() {
    this.$refs.cause_doc.setFiles(this.$store.getters.causeDocs);
    this.$refs.step_doc.setFiles(this.$store.getters.stepDocs);
    this.$refs.complete_at.setDate(this.$store.getters.repair.complete_at);
    this.$refs.arrived_at.setDate(this.$store.getters.repair.arrived_at);
  },
  methods: {
    ...backMixin.methods,
    onSign() {},
    async onSubmit() {
      const serviceOrder = this.$store.getters.serviceOrder;
      const data = JSON.parse(JSON.stringify(this.data));
      try {
        await this.$api.repairCreateRepair(serviceOrder.id, data);
        this.$store.commit("resetRepair");
        this.$toast.success("处理成功");

        let from = this.$router.query.from;
        let type = this.$router.query.type;
        if (from && from.indexOf("/repair/list")) {
          this.$router.push({
            path: "/repair/list",
            query: {
              refresh: 1,
              type
            }
          });
          return;
        }
        return this.$router.push(from);
      } catch (e) {
        console.log("onSubmit", e);
      }
    },

    onMore(item) {
      this.data = item;
      this.$refs["action"].open();
    },
    selectValue(field, defaultValue, columns = []) {
      const data = this.data;
      const value = data[field];
      return columns[value] || defaultValue;
    },
    selectFaultValue(field, defaultValue, columns = []) {
      const data = this.data;
      const value = data[field];
      return columns[value] || defaultValue;
    },
    handleCauseChange(files) {
      this.$store.commit("setCauseDocs", files);
      this.$store.commit(
        "setCauseDocIds",
        files.map(file => file.id).join(",")
      );
    },
    handleProcessChange(files) {
      this.$store.commit("setStepDocs", files);
      this.$store.commit("setStepDocIds", files.map(file => file.id).join(","));
    },
    handleArrivedChange(date) {
      this.$store.commit("setArrivedAt", date);
    },
    handleCompleteChange(date) {
      this.$store.commit("setCompleteAt", date);
    },
    handleHistory() {},
    handleProject(e) {
      this.$router.push("/select/project");
    },
    handlePart() {
      this.$router.push("/select/part");
    },
    handleCause(e) {
      this.$store.commit("setCause", e);
    },
    handleStepResult(value) {
      this.$store.commit("setStepResult", value);
    }
  },
  mounted() {
    this.$docTitle("工单处理");
  }
};
</script>

<style scoped>
.mx-sign-up {
  margin-top: 50px;
}
</style>
