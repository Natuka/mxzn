<template>
  <custom-modal
    ref="ref"
    width="1000px"
    title="报价单-新增"
    @on-submit="onSubmit"
    @on-cancel="onCancel"
    class="mxcs-three-column"
  >
    <div>
      <Form :model="data"
            ref="addForm"
            :rules="rules"
            :label-width="90">
        <FormItem label="单据单号" prop="billno">
          <Input v-model="data.billno" placeholder="单据单号" disabled></Input>
        </FormItem>
        <FormItem label="起始日期" prop="effective_date">
          <DatePicker
            type="date"
            placeholder="起始日期"
            :value="data.effective_date"
            @on-change="date => this.data.effective_date = date"
          ></DatePicker>
        </FormItem>
        <FormItem label="截止日期" prop="expiration_date">
          <DatePicker
            type="date"
            placeholder="截止日期"
            :value="data.expiration_date"
            @on-change="date => this.data.expiration_date = date"
          ></DatePicker>
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

        <FormItem label="联系人" prop="customer_contact_id">
          <static-select
            :init="init.customer_contact_id"
            :data="select.customerConcatList"
            label="name"
            @on-change-data="feedbackStaffChangeData"
          ></static-select>

        </FormItem>

        <FormItem label="手机" prop="mobile">
          <Input :value="data.mobile" placeholder="手机" readonly></Input>
        </FormItem>

        <FormItem label="付款方式" prop="pay">
          <Select v-model="data.pay">
            <Option
              v-for="(type, index) in payList"
              :key="index"
              :value="index"
            >{{type}}
            </Option>
          </Select>
        </FormItem>
        <FormItem label="运费" prop="carriage">
          <Select v-model="data.carriage">
            <Option
              v-for="(type, index) in carriageList"
              :key="index"
              :value="index"
            >{{type}}
            </Option>
          </Select>
        </FormItem>

        <FormItem label="工单编号" prop="service_order_id">
          <remote-select
            :init="data.service_order_id"
            :initData="init.serviceorder"
            label="number"
            url="select/serviceorder"
            @on-change="serviceorderChange"
          ></remote-select>
        </FormItem>

        <!--<FormItem label="交货日期" prop="delivery_date">-->
          <!--<DatePicker-->
            <!--type="date"-->
            <!--placeholder="交货日期"-->
            <!--:value="data.delivery_date"-->
            <!--@on-change="date => this.data.delivery_date = date"-->
          <!--&gt;</DatePicker>-->
        <!--</FormItem>-->

        <FormItem label="单据状态" prop="status">
          <Select v-model="data.status">
            <Option
              v-for="(type, index) in statusList"
              :key="index"
              :value="index"
            >{{type}}
            </Option>
          </Select>
        </FormItem>
        <FormItem label="审核人员">
          <Input v-model="data.checked_by" placeholder="审核人员" disabled></Input>
        </FormItem>
        <FormItem label="审核日期">
          <Input v-model="data.checked_date" placeholder="审核日期" disabled></Input>
        </FormItem>

        <FormItem label="备注" style="width: 99%;">
          <Input v-model="data.remark" type="textarea" :autosize="{minRows: 2,maxRows: 5}"
                 placeholder="备注..."></Input>
        </FormItem>

        <FormItem label="建立人员/日期" style="width: 49%;">
          <Input v-model="data.created_by" style="width: auto;" placeholder="建立人员" disabled></Input>
          <Input v-model="data.created_at" style="width: auto;margin-left: 10px;" placeholder="建立日期" disabled></Input>
        </FormItem>
        <FormItem label="修改人员/日期" style="width: 49%;">
          <Input v-model="data.updated_by" style="width: auto" placeholder="最近修改人员" disabled></Input>
          <Input v-model="data.updated_at" style="width: auto;margin-left: 10px;" placeholder="最近修改日期" disabled></Input>
        </FormItem>

      </Form>
      <br>
      <mx-order-materiel ref="materiel" :quotation_id="data.id"></mx-order-materiel>
    </div>
  </custom-modal>
</template>

<script>
import Tables from '_c/tables'
import ModalMixin from '@/mixins/modal'
import materiel from './materiel/index'

import {addCustomerquotation} from '../../api/customerquotation'
import {selectCustomer} from '../../api/select/customer'
import {selectCustomerContact} from '@/api/select/customer-contact'
import {selectServiceOrder} from '../../api/select/serviceorder'
import * as customerquotationConst from '../../constants/customerquotation'
import dayjs from 'dayjs'

import * as validate from '@/libs/validate'

const currentDate = dayjs().format('YYYY-MM-DD HH:mm:ss')


export default {
  name: 'customerquotation-add',
  components: {
    Tables,
    [materiel.name]: materiel
  },
  mixins: [ModalMixin],
  data () {
    return {
      data: {
        id: 0,
        service_order_id: 0,
        customer_id: 0,
        customer_contact_id: 0,
        pay: 0,
        carriage: 0,
        status: 0,
        mobile: '',
        effective_date: '',
        expiration_date: '',
        delivery_date: '',
        remark: '',
        billno: ''
      },
      initData: {},
      rules: {
        effective_date: [
          {required: true, message: '起始日期不能为空', trigger: 'blur'}
        ],
        expiration_date: [
          {required: true, message: '截止日期不能为空', trigger: 'blur'}
        ],
        mobile: [
          {required: true, message: '手机不能为空', trigger: 'blur'}
        ]
      },
      statusList: customerquotationConst.STATUS_LIST,
      carriageList: customerquotationConst.CARRIAGE_LIST,
      payList: customerquotationConst.PAY_LIST,
      select: {
        customerConcatList: []
      },
      init: {
        customer: [],
        serviceorder: []
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
            let data = await addCustomerquotation(this.data)
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

      let customers = await selectCustomer({id: data.customer_id})
      this.init.customer = customers.data

      let serviceorders = await selectServiceOrder({id: data.service_order_id})
      this.init.serviceorder = serviceorders.data

      return true
    },
    async serviceorderChange (serviceorderdId) {
      this.data.service_order_id = serviceorderdId
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
      this.data.customer_contact_id = contact.id
      this.data.mobile = contact.mobile
    }
  }
}
</script>
