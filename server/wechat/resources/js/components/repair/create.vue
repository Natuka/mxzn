<template>
  <div>
    <van-nav-bar title="服务单提交" left-text="返回" left-arrow @click-left="onClickLeft"/>
    <van-cell-group>
      <van-cell title="服务类别">
        <span @click="$refs.level.open()">{{selectValue('level', '请选择', orderTypes)}}</span>
        <mx-select
          ref="level"
          :columns="orderTypes"
          :on-change="(value, index) => data.level = index"
        />
      </van-cell>
      <van-cell title="紧急程度">
        <span @click="$refs.degree.open()">{{selectValue('emergency_degree', '请选择',orderDegree)}}</span>
        <mx-select
          ref="degree"
          :columns="orderDegree"
          :on-change="(value, index) => data.emergency_degree = index"
        />
      </van-cell>

      <van-cell title="客户名称" v-if="customer" :value="customer && customer.name"/>
      <van-cell title="地址" v-if="customer" :value="customerAddr()"/>
      <van-field
        v-if="!customer"
        v-model="data.customer_name"
        label="客户名称"
        type="textarea"
        placeholder="客户名称"
        rows="1"
        :autosize="{ maxHeight: 30, minHeight: 30 }"
      />
        <van-field
            v-if="!customer"
            v-model="data.customer_addr"
            label="地址"
            type="textarea"
            placeholder="地址"
            rows="1"
            :autosize="{ maxHeight: 30, minHeight: 30 }"
        />
        <van-field
            v-if="!customer"
            v-model="data.customer_contact"
            label="联系人员"
            type="textarea"
            placeholder="联系人员"
            rows="1"
            :autosize="{ maxHeight: 30, minHeight: 30 }"
        />
        <van-field
            v-if="!customer"
            v-model="data.customer_mobile"
            label="联系人手机"
            type="textarea"
            placeholder="联系人手机"
            rows="1"
            :autosize="{ maxHeight: 30, minHeight: 30 }"
        />
    </van-cell-group>
    <van-collapse v-model="equipment" class="mt-20" v-if="customer">
      <van-collapse-item title="机器信息" name="equipment">
        <van-cell-group>
          <van-cell title="设备名称" :value="data.equipment.name"/>
          <van-cell title="设备编号" :value="data.equipment.number"/>
          <van-cell title="型号规格" v-if="hasEquipmentId" :value="data.equipment.model"/>
          <van-cell title="型号规格" v-else :value="data.equipment.model">
            <span @click="onPickerEquipment">{{data.equipment.model || '请选择'}}</span>
            <mx-select ref="equipment" :columns="equipmentsText" :on-change="hanleSelectEquipment"/>
          </van-cell>

          <van-cell title="合同编号" :value="data.equipment.contract_number"/>
          <van-cell title="类别" :value="machineType"/>
          <van-cell title="安装时间" :value="data.equipment.installation_date"/>
        </van-cell-group>
      </van-collapse-item>
    </van-collapse>

    <van-collapse v-model="fault" class="mt-20">
      <van-collapse-item title="故障信息" name="fault">
        <van-cell-group>
          <van-field
            v-model="data.fault.desc"
            label="故障描述*"
            type="textarea"
            placeholder="故障描述"
            rows="3"
            :autosize="{ maxHeight: 100, minHeight: 50 }"
          />
          <van-field label="故障代码" v-model="data.fault.code" placeholder="故障代码"/>
          <van-cell title="故障类型">
            <span @click="$refs.fault.open()">{{selectFaultValue('type', '请选择',faultType)}}</span>
            <mx-select
              ref="fault"
              :columns="faultType"
              :on-change="(value,index) => data.fault.type = index"
            />
          </van-cell>
          <van-cell title="故障频率">
            <span
              @click="$refs.fault_type.open()"
            >{{selectFaultValue('sequence', '请选择',sequenceType)}}</span>
            <mx-select
              ref="fault_type"
              :columns="sequenceType"
              :on-change="(value, index) => data.fault.sequence = index"
            />
          </van-cell>
          <van-cell title="线路是否破损">
            <span
              @click="$refs.fault_line.open()"
            >{{selectFaultValue('is_line_broken', '请选择',lineBroken)}}</span>
            <mx-select
              ref="fault_line"
              :columns="lineBroken"
              :on-change="(value, index) => data.fault.is_line_broken = index"
            />
          </van-cell>
          <van-cell title="部品是否损坏">
            <span
              @click="$refs.is_part_broken.open()"
            >{{selectFaultValue('is_part_broken', '请选择',partBroken)}}</span>
            <mx-select
              ref="is_part_broken"
              :columns="partBroken"
              :on-change="(value, index) => data.fault.is_part_broken = index"
            />
          </van-cell>
            <mx-upload
                ref="fault_doc"
                title="故障附件*"
                :list="faultDocs"
                @on-change="handleFaultDocsChange"
                image
            ></mx-upload>
        </van-cell-group>
      </van-collapse-item>
    </van-collapse>

    <van-button @click="onSubmit" type="primary" size="large">提交</van-button>

    <!-- <mx-actions ref="action" :data="data" :from="$route.fullPath"></mx-actions> -->
  </div>
