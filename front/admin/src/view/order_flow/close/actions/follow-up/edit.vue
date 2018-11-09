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
        <FormItem label="催单人" prop="followup_staff_id">
          <remote-select
            :init="data.followup_staff_id"
            :initData="init.followup_staff"
            label="name"
            url="select/staff"
            @on-change="followUpStaffChange"
            @on-change-data="followUpStaffChangeData"
          ></remote-select>
        </FormItem>

        <FormItem label="催单人电话" prop="mobile">
          <Input
            v-model="data.mobile"
          ></Input>
        </FormItem>

        <FormItem label="催单时间" prop="followup_time">
          <DatePicker
            type="datetime"
            placeholder="催单时间"
            :value="data.followup_time"
            @on-change="date => this.data.followup_time = date"
            :start-date="new Date()"
          ></DatePicker>
        </FormItem>

        <FormItem label="受理人" prop="handle_staff_id">
          <remote-select
            :init="data.handle_staff_id"
            :initData="init.handle_staff"
            label="name"
            url="select/staff"
            @on-change="handleStaffChange"
            @on-change-data="handleStaffChangeData"
          ></remote-select>
        </FormItem>

        <FormItem label="处理结果" prop="handle_result" style="width: 100%;">
          <Input
            type="textarea"
            v-model="data.handle_result"
          ></Input>
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

import {updateCloseAction} from '@/api/order_flow/close'
import * as orderConst from '@/constants/order_flow'
import * as orderFaultConst from '@/constants/order_fault'

export default {
  name: 'follow-up-edit',
  mixins: [ModalMixin, AreaMixin],
  data () {
    return {
      data: {
        id: 0,
        service_order_id: 0,
        followup_staff_id: 0,
        followup_staff_name: '',
        followup_time: '',
        mobile: '',
        handle_staff_id: 0,
        handle_staff_name: '',
        handle_result: '',
        remark: ''
      },
      fault: {},
      rules: {
        followup_staff_id: [
          {required: true, message: '催单人不能为空', trigger: 'blur'}
        ],
        followup_time: [
          {required: true, message: '催单时间不能为空', trigger: 'blur'}
        ],
        handle_staff_id: [
          {required: true, message: '受理人不能为空', trigger: 'blur'}
        ]
      },
      select: {
      },
      init: {
        department: [],
        staff: [],
        service: [],
        followup_staff: [],
        handle_staff: []
      }
    }
  },
  methods: {
    onSubmit (e) {
      this.$refs.addForm.validate(async (valid) => {
        if (valid) {
          try {
            let data = await updateCloseAction(this.data, this.data.id, this.data.service_order_id, 'follow-up')
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
    async afterOpen () {
      this.init.followup_staff = [{
        ...JSON.parse(JSON.stringify(this.data.followup_staff))
      }]
      this.init.handle_staff = [{
        ...JSON.parse(JSON.stringify(this.data.handle_staff))
      }]
      return true
    },
    async followUpStaffChange (staffId) {
      this.data.followup_staff_id = staffId
    },
    async followUpStaffChangeData (staff) {
      this.data.followup_staff_id = staff.id
      this.data.followup_staff_name = staff.name
      this.data.followup_staff = staff
    },
    async handleStaffChange (staffId) {
      this.data.handle_staff_id = staffId
    },
    async handleStaffChangeData (staff) {
      this.data.handle_staff_id = staff.id
      this.data.handle_staff_name = staff.name
      this.data.handle_staff = staff
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
