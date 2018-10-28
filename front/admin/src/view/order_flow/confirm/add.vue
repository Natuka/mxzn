<template>
  <custom-modal
    ref="ref"
    width="1200px"
    title="工单确认-新增"
    @on-submit="onSubmit"
    @on-cancel="onCancel"
    class="mxcs-three-column"
  >
    <div>
      <Form :model="data"
            ref="addForm"
            :rules="rules"
            :label-width="90"
      >
        <FormItem label="服务单号" prop="number">
          <Input v-model="data.number" placeholder="服务单号" disabled></Input>
        </FormItem>

        <FormItem label="受理时间" prop="receive_at">
          <DatePicker
            type="datetime"
            placeholder="受理时间"
            :value="data.receive_at"
            @on-change="date => this.data.receive_at = date"
          ></DatePicker>
        </FormItem>

        <FormItem label="受理人员" prop="receive_staff_id">
          <remote-select
            :init="data.receive_staff_id"
            :initData="init.receiveStaff"
            label="name"
            url="select/staff"
            @on-change="receiveStaffChange"
            @on-change-data="receiveStaffChangeData"
          ></remote-select>
        </FormItem>

        <FormItem label="服务类别" prop="type">
          <Select v-model="data.type" disabled>
            <Option
              v-for="(type, index) in select.type"
              :key="index"
              :value="index"
            >{{type}}
            </Option>
          </Select>
        </FormItem>

        <FormItem label="受理来源" prop="source">
          <Select v-model="data.source">
            <Option
              v-for="(type, index) in select.source"
              :key="index"
              :value="index"
            >{{type}}
            </Option>
          </Select>
        </FormItem>

        <FormItem label="紧急程度" prop="emergency_degree">
          <Select v-model="data.emergency_degree">
            <Option
              v-for="(type, index) in select.degree"
              :key="index"
              :value="index"
            >{{type}}
            </Option>
          </Select>
        </FormItem>

        <FormItem label="客户名称" prop="customer_id">
          <remote-select
            :init="data.customer_id"
            :initData="init.customer"
            label="name"
            url="select/customer"
            @on-change="customerChange"
            @on-change-data="customerChangeData"
          ></remote-select>

        </FormItem>

        <FormItem label="报修人员" prop="feedback_staff_id">
          <static-select
            :init="init.feedback_staff_id"
            :data="select.customerConcatList"
            label="name"
            @on-change-data="feedbackStaffChangeData"
          ></static-select>

        </FormItem>

        <FormItem label="手机" prop="mobile">
          <Input :value="data.mobile" placeholder="手机" readonly></Input>
        </FormItem>

        <FormItem label="服务级别">
          <Input :value="customerLevel" placeholder="服务级别" readonly></Input>
        </FormItem>

        <FormItem label="报修时间" prop="feedback_at">
          <DatePicker
            type="datetime"
            placeholder="报修时间"
            :value="data.feedback_at"
            @on-change="date => this.data.feedback_at = date"
          ></DatePicker>
        </FormItem>

        <FormItem label="地址" prop="address" style="width: 100%;">
          <Input
            type="textarea"
            v-model="data.customer.address"
            placeholder="地址"
          ></Input>
        </FormItem>

        <FormItem label="设备编号" prop="machine_id">
          <static-select
            :init="init.machine_id"
            :data="select.customerEquipmentList"
            label="name"
            @on-change-data="machineChange"
          ></static-select>
        </FormItem>
        <FormItem label="型号规格" prop="model">
          <Input v-model="data.equipment.model" placeholder="型号规格" readonly></Input>
        </FormItem>

        <FormItem label="合同编号" prop="contract_number">
          <Input v-model="data.equipment.contract_number" placeholder="合同编号" readonly></Input>
        </FormItem>

        <FormItem label="类别" prop="equipmentType">
          <Input :value="equipmentType" placeholder="类别" readonly></Input>
        </FormItem>

        <FormItem label="安装日期" prop="equipment.installation_date">
          <Input v-model="data.equipment.installation_date" placeholder="安装日期" readonly></Input>
        </FormItem>

        <FormItem label="保修日期" prop="equipment.warranty_date">
          <Input v-model="data.equipment.warranty_date" placeholder="保修日期" readonly></Input>
        </FormItem>

        <FormItem label="确认工程师" prop="confirm_staff_id">
          <remote-select
            :init="data.confirm_staff_id"
            :initData="init.confirm_staff"
            label="staff_name"
            url="select/engineer"
            @on-change="confirmStaffChange"
            @on-change-data="confirmStaffChangeData"
          ></remote-select>
        </FormItem>

        <FormItem label="确认时间" prop="confirm_at">
          <DatePicker
            type="datetime"
            placeholder="确认时间"
            :value="data.confirm_at"
            @on-change="date => this.data.confirm_at = date"
          ></DatePicker>
        </FormItem>
      </Form>

      <Tabs type="card" v-model="tabsIndex" :index="tabsIndex" :animated="false" class="tabs">
        <TabPane label="故障信息" name="0">
          <Form :model="data"
                ref="addForm2"
                :rules="rules"
                :label-width="90"
                v-show="tabsIndex === '0'"
          >
            <FormItem label="故障描述" prop="fault.desc" class="form-item-auto-height">
              <Input
                type="textarea"
                v-model="data.fault.desc"
                row="10"
              ></Input>
            </FormItem>
            <FormItem label="故障类型" prop="fault.type">
              <Select v-model="data.fault.type">
                <Option
                  v-for="(type, index) in select.faultType"
                  :key="index"
                  :value="index"
                >{{type}}
                </Option>
              </Select>
            </FormItem>
            <FormItem label="故障频率" prop="fault.sequence">
              <Select v-model="data.fault.sequence">
                <Option
                  v-for="(type, index) in select.sequenceType"
                  :key="index"
                  :value="index"
                >{{type}}
                </Option>
              </Select>
            </FormItem>
            <FormItem label="线路是否破损" prop="fault.is_line_broken">
              <Select v-model="data.fault.is_line_broken">
                <Option
                  v-for="(type, index) in select.lineBroken"
                  :key="index"
                  :value="index"
                >{{type}}
                </Option>
              </Select>
            </FormItem>
            <FormItem label="部品是否损坏" prop="fault.is_part_broken">
              <Select v-model="data.fault.is_part_broken">
                <Option
                  v-for="(type, index) in select.partBroken"
                  :key="index"
                  :value="index"
                >{{type}}
                </Option>
              </Select>
            </FormItem>
            <FormItem label="故障频率" prop="fault.sequence">
              <Select v-model="data.fault.sequence">
                <Option
                  v-for="(type, index) in select.sequenceType"
                  :key="index"
                  :value="index"
                >{{type}}
                </Option>
              </Select>
            </FormItem>

          </Form>
        </TabPane>
        <TabPane label="设备资料" name="1">
          <Form :model="data"
                ref="addForm3"
                :rules="rules"
                :label-width="90"
                v-show="tabsIndex === '1'"
          >
            <FormItem label="技术专管" prop="equipment.technology_staff">
              <Input v-model="data.equipment.technology_staff" readonly></Input>
            </FormItem>
            <FormItem label="安装人员" prop="equipment.installation_staff">
              <Input v-model="data.equipment.installation_staff" readonly></Input>
            </FormItem>
            <FormItem label="设备名称" prop="equipment.name">
              <Input v-model="data.equipment.name" readonly></Input>
            </FormItem>
            <FormItem label="验收日期" prop="equipment.acceptance_date">
              <Input v-model="data.equipment.acceptance_date" readonly></Input>
            </FormItem>
            <FormItem label="制造日期" prop="equipment.manufacture_date">
              <Input v-model="data.equipment.manufacture_date" readonly></Input>
            </FormItem>
            <FormItem label="本体编号" prop="equipment.main_no">
              <Input v-model="data.equipment.main_no" readonly></Input>
            </FormItem>
            <FormItem label="本体型号" prop="equipment.model">
              <Input v-model="data.equipment.model" readonly></Input>
            </FormItem>
            <FormItem label="控制箱编号" prop="equipment.control_box_no">
              <Input v-model="data.equipment.control_box_no" readonly></Input>
            </FormItem>
            <FormItem label="控制箱型号" prop="equipment.technology_staff">
              <Input v-model="data.equipment.technology_staff" readonly></Input>
            </FormItem>
            <FormItem label="焊机编号" prop="equipment.welding_machine_no">
              <Input v-model="data.equipment.welding_machine_no" readonly></Input>
            </FormItem>
            <FormItem label="焊机型号" prop="equipment.welding_machine_model">
              <Input v-model="data.equipment.welding_machine_model" readonly></Input>
            </FormItem>

            <FormItem label="1轴编号" prop="equipment.axis1_no">
              <Input v-model="data.equipment.axis1_no" readonly></Input>
            </FormItem>
            <FormItem label="2轴编号" prop="equipment.axis2_no">
              <Input v-model="data.equipment.axis2_no" readonly></Input>
            </FormItem>
            <FormItem label="3轴编号" prop="equipment.axis3_no">
              <Input v-model="data.equipment.axis3_no" readonly></Input>
            </FormItem>
            <FormItem label="4轴编号" prop="equipment.axis4_no">
              <Input v-model="data.equipment.axis4_no" readonly></Input>
            </FormItem>
            <FormItem label="5轴编号" prop="equipment.axis5_no">
              <Input v-model="data.equipment.axis5_no" readonly></Input>
            </FormItem>
            <FormItem label="6轴编号" prop="equipment.axis6_no">
              <Input v-model="data.equipment.axis6_no" readonly></Input>
            </FormItem>

            <FormItem label="中文编码" prop="equipment.code_chinese">
              <Input v-model="data.equipment.code_chinese" readonly></Input>
            </FormItem>
            <FormItem label="序列号" prop="equipment.number">
              <Input v-model="data.equipment.number" readonly></Input>
            </FormItem>
            <FormItem label="安装次数" prop="equipment.maintenance_times">
              <Input v-model="data.equipment.maintenance_times" readonly></Input>
            </FormItem>
          </Form>
        </TabPane>
      </Tabs>

      <Form :model="data"
            ref="addForm4"
            :rules="rules"
            :label-width="100"
      >

        <FormItem label="安装工程师" props="engineer_id">
          <remote-select
            :init="data.engineer_ids"
            :initData="init.engineers"
            :multiple="true"
            label="staff_name"
            url="select/engineer"
            @on-change="engineerChange"
            @on-change-data="engineerChangeData"
          ></remote-select>
        </FormItem>

        <FormItem label="是否上门服务">
          <Select v-model="data.is_out">
            <Option
              v-for="(type, index) in select.out"
              :key="index"
              :value="index"
            >{{type}}
            </Option>
          </Select>
        </FormItem>

        <FormItem label="预计上门时间" prop="plan_out_at">
          <DatePicker
            type="datetime"
            placeholder="预计上门时间"
            :value="data.plan_out_at"
            @on-change="date => this.data.plan_out_at = date"
            :start-date="new Date()"
          ></DatePicker>
        </FormItem>

        <FormItem label="预计完成时间" prop="plan_finish_at">
          <DatePicker
            type="datetime"
            placeholder="预计完成时间"
            :value="data.plan_finish_at"
            @on-change="date => this.data.plan_finish_at = date"
            :start-date="new Date()"
          ></DatePicker>
        </FormItem>

        <FormItem label="是否服务收费">
          <Select v-model="data.is_charge">
            <Option
              v-for="(type, index) in select.charge"
              :key="index"
              :value="index"
            >{{type}}
            </Option>
          </Select>
        </FormItem>

        <FormItem label="是否报价">
          <Select v-model="data.is_quote">
            <Option
              v-for="(type, index) in select.quote"
              :key="index"
              :value="index"
            >{{type}}
            </Option>
          </Select>
        </FormItem>

        <FormItem label="报价附件">

        </FormItem>

      </Form>
    </div>
  </custom-modal>
