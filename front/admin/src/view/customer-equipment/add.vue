<template>
  <custom-modal
    ref="ref"
    width="1000px"
    title="客户设备-新增"
    @on-submit="onSubmit"
    @on-cancel="onCancel"
    class="mxcs-three-column"
  >
    <div>
      <Form :model="data"
            ref="addForm"
            :rules="rules"
            :label-width="100"
      >
        <FormItem label="客户名称" prop="cust_id">
          <remote-select
            :init="data.cust_id"
            :initData="init.customer"
            label="name"
            url="select/customer"
            :filter="(data) => data.name"
            :valueMap="(data) => data.id"
            @on-change="customerChange"
          ></remote-select>
        </FormItem>
        <FormItem label="设备编号" prop="number">
          <Input v-model="data.number" placeholder="设备编号"></Input>
        </FormItem>
        <FormItem label="设备名称" prop="name">
          <Input v-model="data.name" placeholder="设备名称"></Input>
        </FormItem>
        <FormItem label="物料名称" prop="item_id">
          <remote-select
            :init="data.item_id"
            :initData="init.materiel"
            label="name"
            url="select/materiel"
            :filter="(data) => data.name"
            :valueMap="(data) => data.id"
            @on-change-data="materielChange"
          ></remote-select>
        </FormItem>
        <FormItem label="规格型号" prop="model">
          <Input v-model="data.model" placeholder="规格型号" readonly></Input>
        </FormItem>
        <FormItem label="类别" prop="type">
          <Select v-model="data.type">
            <Option
              v-for="(type, index) in typeList"
              :key="index"
              :value="index"
            >{{type}}
            </Option>
          </Select>
        </FormItem>
        <FormItem label="合同编号" prop="contract_number">
          <Input v-model="data.contract_number" placeholder="合同编号"></Input>
        </FormItem>
        <FormItem label="安装人员" prop="installation_staff">
          <Input v-model="data.installation_staff" placeholder="安装人员"></Input>
        </FormItem>
        <FormItem label="技术专管" prop="technology_staff">
          <Input v-model="data.technology_staff" placeholder="技术专管"></Input>
        </FormItem>

        <FormItem label="设备配置" prop="sets">
          <Input v-model="data.sets" placeholder="设备配置"></Input>
        </FormItem>
        <FormItem label="本体编号" prop="main_no">
          <Input v-model="data.main_no" placeholder="本体编号"></Input>
        </FormItem>
        <FormItem label="本体型号" prop="main_model">
          <Input v-model="data.main_model" placeholder="本体型号"></Input>
        </FormItem>
        <FormItem label="控制箱编号" prop="control_box_no">
          <Input v-model="data.control_box_no" placeholder="控制箱编号"></Input>
        </FormItem>
        <FormItem label="控制箱型号" prop="control_box_model">
          <Input v-model="data.control_box_model" placeholder="控制箱型号"></Input>
        </FormItem>
        <FormItem label="焊机编号" prop="welding_machine_no">
          <Input v-model="data.welding_machine_no" placeholder="焊机编号"></Input>
        </FormItem>
        <FormItem label="焊机型号" prop="welding_machine_model">
          <Input v-model="data.welding_machine_model" placeholder="焊机型号"></Input>
        </FormItem>
        <FormItem label="1轴编号" prop="axis1_no">
          <Input v-model="data.axis1_no" placeholder="1轴编号"></Input>
        </FormItem>
        <FormItem label="2轴编号" prop="axis2_no">
          <Input v-model="data.axis2_no" placeholder="2轴编号"></Input>
        </FormItem>
        <FormItem label="3轴编号" prop="axis3_no">
          <Input v-model="data.axis3_no" placeholder="3轴编号"></Input>
        </FormItem>
        <FormItem label="4轴编号" prop="axis4_no">
          <Input v-model="data.axis4_no" placeholder="4轴编号"></Input>
        </FormItem>
        <FormItem label="5轴编号" prop="axis5_no">
          <Input v-model="data.axis5_no" placeholder="5轴编号"></Input>
        </FormItem>
        <FormItem label="6轴编号" prop="axis6_no">
          <Input v-model="data.axis6_no" placeholder="6轴编号"></Input>
        </FormItem>
        <FormItem label="中文编码" prop="code_chinese">
          <Input v-model="data.code_chinese" placeholder="中文编码"></Input>
        </FormItem>
        <FormItem label="识别码" prop="identification_code">
          <Input v-model="data.identification_code" placeholder="识别码"></Input>
        </FormItem>
        <FormItem label="制造日期" prop="manufacture_date">
          <DatePicker
            type="date"
            placeholder="制造日期"
            v-model="data.manufacture_date"
            @on-change="date => this.data.manufacture_date = date"
          ></DatePicker>
        </FormItem>
        <FormItem label="购买日期" prop="purchase_date">
          <DatePicker
            type="date"
            placeholder="购买日期"
            v-model="data.purchase_date"
            @on-change="date => this.data.purchase_date = date"
          ></DatePicker>
        </FormItem>
        <FormItem label="安装日期" prop="installation_date">
          <DatePicker
            type="date"
            placeholder="安装日期"
            v-model="data.installation_date"
            @on-change="date => this.data.installation_date = date"
          ></DatePicker>
        </FormItem>
        <FormItem label="验收日期" prop="acceptance_date">
          <DatePicker
            type="date"
            placeholder="验收日期"
            v-model="data.acceptance_date"
            @on-change="date => this.data.acceptance_date = date"
          ></DatePicker>
        </FormItem>
        <FormItem label="保修日期" prop="warranty_date">
          <DatePicker
            type="date"
            placeholder="保修日期"
            v-model="data.warranty_date"
            @on-change="date => this.data.warranty_date = date"
          ></DatePicker>
        </FormItem>
        <FormItem label="维修次数" prop="maintenance_times">
          <Input v-model="data.maintenance_times" ></Input>
        </FormItem>
        <FormItem label="备注">
          <Input v-model="data.remark" type="textarea" :autosize="{minRows: 2,maxRows: 5}"
                 placeholder="备注..."></Input>
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

