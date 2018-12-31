<template>
  <custom-modal
    ref="ref"
    width="1200px"
    title="其他工单-修改"
    @on-submit="onSubmit"
    @on-cancel="onCancel"
    class="mxcs-three-column"
  >
    <div>
      <Form :model="data"
            ref="addForm"
            :rules="rules"
            :label-width="110"
      >
        <FormItem label="服务单号" prop="number">
          <Input v-model="data.number" placeholder="服务单号" disabled></Input>
        </FormItem>


        <FormItem label="预计开始时间" prop="plan_out_at">
          <DatePicker
            type="datetime"
            placeholder="预计开始时间"
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

        <FormItem label="服务类别" prop="type">
          <Select v-model="data.type">
            <Option
              v-for="(type, index) in select.type"
              :key="index"
              :value="index"
            >{{type}}
            </Option>
          </Select>
        </FormItem>

        <FormItem label="相关部门" prop="dep_id">
          <remote-select
            :init="data.dep_id"
            :initData="select.department"
            label="name"
            url="select/department"
            @on-change="(value) => this.data.dep_id = value"
          ></remote-select>
        </FormItem>

        <FormItem label="相关人员" prop="receive_staff_id">
          <remote-select
            :init="data.receive_staff_id"
            :initData="init.receiveStaff"
            label="name"
            url="select/staff"
            @on-change="receiveStaffChange"
            @on-change-data="receiveStaffChangeData"
          ></remote-select>
        </FormItem>

      </Form>

      <Tabs type="card" v-model="tabsIndex" :index="tabsIndex" :animated="false" class="tabs">
        <TabPane label="客户资料" name="0">
          <Form :model="data"
                ref="addForm2"
                :rules="rules"
                :label-width="90"
                v-show="tabsIndex === '0'"
          >

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

            <FormItem label="所属行业">
              <Input :value="customerIndustry" placeholder="所属行业" readonly></Input>
            </FormItem>

            <FormItem label="服务级别">
              <Input :value="customerLevel" placeholder="服务级别" readonly></Input>
            </FormItem>

            <FormItem label="联系人" prop="feedback_staff_id">
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

            <FormItem label="地址" prop="address" style="width: 99%;">
              <Input
                type="textarea"
                v-model="data.customer.address"
                placeholder="地址"
              ></Input>
            </FormItem>

          </Form>
        </TabPane>
      </Tabs>


      <Tabs type="card" v-model="tabsIndex3" :index="tabsIndex3" :animated="false" class="tabs">
        <TabPane label="服务人员" name="0">
          <Form :model="data"
                ref="addForm3"
                :rules="rules"
                :label-width="90"
                v-show="tabsIndex3 === '0'"
          >

            <FormItem label="工程师" props="engineer_id">
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


          </Form>
        </TabPane>
      </Tabs>

      <Tabs type="card" v-model="tabsIndex" :index="tabsIndex" :animated="false" class="tabs">
        <TabPane label="设备资料" name="0">
          <Form :model="data"
                ref="addForm9"
                :rules="rules"
                :label-width="90"
                v-show="tabsIndex === '0'"
          >

            <mx-order-materiel ref="materiel" :quotation_id="data.id"></mx-order-materiel>

          </Form>
        </TabPane>
      </Tabs>

      <Form :model="data"
            ref="addForm4"
            :rules="rules"
            :label-width="100"
      >
        <FormItem label="附件">
          <mx-upload-doc
            :multi="true"
            @on-change="handleDocChange"
          ></mx-upload-doc>
        </FormItem>
      </Form>


    </div>
  </custom-modal>
</template>

<script>

import ModalMixin from '@/mixins/modal'
import AreaMixin from '@/mixins/area'
import uploadDoc from '@/components/upload/doc'

import {addInstall} from '@/api/order_flow/install'
import {selectDepartment} from '@/api/select/department'
import {selectStaff} from '@/api/select/staff'
import {selectEngineer} from '@/api/select/engineer'
import {selectCustomer} from '@/api/select/customer'
import {selectCustomerContact} from '@/api/select/customer-contact'
import {selectCustomerEquipment} from '@/api/select/customer-equipment'
import * as orderConst from '@/constants/order_flow'
import * as orderMachineConst from '@/constants/machine'
import * as orderFaultConst from '@/constants/order_fault'
import * as customerConst from '@/constants/customer'
import * as customerequipmentConst from '@/constants/customerequipment'
import dayjs from 'dayjs'