</template>

<script>
import backMixin from "../../mixins/back";
import Action from "../actions";
import actionMixin from "../../mixins/action";
import equipmentMixin from "../../mixins/equipment";
import dayjs from "dayjs";

import defaultData from "../../config/repair.js";
import MxUpload from "../common/mx-upload";
import { fetchEquipmentList } from "../../api/equipment";

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
  name: "mx-detail",
  components: {
    [Action.name]: Action,
    MxUpload
  },
  mixins: [backMixin, actionMixin, equipmentMixin],
  data() {
    return {
      equipment: ["equipment"],
      fault: ["fault"],
      activeNames: [1],
      data: {
        ...defaultData
      },
      equipmentId: 0,
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
    },
    faultDocs() {
      return this.$store.getters.faultDocs;
    },
    hasEquipmentId() {
      return this.equipmentId || 0;
    }
  },
  methods: {
    onMore(item) {
      this.data = item;
      this.$refs["action"].open();
    },
    async onSubmit() {
      //   console.log("on submit");
      //   this.$toast.success("submited");
        const data = JSON.parse(JSON.stringify(this.data));
        console.log('data64313253', data)
        if (data.fault.desc === '' || +data.type === 0 || data.type === '请选择' || data.fault.fault_doc_ids === '') {
            this.$toast('[服务类别、故障描述、故障附件] 必填!!!');
        } else {
            try {
                await this.$api.repairCreate(this.data);
                this.data = {...defaultData};
                this.$router.push({
                    path: "/repair/list",
                    query: {
                        refresh: 1
                    }
                });
            } catch (e) {
                console.log("onSubmit", e);
            }
        }
    },
    onRead() {
      console.log("upload8568");
    },
    handleFaultDocsChange(files) {
      this.$store.commit("setFaultDocs", files);
      this.data.fault.fault_doc_ids = files.map(file => file.id).join(",")
      this.$store.commit(
          "setFaultDocIds",
          files.map(file => file.id).join(",")
      );
    },
    selectValue(field, defaultValue, columns = []) {
      const data = this.data;
      const value = data[field];
      return columns[value] || defaultValue;
    },
    selectEquipmentValue(field, defaultValue, columns = []) {
      const data = this.data.equipment;
      const value = data[field];
      return columns[value] || defaultValue;
    },
    selectFaultValue(field, defaultValue, columns = []) {
      const data = this.data.fault;
      const value = data[field];
      console.log("value", value, columns);

      return columns[value] || defaultValue;
    },
    onPickerEquipment() {
      this.$refs.equipment.open();
    },
    hanleSelectEquipment(value, index) {
      const eq = this.getEquipmentIdByText(value);
      if (eq) {
        this.data.equipment = eq;
      }
    }
  },
  mounted() {
    this.$refs.fault_doc.setFiles(this.$store.getters.faultDocs);
    this.equipmentId = +this.$route.query.id;
    this.data.level = 3
    this.data.emergency_degree = 3
    // console.log('equipmentId242534', this.equipmentId)
    if (this.equipmentId) {
        // 單筆
        fetchEquipmentList(this.equipmentId)
            .then(data => {
                this.data.equipment = data;
            })
            .catch(e => {

            });
    } else {
      this.fetchEquipmentList();
    }
    this.$docTitle("提报");
  }
};
</script>

<style scoped>
</style>