</template>

<script>

import ModalMixin from '@/mixins/modal'
import AreaMixin from '@/mixins/area'

import {addConfirm} from '@/api/order_flow/confirm'
import {selectDepartment} from '@/api/select/department'
import {selectCustomerContact} from '@/api/select/customer-contact'
import {selectCustomerEquipment} from '@/api/select/customer-equipment'
import * as orderConst from '@/constants/order_flow'
import * as orderMachineConst from '@/constants/machine'
import * as orderFaultConst from '@/constants/order_fault'
import * as customerConst from '@/constants/customer'
import dayjs from 'dayjs'

import * as validate from '@/libs/validate'

const currentDate = dayjs().format('YYYY-MM-DD HH:mm:ss')

export default {
  name: 'confirm-add',
  mixins: [ModalMixin, AreaMixin],
  data () {
    return {
      tabsIndex: '0',
      data: {
        customer_id: 0,
        feedback_staff_id: 0,
        receive_staff_id: 0,
        confirm_staff_id: 0,
        emergency_degree: 0,
        number: '',
        mobile: '',
        feedback_at: '',
        receive_at: currentDate,
        confirm_at: '',
        plan_out_at: '',
        plan_finish_at: '',
        is_out: 0,
        is_charge: 0, // 是否服务收费
        is_quote: 0, // 是否报价
        settle_status: 0,
        status: 0,
        source: 0,
        type: 1, // 安装工单
        level: 0,
        address: '',
        remark: '',
        engineers: [],
        engineer_ids: [], // 工程师列表
        machine_id: 0,
        customer: {
          id: 0,
          erp_cust_id: 0,
          number: '',
          name_short: '',
          industry: '',
          name: '',
          address: '',
          type: 0,
          level: 0,
          follow_up_status: 0,
          source: 0,
          staff_scale: 0,
          purchasing_power: 0
        },
        equipment: {
          type: 0,
          model: '',
          installation_staff: '',
          technology_staff: '',
          number: '',
          sets: '',
          main_no: '',
          control_box_no: '',
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
          remark: '',
          contract_number: '',
          name: '',
          code_id: 0
        },
        fault: {
          type: 0, // 故障类型
          sequence: 0, // 故障频率
          is_line_broken: 0, // 线路是否破损
          is_part_broken: 0, // 部品是否损坏
          desc: '',
          code: '', // 故障代码
          file: '', // 故障附件
          remark: '' // 备注
        }
      },
      rules: {
        name: [
          validate.notEmpty('姓名不能为空')
        ],
        customer_id: [
          validate.number('请选择客户')
        ],
        feedback_staff_id: [
          validate.number('请选择报修人员')
        ],
        receive_staff_id: [
          validate.number('请选择受理人员')
        ],
        source: [
          validate.number('请选择受理来源')
        ],
        emergency_degree: [
          validate.number('请选择紧急程度')
        ],
        machine_id: [
          validate.number('请选择设备编号')
        ],
        receive_at: [
          validate.notEmpty('受理时间不能为空')
        ],
        feedback_at: [
          validate.notEmpty('报修时间不能为空')
        ],
        plan_out_at: [
          validate.notEmpty('预计上门时间不能为空')
        ],
        plan_finish_at: [
          validate.notEmpty('预计完成时间不能为空')
        ],
        'fault.desc': [
          validate.notEmpty('故障描述不能为空')
        ]
      },
      select: {
        source: orderConst.ORDER_SOURCE,
        type: orderConst.ORDER_TYPE,
        degree: orderConst.ORDER_DEGREE,
        quote: orderConst.ORDER_QUOTE,
        charge: orderConst.ORDER_CHARGE,
        out: orderConst.ORDER_OUT,
        equipmentType: orderMachineConst.TYPE,
        faultType: orderFaultConst.FAULT_TYPE,
        sequenceType: orderFaultConst.SEQUENCE_TYPE,
        lineBroken: orderFaultConst.LINE_BROKEN,
        partBroken: orderFaultConst.PART_BROKEN,
        customerLevel: this.listByConstant(customerConst.LEVEL_LIST),
        customerConcatList: [],
        customerEquipmentList: []
      },
      init: {
        customer: [],
        organization: [],
        receiveStaff: [],
        engineers: [],
        confirm_staff: []
      }
    }
  },
  computed: {
    // 机器设备类型
    equipmentType () {
      let {equipmentType} = this.select
      let {type} = this.data.equipment
      return equipmentType[type] ? equipmentType[type] : ''
    },
    faultType () {
      let {faultType} = this.select
      let {type} = this.data.fault
      return faultType[type] ? faultType[type] : ''
    },
    sequenceType () {
      let {sequenceType} = this.select
      let {type} = this.data.fault
      return sequenceType[type] ? sequenceType[type] : ''
    },
    customerLevel () {
      let {customerLevel} = this.select
      let {level} = this.data.customer
      let info = customerLevel.find(info => info.index === level)
      if (info) {
        return info.value
      }
      return ''
    }
  },
  methods: {
    onSubmit (e) {
      let refs = this.$refs
      let promises = ['', 2, 3, 4].map(i => {
        return new Promise((resolve, reject) => {
          refs['addForm' + i].validate(async (valid) => {
            if (valid) {
              resolve()
            } else {
              reject(new Error('验证失败'))
            }
          })
        })
      })

      Promise.all(promises).then(async () => {
        console.log('success')
        await addConfirm(this.data)
        this.withRefresh(e)
      }).catch(err => {
        console.log('failed', err)
        this.closeLoading()
      })
    },
    onCancel (e) {
      e()
    },
    async beforeOpen () {
      console.log('currentDate', currentDate)
      return true
    },
    async organizationChange (id) {
      this.data.org_id = id
      if (!id) {
        return
      }
      let {data} = await selectDepartment(id)
      this.select.department = data || []
      if (data.length) {
        let info = data.find(info => +info.id === +this.data.dep_id)
        if (!info) {
          this.data.dep_id = data[0].id
        }
      }
    },
    // 省变更
    async provinceChange (provinceId) {
      if (+this.data.province_id !== +provinceId) {
        this.data.province_id = provinceId
        let cities = await this.getCities(provinceId)
        if (!this.hasArea(cities, this.data.city_id)) {
          this.cityChange(cities[0].id)
        }
      }
    },
    async customerChange (customerId) {
      this.data.customer_id = customerId
    },
    // 客户变更
    async customerChangeData (customer) {
      this.data.customer_id = customer.id
      this.data.customer = customer
      // console.log('customer', customer)
      let {data} = await selectCustomerContact(customer.id)
      this.select.customerConcatList = data
      let equipments = await selectCustomerEquipment(customer.id, '')
      this.select.customerEquipmentList = equipments.data
    },
    async feedbackStaffChangeData (contact) {
      this.data.feedback_staff_id = contact.id
      this.data.mobile = contact.mobile
    },
    async confirmStaffChange (staffId) {
      this.data.confirm_staff_id = staffId
    },
    async confirmStaffChangeData (staff) {
      console.log('staff', staff)
      // this.data.confirm_staff_id = staff
    },
    async machineChange (machine) {
      this.data.machine_id = machine.id
      this.data.equipment = machine
    },
    async receiveStaffChange (staffId) {
      this.data.receive_staff_id = staffId
    },
    async receiveStaffChangeData (staff) {
      this.data.receive_staff_id = staff.id
      this.data.receive_staff = staff
    },
    async engineerChange () {
    },
    async engineerChangeData (engineers = []) {
      this.data.engineer_id = engineers[0] ? engineers[0].id : 0
      this.data.engineers = engineers
      console.log('engineers', engineers)
    }
  }
}
</script>

<style scoped>
  .tabs >>> .ivu-tabs-bar {
    margin-bottom: 0px;
  }

  .tabs >>> .ivu-tabs-content {
    padding-top: 16px;
    border: 1px solid #dcdee2;
    border-top: 0;
  }

  .tabs {
    margin-bottom: 16px;
  }
</style>
