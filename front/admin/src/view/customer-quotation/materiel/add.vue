<template>
  <custom-modal
    ref="ref"
    width="1000px"
    title="报价单-配件耗材-新增"
    @on-submit="onSubmit"
    @on-cancel="onCancel"
    class="mxcs-two-column my-modal"
  >
    <div test="1245">
      <Form :model="data" ref="addForm" :rules="rules" :label-width="90" class="mxcs-two-column">
        <FormItem label="配件" prop="base_part_id">
          <remote-select
            :init="data.base_part_id"
            :initData="init.part"
            placeholder="模糊查询(料号,品名,规格)"
            label="show_name"
            url="select/part"
            @on-change="partChange"
            @on-change-data="partChangeData"
          ></remote-select>
        </FormItem>

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
          <Input v-model="data.price"></Input>
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

        <FormItem label="折扣后金额" prop="discount_amount">
          <Input v-model="data.discount_amount" disabled></Input>
        </FormItem>

        <FormItem label="税率" prop="tax_rate">
          <RadioGroup v-model="data.tax_rate">
            <Radio :label="16">
              <span>16%</span>
            </Radio>
            <Radio :label="10">
              <span>10%</span>
            </Radio>
            <Radio :label="6">
              <span>6%</span>
            </Radio>
            <Radio :label="0">
              <span>不含税</span>
            </Radio>
          </RadioGroup>
        </FormItem>

        <FormItem label="交货日期" prop="delivery_date">
          <DatePicker
            type="date"
            placeholder="交货日期"
            :value="data.delivery_date"
            @on-change="date => this.data.delivery_date = date"
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

import { addMaterielAction } from "@/api/customerquotation";
import {selectPart} from '../../../api/select/part'

export default {
  name: "materiel-add",
  mixins: [ModalMixin, AreaMixin],
  data() {
    return {
      data: {
        quotation_id: 0,
        item_id: 0,
        name: "",
        number: "",
        model: "",
        price: 0,
        unit: "PCS",
        quantity: 1,
        amount: 0,
        discount: 10,
        discount_amount: 0,
        tax_rate: 6,
        delivery_date: "",
        remark: ""
      },
      initData: {},
      rules: {
        // item_id: [
        //   {required: true, message: '配件不能为空', trigger: 'blur'}
        // ],
        number: [{ required: true, message: "料号不能为空", trigger: "blur" }],
        name: [{ required: true, message: "品名不能为空", trigger: "blur" }]
      },
      init: {
        part: []
      }
    };
  },
  // 数据初始化
  created () {
    this.initData = {...this.data}
    // console.log('initData4563', this.initData)
  },
  methods: {
    onSubmit(e) {
      this.$refs.addForm.validate(async valid => {
        if (valid) {
          try {
            console.log("data3423452", this.data);
            let data = await addMaterielAction(
              this.data,
              this.data.quotation_id,
              "materiel"
            );
            console.log("data", data);
            this.data = {...this.initData}
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
      this.data.quotation_id = (data && data.id) || 0;
    },
    onCancel(e) {
      this.data = {...this.initData}
      e();
    },
    async beforeOpen() {
      return true;
    },
    async afterOpen () {
      let data = this.data

      let parts = await selectPart({id: data.customer_id})
      this.init.part = parts.data

      return true
    },
    async partChange(partId) {
      this.data.item_id = partId;
    },
    async partChangeData(part) {
      this.data.item_id = part.id;
      this.data.number = part.number;
      this.data.name = part.name;
      this.data.model = part.model;
      // this.data.brand = part.brand;
      this.data.unit = part.unit;
      this.data.price = part.price_sale_unified;
    }
  },
  watch: {
    "data.quantity"(quantity) {
      this.data.amount = quantity * this.data.price;
      this.data.discount_amount = (this.data.amount * this.data.discount) / 10;
    },
    "data.price"(price) {
      this.data.amount = price * this.data.quantity;
      this.data.discount_amount = (this.data.amount * this.data.discount) / 10;
    },
    "data.discount"(discount) {
      this.data.discount_amount = (this.data.amount * discount) / 10;
    }
  }
};
</script>

<style>
.add-repairs {
  border-bottom: 1px solid #aaa;

  margin-bottom: 20px;
}
.my-modal .ivu-modal-wrap {z-index:1002}
</style>
