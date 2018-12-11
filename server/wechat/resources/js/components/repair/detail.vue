<template>
  <div>
    <van-nav-bar title="服务单详情" left-text="返回" left-arrow @click-left="onClickLeft"/>
    <van-cell-group>
      <van-cell title="工单单号" :value="order.number"/>
      <van-cell title="当前状态" :value="getStatus()"/>
      <van-cell title="工单类型" :value="getType()"/>
      <van-cell title="处理方式" :value="actionType()"/>
      <van-cell title="受理时间" :value="receiveAt()"/>
      <van-cell title="受理人员" value="GD-12173237-2323">
        <span class="mx-text-danger" slot="title">{{receiveStaff()}}</span>
      </van-cell>
      <van-cell title="紧急程度" value="GD-12173237-2323">
        <span class="mx-text-danger" slot="title">{{orderDegree()}}</span>
      </van-cell>
      <van-cell title="服务级别" :value="orderLevel()"/>
      <van-cell title="客户名称" :value="orderCustomer()"/>
      <van-cell title="报修人员" :value="orderFeedbackStaff()"/>
      <van-cell title="报修人电话" :value="orderFeedbackTel()"/>
      <van-cell title="联系地址" :value="orderAddress()"/>
      <van-cell title="服务工程师" :value="serviceStaff()"/>
    </van-cell-group>

    <van-collapse v-model="faultModel" class="mt-20">
      <van-collapse-item title="故障信息" name="1">
        <van-cell-group>
          <van-cell title="故障描述" :value="faultDesc()"/>
          <van-cell title="故障描述照片" :value="faultImage()"/>
          <van-cell title="故障类型" :value="faultType()"/>
          <van-cell title="故障频率" :value="faultSequnce()"/>
          <van-cell title="线路是否破损" :value="faultLineBroken()"/>
          <van-cell title="部品是否破损" :value="faultPartBroken()"/>
          <van-cell title="是否服务收费" :value="serviceFee()"/>
          <van-cell title="是否报价" :value="serviceFee()"/>
          <van-cell title="是否报价" :value="quoteFee()"/>
          <van-cell title="报价附件" :value="quoteDocs()"/>
        </van-cell-group>
      </van-collapse-item>
    </van-collapse>

    <van-collapse v-model="machineModel" class="mt-20">
      <van-collapse-item title="机器信息" name="1">
        <van-cell title="技术专管" :value="technologyStaff()"/>
        <van-cell title="安装人员" :value="installationStaff()"/>
        <van-cell title="设备编号" :value="equipmentNumber()"/>
        <van-cell title="设备名称" :value="equipmentName()"/>
        <van-cell title="型号规格" :value="equipmentModel()"/>
        <van-cell title="合同编号" :value="contractNumber()"/>
        <van-cell title="类别" :value="equipmentType()"/>
        <van-cell title="安装日期" :value="installationDate()"/>
        <van-cell title="保修日期" :value="warrantyDate()"/>
        <van-cell title="验收日期" :value="acceptanceDate()"/>
        <van-cell title="制造日期" :value="manufactureDate()"/>
        <van-cell title="本体编号" :value="mainNo()"/>
        <van-cell title="本体型号" :value="mainModel()"/>
        <van-cell title="控制箱编号" :value="controlBoxNo()"/>
        <van-cell title="控制箱型号" :value="controlBoxModel()"/>
        <van-cell title="焊机编号" :value="weldingMachineNo()"/>
        <van-cell title="焊机型号" :value="weldingMachineModel()"/>
        <van-cell title="1轴编号" :value="axis1No()"/>
        <van-cell title="2轴编号" :value="axis2No()"/>
        <van-cell title="3轴编号" :value="axis3No()"/>
        <van-cell title="4轴编号" :value="axis4No()"/>
        <van-cell title="5轴编号" :value="axis5No()"/>
        <van-cell title="6轴编号" :value="axis6No()"/>
        <van-cell title="中文编码" :value="codeChinese()"/>
        <van-cell title="序列号" :value="equipmentType()"/>
        <van-cell title="维修次数" :value="maintenanceTimes()"/>
      </van-collapse-item>
    </van-collapse>

    <van-panel class="mt-20">
      <div slot="footer">
        <van-row type="flex" justify="space-between">
          <van-col span="6">
            <van-button size="small" @click="onAttendance(order)">签到</van-button>
          </van-col>
          <van-col span="6">
            <van-button size="small" @click="onAttendance(order)">处理</van-button>
          </van-col>
          <van-col span="6">
            <van-button size="small" @click="onAttendance(order)">附件</van-button>
          </van-col>
          <van-col span="6">
            <van-button size="small" @click="onMore(order)">更多</van-button>
          </van-col>
        </van-row>
      </div>
    </van-panel>
    <mx-actions ref="action" :data="order" :from="$route.fullPath"></mx-actions>
  </div>
</template>

<script>
import backMixin from "../../mixins/back";
import Action from "../actions";
import actionMixin from "../../mixins/action";
import serviceDetailMixin from "../../mixins/service-detail.js";
import { repairInfo } from "../../api/repair.js";

export default {
  name: "mx-detail",
  components: {
    [Action.name]: Action
  },
  mixins: [backMixin, actionMixin, serviceDetailMixin],
  data() {
    return {
      faultModel: [1],
      machineModel: [1],
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
    onClickRight() {},
    onMore(item) {
      this.data = item;
      this.$refs["action"].open();
    }
  }
};
</script>

<style scoped>
</style>
