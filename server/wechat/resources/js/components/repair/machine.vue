<template>
  <div>
    <van-nav-bar title="设备详情" left-text="返回" left-arrow @click-left="onClickLeft" right-text="报修" right-arrow @click-right="onClickRight(equipmentId())" />

    <van-cell-group>
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
      <van-cell title="序列号" :value="equipmentSerialNumber()"/>
      <van-cell title="维修次数" :value="maintenanceTimes()"/>
    </van-cell-group>
    <van-button @click="onClickRight(equipmentId())" type="warning" size="large">报修</van-button>
  </div>
</template>

<script>
import backMixin from "../../mixins/back";
import Action from "../actions";
import actionMixin from "../../mixins/action";
import machineDetailMixin from "../../mixins/machine";
import { fetchMachineInfo } from "../../api/machine";

export default {
  name: "mx-detail",
  components: {
    [Action.name]: Action
  },
  mixins: [backMixin, actionMixin, machineDetailMixin],
  data() {
    return {
      faultModel: [1],
      machineModel: [1],
      data: {}
    };
  },
  beforeRouteEnter(to, from, next) {
    if (to.query.id) {
      fetchMachineInfo(to.query.id)
        .then(data => {
          window.store.commit("set_machine_info", data);
          next();
        })
        .catch(e => {
          next("/403");
        });
      return;
    }
    next();
  },
  methods: {
    onMore(item) {
      this.data = item;
      this.$refs["action"].open();
    }
  },
  mounted() {
    this.$docTitle("设备详情");
  }
};
</script>

<style scoped>
</style>
