<template>
  <custom-modal
    ref="ref"
    width="600px"
    title="工单-转派"
    @on-submit="onSubmit"
    @on-cancel="onCancel"
  >
    <div>
      <Form :model="data"
            ref="dispatchForm"
            :rules="rules"
            :label-width="90"
      >
        <FormItem label="派工方式">
          <Select v-model="data.dispatch_type">
            <Option
              v-for="(type, index) in select.dispatch"
              :key="index"
              :value="index"
            >{{type}}
            </Option>
          </Select>
        </FormItem>

        <FormItem label="服务网点" prop="dispatch_org_id">
          <remote-select
            label="name"
            url="select/organization"
            :filter="(data) => data.name"
            :valueMap="(data) => data.id"
            @on-change="organizationChange"
          ></remote-select>

        </FormItem>

        <FormItem label="工程师" prop="dispatch_engineer">
          <remote-select
            :init="data.dispatch_engineer"
            :params="params"
            label="staff_name"
            url="select/engineer"
            @on-change="engineerChange"
            @on-change-data="engineerChangeData"
          ></remote-select>

        </FormItem>
      </Form>

    </div>
  </custom-modal>
</template>

<script>

import ModalMixin from '@/mixins/modal'

import {orderServiceDispatch} from '@/api/order_flow/action'
import dayjs from 'dayjs'

import * as validate from '@/libs/validate'

import {DISPATCH} from '@/constants/order_flow'

const currentDate = dayjs().format('YYYY-MM-DD HH:mm:ss')

export default {
  name: 'mx-order-switch',
  mixins: [ModalMixin],
  data () {
    return {
      data: {
        dispatch_type: 0,
        dispatch_org_id: 0,
        dispatch_engineer: 0
      },
      params: {
        org_id: 0
      },
      select: {
        dispatch: DISPATCH
      },
      rules: {
        dispatch_engineer: [
          validate.number('请选择工程师')
        ],
        name: [
          validate.notEmpty('姓名不能为空')
        ]
      }
    }
  },
  methods: {
    onSubmit (e) {
      let refs = this.$refs
      refs['dispatchForm'].validate(async (valid) => {
        if (valid) {
          await orderServiceDispatch(this.data.id, 'repair', this.data)
          this.withRefresh(e)
        } else {
          this.closeLoading()
        }
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
      this.data.dispatch_org_id = id
      if (!id) {
        return
      }
      this.params.org_id = id
    },
    async engineerChange (id) {
      this.data.dispatch_engineer = id
    },
    async engineerChangeData (engineer) {
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
