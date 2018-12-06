<template>
  <custom-modal
    ref="ref"
    width="600px"
    title="签到记录"
    @on-submit="onSubmit"
    @on-cancel="onCancel"
  >
    <div test="1245">

      <Form :model="data"
            ref="addForm"
            :rules="rules"
            :label-width="100"
      >
        <FormItem label="签到人员" props="staff_id">
          <remote-select
            :init="data.staff_id"
            :initData="init.engineer_staff"
            label="staff_name"
            url="select/engineer"
            @on-change="engineerChange"
            @on-change-data="engineerChangeData"
          ></remote-select>
        </FormItem>

        <FormItem label="签到时间" prop="signin_time">
          <DatePicker
            type="datetime"
            placeholder="签到时间"
            :value="data.signin_time"
            @on-change="date => this.data.signin_time = date"
            format="yyyy-MM-dd HH:mm:ss"
          ></DatePicker>
        </FormItem>

        <FormItem label="位置" prop="location">
          <Input v-model="data.location"></Input>
        </FormItem>

        <FormItem label="坐标" prop="coordinate">
          <Input v-model="data.coordinate"></Input>
        </FormItem>

        <FormItem label="备注" prop="remark" style="height: 100px;">
          <Input v-model="data.remark" type="textarea" :autosize="{minRows: 4,maxRows: 8}" placeholder="Enter 备注..." />
        </FormItem>

        <FormItem label="确认人员" prop="confirm_user_id">
          <remote-select
            :init="data.confirm_user_id"
            :initData="init.confirm_staff"
            label="name"
            url="select/staff"
            @on-change="confirmChange"
            @on-change-data="confirmChangeData"
          ></remote-select>
        </FormItem>

      </Form>
    </div>
  </custom-modal>
</template>

<script>

import ModalMixin from '@/mixins/modal'
import AreaMixin from '@/mixins/area'

import {updateMaintainAction} from '@/api/order_flow/maintain'
import * as orderConst from '@/constants/order_flow'
import * as orderFaultConst from '@/constants/order_fault'

export default {
  name: 'attendance-edit',
  mixins: [ModalMixin, AreaMixin],
  data () {
    return {
      data: {
        service_order_id: 0,
        staff_id: 0,
        staff_name: '',
        signin_time: '',
        location: '',
        coordinate: '',
        confirm_user_id: 0,
        confirm_user_name: '',
        remark: '',
        created_by: '',
        updated_by: ''
      },
      fault: {},
      rules: {
        staff_id: [
          {required: true, message: '签到人员不能为空', trigger: 'blur'}
        ],
        signin_time: [
          {required: true, message: '时间不能为空', trigger: 'blur'}
        ],
        location: [
          {required: true, message: '位置不能为空', trigger: 'blur'}
        ],
        coordinate: [
          {required: true, message: '坐标不能为空', trigger: 'blur'}
        ]
      },
      init: {
        staff: [],
        engineer_staff: [],
        confirm_staff: []
      }
    }
  },
  methods: {
    onSubmit (e) {
      this.$refs.addForm.validate(async (valid) => {
        console.log('onSubmit', valid)
        if (valid) {
          try {
            console.log('onSubmit IN')
            let data = await updateMaintainAction(this.data, this.data.id, this.data.service_order_id, 'attendance')
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
      this.data.service_order_id = data.id
    },
    onCancel (e) {
      e()
    },
    async beforeOpen () {
      return true
    },
    async afterOpen () {
      this.init.confirm_staff = [{
        id: this.data.confirm_user_id,
        name: this.data.confirm_user_name
      }]

      this.init.engineer_staff = [{
        id: this.data.staff_id,
        staff_name: this.data.staff_name
      }]
      return true
    },
    async engineerChange () {
    },
    async engineerChangeData (engineers = []) {
      // console.log('engineers', engineers)
      this.data.staff_id = engineers ? engineers.id : 0
      this.data.staff_name = engineers ? engineers.staff_name : ''
      // console.log('staff_name', this.data.staff_name)
      this.data.engineer_staff = engineers
    },
    async confirmChange () {
    },
    async confirmChangeData (staff = []) {
      // console.log('staff', staff)
      this.data.confirm_user_id = staff ? staff.id : 0
      this.data.confirm_user_name = staff ? staff.name : ''
      // console.log('staff_name', this.data.confirm_user_name)
      this.data.confirm_staff = staff
    }
  },
  watch: {
  }
}
</script>

<style>
  .add-repairs{
    border-bottom: 1px solid #aaa;

    margin-bottom: 20px;
  }
</style>