import * as validate from '@/libs/validate'

const currentDate = dayjs().format('YYYY-MM-DD HH:mm:ss')

export default {
  name: 'repair-edit2',
  mixins: [ModalMixin, AreaMixin],
  components: {
    [uploadDoc.name]: uploadDoc
  },
  data () {
    return {
      tabsIndex: '0',
      tabsIndex3: '0',
      data: {
        customer_id: 0,
        dep_id: 0,
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
        }
      },
      rules: {
        customer_id: [
          validate.number('请选择客户')
        ],
        feedback_staff_id: [
          validate.number('请选择联系人')
        ],
        receive_staff_id: [
          validate.number('请选择相关人员')
        ],
        plan_out_at: [
          validate.notEmpty('预计开始时间不能为空')
        ],
        plan_finish_at: [
          validate.notEmpty('预计完成时间不能为空')
        ]
      },
      select: {
        type: orderConst.ORDER_TYPE2,
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
        customerIndustry: this.listByConstant(customerConst.INDUSTRY_LIST),
        customerConcatList: [],
        customerEquipmentList: [],
        department: []
      },
      init: {
        customer: [],
        organization: [],
        receiveStaff: [],
        engineers: []
      }
    }
  },
  computed: {
    customerLevel () {
      let {customerLevel} = this.select
      let {level} = this.data.customer
      let info = customerLevel.find(info => info.index === level)
      if (info) {
        return info.value
      }
      return ''
    },
    customerIndustry () {
      let {customerIndustry} = this.select
      let {industry} = this.data.customer
      let info = customerIndustry.find(info => info.index === industry)
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
          if (+i == 3 || +i == 4) {
            // 不验证
            resolve()
          } else {
            refs['addForm' + i].validate(async (valid) => {
              if (valid) {
                resolve()
              } else {
                reject(new Error('验证失败'))
              }
            })
          }
        })
      })
      console.log('onSubmit333', promises)
      Promise.all(promises).then(async () => {
        console.log('successxx')
        await addInstall(this.data)
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
    async afterOpen () {
      let data = this.data

      // TODO 加载工程师
      if (data.engineers && data.engineers.length) {
        this.init.engineers = data.engineers
        this.data.engineer_ids = data.engineers.map(info => info.id)
      }

      let customers = await selectCustomer({id: data.customer_id})
      this.init.customer = customers.data

      // 加载联系人
      if (data.feedback_staff) {
        this.init.feedback_staff_id = data.feedback_staff.id
        this.select.customerConcatList = [{...data.feedback_staff}]
        await this.feedbackStaffChangeData(data.feedback_staff)
      }

      let staffs = await selectStaff({id: data.receive_staff_id})
      this.init.receiveStaff = staffs.data

      let depts = await selectDepartment({id: data.dep_id})
      this.select.department = depts.data

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
    },
    async feedbackStaffChangeData (contact) {
      this.data.feedback_staff_id = contact.id
      this.data.mobile = contact.mobile
    },
    async confirmStaffChange (staffId) {
      // this.data.confirm_staff_id = staffId
    },
    async confirmStaffChangeData (staff) {
      console.log('staff5825', staff)
      // this.data.confirm_staff_id = staff.staff_id
      // this.data.confirm_staff_id = staff
    },
    async machineChange (machine) {
      this.data.equipment_id = machine.id
      // console.log('machine258', machine)
      this.data.equipment = machine
    },
    async receiveStaffChange (staffId) {
      this.data.receive_staff_id = staffId
    },
    async receiveStaffChangeData (staff) {
      this.data.receive_staff_id = staff.id
      this.data.receive_staff = staff

      // 关联出同个组织架构的工程师,ID有问题
      let engineers = await selectEngineer(staff.org_id)
      this.init.engineers = engineers.data
    },
    async engineerChange () {
    },
    async engineerChangeData (engineers = []) {
      this.data.engineer_id = engineers[0] ? engineers[0].id : 0
      this.data.engineers = engineers
      console.log('engineers', engineers)
    },
    async handleDocChange (files) {
      this.data.attach_ids = files.map(file => file.id).join(',')
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
