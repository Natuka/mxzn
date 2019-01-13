<template>
  <custom-modal
    ref="ref"
    width="1000px"
    title="设备二维码-新增"
    @on-submit="onSubmit"
    @on-cancel="onCancel"
    class="mxcs-two-column"
  >
      <div>
      <Form :model="data"
            ref="addForm"
            :rules="rules"
            :label-width="100">
        <FormItem label="编号:" prop="number">
          <Input v-model="data.number" placeholder="编号(唯一)"></Input>
        </FormItem>

        <FormItem label="设备名称:" prop="name">
          <Input v-model="data.name" placeholder="设备名称"></Input>
        </FormItem>

        <FormItem label="设备配置:" prop="model">
          <Input v-model="data.model" placeholder="设备配置"></Input>
        </FormItem>

        <FormItem label="系列号:" prop="serial_number">
          <Input v-model="data.serial_number" placeholder="系列号"></Input>
        </FormItem>

        <FormItem label="制造日期" prop="manufacture_date">
          <DatePicker
            type="date"
            placeholder="制造日期"
            v-model="data.manufacture_date"
            @on-change="date => this.data.manufacture_date = date"
          ></DatePicker>
        </FormItem>
        <FormItem label="采购日期" prop="purchase_date">
          <DatePicker
            type="date"
            placeholder="采购日期"
            v-model="data.purchase_date"
            @on-change="date => this.data.purchase_date = date"
          ></DatePicker>
        </FormItem>

        <FormItem label="备注:" prop="remark" style="width: 100%">
          <Input v-model="data.remark" placeholder="备注"></Input>
        </FormItem>

        <FormItem label="建立人员">
          <Input v-model="data.created_by" placeholder="建立人员" disabled></Input>
        </FormItem>
        <FormItem label="建立日期">
          <Input v-model="data.created_at" placeholder="建立日期" disabled></Input>
        </FormItem>
        <FormItem label="最近修改人员">
          <Input v-model="data.updated_by" placeholder="最近修改人员" disabled></Input>
        </FormItem>
        <FormItem label="最近修改日期">
          <Input v-model="data.updated_at" placeholder="最近修改日期" disabled></Input>
        </FormItem>

        </Form>
      </div>
  </custom-modal>
</template>

<script>

import ModalMixin from '@/mixins/modal'

import {addMachineqrcode} from '../../api/machineqrcode'

// import * as machineConst from '../../constants/machine'

export default {
  name: 'machineqrcode-add',
  mixins: [ModalMixin],
  data () {
    return {
      data: {
        number: '',
        name: '',
        model: '',
        manufacture_date: '',
        purchase_date: '',
        serial_number: '',
        remark: ''
      },
      initData: {},
      rules: {
        number: [
          {required: true, message: '编码不能为空', trigger: 'blur'}
        ],
        name: [
          {required: true, message: '设备名称不能为空', trigger: 'blur'}
        ],
        model: [
          {required: true, message: '设备配置不能为空', trigger: 'blur'}
        ]
      }
    }
  },
  // 数据初始化
  created () {
    this.initData = {...this.data}
    // console.log('initData4563', this.initData)
  },
  methods: {
    onSubmit (e) {
      this.$refs.addForm.validate(async (valid) => {
        if (valid) {
          try {
            let data = await addMachineqrcode(this.data)
            console.log('data', data)
            this.data = {...this.initData}
            this.withRefresh(e)
          } catch (e) {
            this.closeLoading()
          }
        } else {
          this.closeLoading()
        }
      })
    },
    onCancel (e) {
      this.data = {...this.initData}
      e()
    }
  }
}
</script>
