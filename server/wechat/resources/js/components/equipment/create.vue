<template>
  <div>
    <van-nav-bar title="设备录入" left-text="返回" left-arrow fixed @click-left="onClickLeft"/>
    <van-cell-group>
      <van-cell title="客户名称" :value="customer && customer.name"/>
      <van-field v-model="data.equipment.contract_number" label="合同编号" placeholder="合同编号"/>
      <van-cell title="类别">
        <span @click="$refs.type.open()">{{selectFaultValue('type', '请选择',types)}}</span>
        <mx-select
          ref="type"
          :columns="types"
          :on-change="(value,index) => this.setType(value, index)"
        />
      </van-cell>
      <!-- <van-field v-model="data.equipment.type" label="类别" placeholder="类别"/> -->
      <van-field v-model="data.equipment.number" label="设备编号" placeholder="设备编号"/>
      <van-field v-model="data.equipment.name" label="设备名称" placeholder="设备名称"/>
      <van-field v-model="data.equipment.sets" label="设备配置" placeholder="设备配置"/>
      <van-field v-model="data.equipment.technology_staff" label="技术专管" placeholder="技术专管"/>
      <van-field v-model="data.equipment.installation_staff" label="安装人员" placeholder="安装人员"/>
      <mx-datetime-picker
        title="安装日期"
        @on-change="handleChangeDate('installation_date')"
        ref="installation_date"
      ></mx-datetime-picker>

      <mx-datetime-picker
        title="验收日期"
        @on-change="handleChangeDate('acceptance_date')"
        ref="acceptance_date"
      ></mx-datetime-picker>

      <mx-datetime-picker
        title="保修日期"
        @on-change="handleChangeDate('warranty_date')"
        ref="warranty_date"
      ></mx-datetime-picker>

      <mx-datetime-picker
        title="制造日期"
        @on-change="handleChangeDate('identification_code')"
        ref="identification_code"
      ></mx-datetime-picker>

      <van-field v-model="data.equipment.main_no" label="本体编号" placeholder="本体编号"/>
      <van-field v-model="data.equipment.main_model" label="本体型号" placeholder="本体型号"/>
      <van-field v-model="data.equipment.control_box_no" label="控制箱编号" placeholder="控制箱编号"/>
      <van-field v-model="data.equipment.control_box_model" label="控制箱型号" placeholder="控制箱型号"/>
      <van-field v-model="data.equipment.welding_machine_no" label="焊机型号" placeholder="焊机型号"/>
      <van-field v-model="data.equipment.welding_machine_model" label="焊机编号" placeholder="焊机编号"/>
      <van-field v-model="data.equipment.axis1_no" label="1轴编号" placeholder="1轴编号"/>
      <van-field v-model="data.equipment.axis2_no" label="2轴编号" placeholder="2轴编号"/>
      <van-field v-model="data.equipment.axis3_no" label="3轴编号" placeholder="3轴编号"/>
      <van-field v-model="data.equipment.axis4_no" label="4轴编号" placeholder="4轴编号"/>
      <van-field v-model="data.equipment.axis5_no" label="5轴编号" placeholder="5轴编号"/>
      <van-field v-model="data.equipment.axis6_no" label="6轴编号" placeholder="6轴编号"/>

      <van-field v-model="data.equipment.desc" label="中文编码" placeholder="中文编码"/>

      <van-field v-model="data.equipment.code_chinese" label="二维码" placeholder="二维码"/>

      <van-field v-model="data.equipment.desc" label="序列号" placeholder="序列号"/>

      <van-field v-model="data.equipment.maintenance_times" label="维修次数" placeholder="维修次数"/>

      <van-field v-model="data.equipment.desc" label="备注" placeholder="备注"/>
    </van-cell-group>

    <van-button @click="onSubmit" type="primary" size="large">提交</van-button>
  </div>
</template>

<script>
import backMixin from "../../mixins/back";
import Action from "../actions";
import actionMixin from "../../mixins/action";
import equipmentMixin from "../../mixins/equipment";
import dayjs from "dayjs";

import defaultData, { TYPE_LIST } from "../../config/equipment.js";

import {
  ORDER_TYPE,
  ORDER_STATUS,
  ORDER_DEGREE,
  SEQUENCE_TYPE,
  FAULT_TYPE,
  LINE_BROKEN,
  PART_BROKEN,
  MACHINE_TYPE
} from "../../const/repair";

const currentDate = dayjs().format("YYYY-MM-DD HH:mm:ss");

export default {
  name: "mx-equipment-create",
  components: {
    [Action.name]: Action
  },
  mixins: [backMixin, actionMixin, equipmentMixin],
  data() {
    return {
      equipment: ["equipment"],
      fault: ["fault"],
      activeNames: [1],
      data: {
        equipment: {
          ...defaultData
        }
      },
      types: TYPE_LIST,
      orderTypes: ORDER_TYPE,
      orderStatus: ORDER_STATUS,
      orderDegree: ORDER_DEGREE,
      faultType: FAULT_TYPE,
      sequenceType: SEQUENCE_TYPE,
      lineBroken: LINE_BROKEN,
      partBroken: PART_BROKEN
    };
  },
  computed: {
    machineType() {
      return MACHINE_TYPE[this.equipment.type] || "";
    }
  },
  methods: {
    selectFaultValue(field, defaultValue, columns = []) {
      console.log("field", field);
      console.log("defaultValue", defaultValue);
      console.log("columns", columns);

      const data = this.data.equipment;
      const value = data[field];
      return columns[value] || defaultValue;
      //   const data = this.data;
      //   const value = data[field];
      //   return columns[value] || defaultValue;
    },
    async onSubmit() {
      //   console.log("on submit");
      //   this.$toast.success("submited");
      try {
        await this.$api.createEquipment(this.data);
        this.data.equipment = { ...defaultData };
        this.$router.push({
          path: "/repair/list",
          query: {
            refresh: 1
          }
        });
      } catch (e) {
        this.$toast.error(e && e.message);
        console.log("onSubmit", e);
      }
    },
    handlePart() {
      this.$router.push("/select/part");
    },
    setType(value, index) {
      console.log("value", value);
      console.log("index", index);
      this.data.equipment.type = index;
    },
    handleChangeDate(field) {
      return date => {
        this.data.equipment[field] = date;
      };
    }
  },
  mounted() {
    // this.fetchEquipmentList();
    this.$docTitle("提报");
  }
};
</script>

<style scoped>
</style>