import {addCustomerequipment} from '../../api/customerequipment'
import {selectCustomer} from '../../api/select/customer'
import {selectMateriel} from '../../api/select/materiel'
import * as customerequipmentConst from '../../constants/customerequipment'

export default {
  name: 'customerequipment-add',
  mixins: [ModalMixin],
  data () {
    return {
      data: {
        cust_id: 0,
        item_id: 0,
        type: 0,
        number: '',
        name: '',
        model: '',
        contract_number: '',
        installation_staff: '',
        technology_staff: '',
        sets: '',
        main_no: '',
        control_box_no: '',
        main_model: '',
        control_box_model: '',
        welding_machine_no: '',
        welding_machine_model: '',
        axis1_no: '',
        axis2_no: '',
        axis3_no: '',
        axis4_no: '',
        axis5_no: '',
        axis6_no: '',
        code_chinese: '',
        identification_code: '',
        manufacture_date: '',
        purchase_date: '',
        installation_date: '',
        acceptance_date: '',
        warranty_date: '',
        maintenance_times: '',
        created_by: '',
        updated_by: '',
        remark: ''
      },
      initData: {},
      rules: {
        // cust_id: [
        //   validate.number('请选择客户名称')
        // ],
        number: [
          {required: true, message: '设备编号不能为空', trigger: 'blur'}
        ],
        name: [
          {required: true, message: '设备名称不能为空', trigger: 'blur'}
        ]
      },
      typeList: customerequipmentConst.TYPE_LIST,
      init: {
        customer: [],
        materiel: []
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
            let data = await addCustomerequipment(this.data)
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
    },
    async beforeOpen () {
      return true
    },
    async afterOpen () {
      let data = this.data

      let customers = await selectCustomer({id: data.cust_id})
      this.init.customer = customers.data

      let materiels = await selectMateriel({id: data.item_id})
      this.init.materiel = materiels.data

      return true
    },
    async customerChange (customerId) {
      this.data.cust_id = customerId
    },
    async materielChange (materiel) {
      console.log('materiel879', materiel)
      this.data.item_id = materiel.id
      this.data.model = materiel.model
      // this.data.name = materiel.name
    }
  }
}
</script>
