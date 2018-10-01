<template>
  <custom-modal
    ref="ref"
    width="1000px"
    title="设备管理-新增"
    @on-submit="onSubmit"
    @on-cancel="onCancel"
    class="mxcs-three-column"
  >
      <div>
        <Form :model="formItem" :label-width="100">
        <FormItem label="编号:" prop="number">
          <Input v-model="data.number" placeholder="编号"></Input>
        </FormItem>

        <FormItem label="名称:" prop="name">
          <Input v-model="data.name" placeholder="名称"></Input>
        </FormItem>

        <FormItem label="型号规格:" prop="model">
          <Input v-model="data.model" placeholder="型号规格"></Input>
        </FormItem>

        <FormItem label="品牌:" prop="brand">
          <Input v-model="data.brand" placeholder="品牌"></Input>
        </FormItem>

        <FormItem label="库存数量:" prop="stock_qty">
          <Input v-model="data.stock_qty" placeholder="库存数量"></Input>
        </FormItem>

        <FormItem label="单位:" prop="stock_qty">
          <Input v-model="data.stock_qty" placeholder="单位"></Input>
        </FormItem>

        <FormItem label="安全库存量:" prop="stock_qty">
          <Input v-model="data.safety_stock_qty" placeholder="安全库存量"></Input>
        </FormItem>

        <FormItem label="默认仓库:" prop="store">
          <Input v-model="data.store" placeholder="默认仓库"></Input>
        </FormItem>

        <FormItem label="平均采购单价:" prop="price_ave">
          <Input v-model="data.price_ave" placeholder="平均采购单价"></Input>
        </FormItem>

        <FormItem label="最近采购单价1:" prop="price_pur1">
          <Input v-model="data.price_pur1" placeholder="最近采购单价1"></Input>
        </FormItem>

        <FormItem label="最近采购单价2:" prop="price_pur2">
          <Input v-model="data.price_pur2" placeholder="最近采购单价2"></Input>
        </FormItem>

        <FormItem label="最近采购单价3:" prop="price_pur3">
          <Input v-model="data.price_pur3" placeholder="最近采购单价3"></Input>
        </FormItem>price_sale_unified

        <FormItem label="统一销售价:" prop="price_sale_unified">
          <Input v-model="data.price_sale_unified" placeholder="统一销售价"></Input>
        </FormItem>

        <FormItem label="最低销售价:" prop="price_sale_least">
          <Input v-model="data.price_sale_least" placeholder="最低销售价"></Input>
        </FormItem>

        <FormItem label="销售价1:" prop="price_sale1">
          <Input v-model="data.price_sale1" placeholder="销售价1"></Input>
        </FormItem>

        <FormItem label="销售价2:" prop="price_sale2">
          <Input v-model="data.price_sale2" placeholder="销售价2"></Input>
        </FormItem>

        <FormItem label="销售价3:" prop="price_sale3">
          <Input v-model="data.price_sale3" placeholder="销售价3"></Input>
        </FormItem>

        <FormItem label="供应商:" prop="vendor">
          <Input v-model="data.vendor" placeholder="供应商"></Input>
        </FormItem>

        <FormItem label="备注:" prop="remark">
          <Input v-model="data.remark" placeholder="备注"></Input>
        </FormItem>
        </Form>
      </div>
  </custom-modal>
</template>

<script>

import ModalMixin from '@/mixins/modal'

export default {
  name: 'machine-add',
  mixins: [ModalMixin],
  data () {
    return {
      formItem: {
        number: '',
        name: '',
        model: '',
        checkbox: [],
        switch: true,
        date: '',
        time: '',
        slider: [20, 50],
        textarea: ''
      }
    }
  },
  methods: {
    onSubmit (e) {
        //   console.log('onsubmit', e)
        // ....
      this.withRefresh(e)
    },
    onCancel (e) {
      console.log('oncancel', e)
      e()
    }
  }
}
</script>
