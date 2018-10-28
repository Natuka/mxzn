<template>
  <custom-modal
    ref="ref"
    width="1000px"
    title="维修工单-服務項目-新增"
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
          ></Input>
        </FormItem>

        <FormItem label="服务内容" prop="content" style="width: 100%;">
          <Input
            type="textarea"
            v-model="data.content"
          ></Input>
        </FormItem>

        <FormItem label="地区" prop="area" >
          <Select v-model="data.area" >
            <Option
              v-for="(type, index) in select.setServiceAreaList"
              :key="index"
              :value="index"
            >{{type}}
            </Option>
          </Select>
        </FormItem>

        <FormItem label="单位" prop="unit" >
          <Input
            v-model="data.unit"
          ></Input>
        </FormItem>

        <FormItem label="单价" prop="price" >
          <InputNumber
            v-model="data.price"
          ></InputNumber>
        </FormItem>


        <FormItem label="数量" prop="quantity" >
          <InputNumber
            v-model="data.quantity"
          ></InputNumber>
        </FormItem>

        <FormItem label="金额" prop="amount" >
          <InputNumber
            v-model="data.amount"
            disabled
          ></InputNumber>
        </FormItem>

        <FormItem label="提成" prop="reward" >
          <InputNumber
            v-model="data.reward"
          ></InputNumber>
        </FormItem>

        <FormItem label="工时" prop="working_hours" >
          <Input
            v-model="data.working_hours"
          ></Input>
        </FormItem>

        <FormItem label="含陆运交通费" prop="is_land_traffic">
          <Select v-model="data.is_land_traffic" >
            <Option
              v-for="(type, index) in select.isLandList"
              :key="index"
              :value="index"
            >{{type}}
            </Option>
          </Select>
        </FormItem>

        <FormItem label="住宿" prop="is_hotel">
          <Select v-model="data.is_hotel" >
            <Option
              v-for="(type, index) in select.isHotelList"
              :key="index"
              :value="index"
            >{{type}}
            </Option>
          </Select>
        </FormItem>

        <FormItem label="结算方式" prop="settlement_method">
          <Select v-model="data.settlement_method">
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

import {addMaintainAction} from '@/api/order_flow/maintain'
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
        amount: 0,
        reward: 0,
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
        content: [
          {required: true, message: '服务内容不能为空', trigger: 'blur'}
        ]
      },
      select: {
        isLandList: orderConst.SERVICE_LAND_TRAFFIC,
        isHotelList: orderConst.SERVICE_HOTEL,
        isCompleteList: orderConst.SERVICE_COMPLETE,
        settlementMothedList: orderConst.SERVICE_SETTLEMENT_METHOD,
        setServiceAreaList: orderConst.SERVICE_AREA
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
        console.log('onSubmit', valid)
        if (valid) {
          try {
            let data = await addMaintainAction(this.data, this.data.service_order_id, 'service')
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
      if (this.data.reward > this.data.amount) {
        this.data.reward = this.data.amount
      }
    },
    'data.price' (price) {
      this.data.amount = price * this.data.quantity
      if (this.data.reward > this.data.amount) {
        this.data.reward = this.data.amount
      }
    },
    'data.reward' (reward) {
      if (reward > this.data.amount) {
        this.data.reward = this.data.amount
      }
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
