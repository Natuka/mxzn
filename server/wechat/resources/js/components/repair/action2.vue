<template>
  <div>
    <van-nav-bar
      title="工单处理"
      left-text="返回"
      right-text="查看处理过程"
      left-arrow
      @click-left="onClickLeft"
      @click-right="onClickRight"
      fixed
    />

    <van-cell-group class="mx-sign-up">
        <van-field
            label="任务描述"
            placeholder="任务描述"
            type="textarea"
            rows="4"
            autosize
            :value="serviceOrder && serviceOrder.remark"
            disabled
        />
      <mx-upload
        ref="cause_doc"
        title="处理前照片"
        :list="causeDocs"
        @on-change="handleCauseChange"
        image
      ></mx-upload>
      <van-cell title="处理进度*">
        <span @click="$refs.process.open()">{{selectFaultValue('process_id', '请选择',process)}}</span>
        <mx-select
          ref="process"
          :columns="process"
          :on-change="(value,index) => this.$store.commit('setProcessId', index)"
        />
      </van-cell>

      <van-field
        :value="data.step_result"
        label="处理措施*"
        type="textarea"
        placeholder="处理措施"
        rows="3"
        :autosize="{ maxHeight: 100, minHeight: 50 }"
        @input="handleStepResult"
      />

      <mx-upload
        ref="step_doc"
        title="处理照片*"
        :list="stepDocs"
        @on-change="handleProcessChange"
        image
      ></mx-upload>
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
     <!-- <van-cell title="服务项目" @click="handleProject">
        <span>{{$store.getters.projectName || '请选择'}}</span>
      </van-cell>
      <van-cell title="配件耗材" @click="handlePart">
        <span>{{$store.getters.partName || '请选择'}}</span>
      </van-cell>-->
      <!--<van-cell title="查看历史维修记录" is-link @click="handleHistory"></van-cell>-->

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
  REPAIR_PROCESS2,
  REPAIR_NEXT
} from "../../const/repair";
import defaultData from "../../config/repair.js";
import MxUpload from "../common/mx-upload";
import dayjs from 'dayjs'
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
      process: REPAIR_PROCESS2,
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
      return this.$store.getters.fault;
    },
    serviceOrder() {
      return this.$store.getters.serviceOrder;
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
      data.process = this.process[data.process_id] || this.process[0]
      // console.log('data64313253', data)
      if (data.process === '' || data.process === '请选择' || data.process === 'step_result' || data.step_doc_ids === '') {
          this.$toast('[处理进度，处理措施，处理照片] 必填!!!');
      } else {
          let timeDiff = dayjs(data.complete_at).diff(dayjs(data.arrived_at), 'hours')
          // console.log('timeDiff64313253', timeDiff)
          if (data.arrived_at >= data.complete_at || +timeDiff < 1 || data.arrived_at === '' || data.complete_at === '') {
              this.$toast('请填上正确的到达时间，完成时间!');
          } else {
              try {
                  await this.$api.repairCreateRepair(serviceOrder.id, data);
                  this.$store.commit("resetRepair");
                  this.$toast.success("处理成功!!!");

                  let from = this.$route.query.from;
                  let type = this.$route.query.type;
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
          }
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
    },
    async onClickRight() {
      this.$router.push("/repair/action-list");
      // this.$toast.loading("正在获取数据中");
      // try {
      //   const list = await this.$api.fetchRepairRepairList(
      //     this.serviceOrder.id,
      //     {}
      //   );

      //   this.$store.commit("setRepairList", list);

      //   console.log("list", list);
      //   this.$toast.clear();
      //   this.$router.push("/repair/action-list");
      // } catch (e) {
      //   this.$toast.fail((e && e.message) || e);
      // }
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
