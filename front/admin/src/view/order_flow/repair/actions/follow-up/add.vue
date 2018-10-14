<template>
  <custom-modal
    ref="ref"
    width="1000px"
    title="催单-新增"
    @on-submit="onSubmit"
    @on-cancel="onCancel"
    class="mxcs-two-column"
  >
    <div test="1245">

      <Form :model="data"
            ref="addForm"
            :rules="rules"
            :label-width="90"
            class="mxcs-two-column"
      >
        <FormItem label="服务名称" prop="service_id">
          <remote-select
            :init="data.service_id"
            :initData="init.service"
            label="name"
            url="select/service"
            @on-change="serviceChange"
            @on-change-data="serviceChangeData"
          ></remote-select>
        </FormItem>

        <FormItem label="服务时间" prop="workday" >
          <Input
            v-model="data.workday"
            readonly
          ></Input>
        </FormItem>

        <FormItem label="服务内容" prop="content" style="width: 100%;">
          <Input
            type="textarea"
            v-model="data.content"
            readonly
          ></Input>
        </FormItem>

        <FormItem label="地区" prop="area" >
          <Input
            v-model="data.area"
            readonly
          ></Input>
        </FormItem>

        <FormItem label="单价" prop="price" >
          <Input
            v-model="data.price"
            readonly
          ></Input>
        </FormItem>

        <FormItem label="单位" prop="unit" >
          <Input
            v-model="data.unit"
            readonly
          ></Input>
        </FormItem>

        <FormItem label="数量" prop="quantity" >
          <Input
            v-model="data.quantity"
          ></Input>
        </FormItem>

        <FormItem label="金额" prop="amount" >
          <Input
            v-model="data.amount"
            readonly
          ></Input>
        </FormItem>

        <FormItem label="提成" prop="reward" >
          <Input
            v-model="data.reward"
          ></Input>
        </FormItem>

        <FormItem label="提成" prop="working_hours" >
          <Input
            v-model="data.working_hours"
          ></Input>
        </FormItem>

        <FormItem label="含陆运交通费" prop="is_land_traffic">
          <Select :value="data.is_land_traffic" disabled>
            <Option
              v-for="(type, index) in select.isLandList"
              :key="index"
              :value="index"
            >{{type}}
            </Option>
          </Select>
        </FormItem>

        <FormItem label="住宿" prop="is_hotel">
          <Select :value="data.is_hotel" disabled>
            <Option
              v-for="(type, index) in select.isHotelList"
              :key="index"
              :value="index"
            >{{type}}
            </Option>
          </Select>
        </FormItem>

        <FormItem label="结算方式" prop="settlement_method">
          <Select :value="data.settlement_method">
            <Option
              v-for="(type, index) in select.settlementMothedList"
              :key="index"
              :value="index"
            >{{type}}
            </Option>
          </Select>
        </FormItem>

        <FormItem label="完工" prop="is_complete">
          <Select v-model="data.is_complete">
            <Option
              v-for="(type, index) in select.isCompleteList"
              :key="index"
              :value="index"
            >{{type}}
            </Option>
          </Select>
        </FormItem>

        <FormItem label="服务工程师" prop="staff_id">
          <remote-select
            :init="data.staff_id"
            :initData="init.staff"
            label="name"
            url="select/staff"
            @on-change="staffChange"
            @on-change-data="staffChangeData"
          ></remote-select>
        </FormItem>

        <FormItem label="备注" prop="remark" style="width: 100%;">
          <Input
            type="textarea"
            v-model="data.remark"
          ></Input>
        </FormItem>

      </Form>
    </div>
  </custom-modal>
</template>

<script>

import ModalMixin from '@/mixins/modal'
import AreaMixin from '@/mixins/area'

import {addRepairAction} from '@/api/order_flow/repair'
import * as orderConst from '@/constants/order_flow'
import * as orderFaultConst from '@/constants/order_fault'

export default {
  name: 'service-add',
  mixins: [ModalMixin, AreaMixin],
  data () {
    return {
      data: {
        service_order_id: 0,
        service_id: 0,
        name: '',
        content: '',
        workday: 0,
        area: '',
        price: 0,
        unit: '天',
        quantity: 1,
        amount: 1,
        reward: 1,
        is_land_traffic: 0,
        is_hotel: 0,
        settlement_method: 1,
        working_hours: 7,
        is_complete: 0,
        staff_id: 0,
        staff_name: '',
        remark: ''
      },
      fault: {},
      rules: {
        name: [
          {required: true, message: '姓名不能为空', trigger: 'blur'}
        ]
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
        service: []
      }
    }
  },
  methods: {
    onSubmit (e) {
      this.$refs.addForm.validate(async (valid) => {
        if (valid) {
          try {
            let data = await addRepairAction(this.data, this.data.service_order_id, 'follow-up')
            console.log('data', data)
            this.withRefresh(e)
          } catch (e) {
            this.closeLoading()
          }
        } else {
          this.closeLoading()
        }
      })
    },
    setDataBefore (data) {
      this.fault = data.fault[0]
      this.data.service_order_id = data.id
    },
    onCancel (e) {
      e()
    },
    async beforeOpen () {
      return true
    },
    async staffChange (staffId) {
      this.data.staff_id = staffId
    },
    async staffChangeData (staff) {
      this.data.staff_id = staff.id
      this.data.staff_name = staff.name
      this.data.staff = staff
    },
    async serviceChange (staffId) {
      this.data.staff_id = staffId
    },
    async serviceChangeData (service) {
      this.data.service_id = service.id
      this.data.name = service.name
      this.data.content = service.content
      this.data.workday = service.workday
      this.data.area = service.area
      this.data.price = service.price
      this.data.unit = service.unit
      this.data.is_land_traffic = service.is_land_traffic
      this.data.is_hotel = service.is_hotel
      // this.data.settlement_method = service.settlement_method
      // this.data.working_hours = service.working_hours
      // this.data.is_complete = +service.is_complete
      this.data.service = service
    }
  },
  watch: {
    'data.quantity' (quantity) {
      this.data.amount = quantity * this.data.price
    }
  }
}
</script>

<style>
  .add-repairs{
    border-bottom: 1px solid #aaa;

    margin-bottom: 20px;
  }
</style>
