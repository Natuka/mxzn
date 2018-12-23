<template>
  <custom-modal
    ref="ref"
    width="1000px"
    title="报价单-配件耗材-新增"
    z-index="10000000"
    @on-submit="onSubmit"
    @on-cancel="onCancel"
    class="mxcs-two-column"
  >
    <div test="1245">
      <Form :model="data" ref="addForm" :rules="rules" :label-width="90" class="mxcs-two-column">
        <FormItem label="配件" prop="base_part_id">
          <remote-select
            :init="data.base_part_id"
            :initData="init.part"
            label="name"
            url="select/part"
            @on-change="partChange"
            @on-change-data="partChangeData"
          ></remote-select>
        </FormItem>

        <!--<FormItem label="编号" prop="serial_number" >
          <Input
            v-model="data.serial_number"
            readonly
          ></Input>
        </FormItem>

        <FormItem label="编号" prop="base_code_id">
          <remote-select
            :init="data.base_code_id"
            :initData="init.code"
            label="name"
            url="select/code"
            @on-change="codeChange"
            @on-change-data="codeChangeData"
          ></remote-select>
        </FormItem>-->
        <FormItem label="料号" prop="number">
          <Input v-model="data.number" disabled></Input>
        </FormItem>

        <FormItem label="品名" prop="name">
          <Input v-model="data.name" disabled></Input>
        </FormItem>

        <FormItem label="规格型号" prop="model">
          <Input v-model="data.model" disabled></Input>
        </FormItem>

        <FormItem label="单价" prop="price">
          <Input v-model="data.price" disabled></Input>
        </FormItem>

        <FormItem label="单位" prop="unit">
          <Input v-model="data.unit" disabled></Input>
        </FormItem>

        <FormItem label="数量" prop="quantity">
          <InputNumber v-model="data.quantity"></InputNumber>
        </FormItem>

        <FormItem label="金额" prop="amount">
          <Input v-model="data.amount" disabled></Input>
        </FormItem>

        <FormItem label="折扣" prop="discount">
          <InputNumber :max="10" :min="0" v-model="data.discount"></InputNumber>
        </FormItem>

        <FormItem label="折扣后金额" prop="amount_dis">
          <Input v-model="data.amount_dis" disabled></Input>
        </FormItem>

        <FormItem label="结算方式" prop="warranty_months">
          <Select :value="data.warranty_months">
            <Option
              v-for="(type, index) in select.settlementMothedList"
              :key="index"
              :value="index"
            >{{type}}</Option>
          </Select>
        </FormItem>

        <FormItem label="结算日期" prop="warranty_date">
          <DatePicker
            type="date"
            placeholder="结算日期"
            :value="data.warranty_date"
            @on-change="date => this.data.warranty_date = date"
            :start-date="new Date()"
          ></DatePicker>
        </FormItem>

        <FormItem label="备注" prop="remark" style="width: 100%;">
          <Input type="textarea" v-model="data.remark"></Input>
        </FormItem>
      </Form>
    </div>
  </custom-modal>
</template>

<script>
import ModalMixin from "@/mixins/modal";
import AreaMixin from "@/mixins/area";

import { addRepairAction } from "@/api/order_flow/repair";
import * as orderConst from "@/constants/order_flow";

export default {
  name: "materiel-add",
  mixins: [ModalMixin, AreaMixin],
  data() {
    return {
      data: {
        service_order_id: 0,
        base_part_id: 0,
        base_code_id: 0,
        service_id: 0,
        name: "",
        code: "",
        number: "",
        model: "",
        content: "",
        workday: 0,
        area: "",
        price: 0,
        unit: "PCS",
        quantity: 1,
        amount: 0,
        discount: 10,
        amount_dis: 0,
        warranty_months: 1,
        warranty_date: "",
        remark: "",
        serial_number: "",
        code: {}
      },
      fault: {},
      rules: {
        // base_part_id: [
        //   {required: true, message: '配件不能为空', trigger: 'blur'}
        // ],
        number: [{ required: true, message: "料号不能为空", trigger: "blur" }],
        name: [{ required: true, message: "品名不能为空", trigger: "blur" }]
      },
      select: {
        isLandList: orderConst.SERVICE_LAND_TRAFFIC,
        isHotelList: orderConst.SERVICE_HOTEL,
        isCompleteList: orderConst.SERVICE_COMPLETE,
        settlementMothedList: orderConst.SERVICE_SETTLEMENT_METHOD
      },
      init: {
        department: [],
        staff: [],
        service: [],
        part: []
      }
    };
  },
  methods: {
    onSubmit(e) {
      this.$refs.addForm.validate(async valid => {
        if (valid) {
          try {
            let data = await addRepairAction(
              this.data,
              this.data.service_order_id,
              "parts"
            );
            console.log("data", data);
            this.withRefresh(e);
          } catch (e) {
            this.closeLoading();
          }
        } else {
          this.closeLoading();
        }
      });
    },
    setDataBefore(data) {
      // this.fault = data.fault[0]
      this.data.service_order_id = (data && data.id) || 0;
    },
    onCancel(e) {
      e();
    },
    async beforeOpen() {
      return true;
    },
    async codeChange(codeId) {
      this.data.base_code_id = codeId;
    },
    async codeChangeData(code) {
      this.data.base_code_id = code.id;
      // this.data.staff_name = code.name
      this.data.code = code;
      // this.data.serial_number = code.serial_number
    },
    async partChange(partId) {
      this.data.base_part_id = partId;
    },
    async partChangeData(part) {
      this.data.base_part_id = part.id;
      this.data.number = part.number;
      this.data.name = part.name;
      this.data.model = part.model;
      this.data.brand = part.brand;
      this.data.unit = part.unit;
      this.data.price = part.price_sale_unified;
      this.codeChangeData(part.code);
    }
  },
  watch: {
    "data.quantity"(quantity) {
      this.data.amount = quantity * this.data.price;
      this.data.amount_dis = (this.data.amount * this.data.discount) / 10;
    },
    "data.price"(price) {
      this.data.amount = price * this.data.quantity;
      this.data.amount_dis = (this.data.amount * this.data.discount) / 10;
    },
    "data.discount"(discount) {
      this.data.amount_dis = (this.data.amount * discount) / 10;
    }
  }
};
</script>

<style>
.add-repairs {
  border-bottom: 1px solid #aaa;

  margin-bottom: 20px;
}
</style>
