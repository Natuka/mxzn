<template>
  <custom-modal
    ref="ref"
    width="600px"
    title="维修工单-工单取消"
    @on-submit="onSubmit"
    @on-cancel="onCancel"
  >
    <div>
      <Form :model="data"
            ref="cancelForm"
            :rules="rules"
            :label-width="90"
      >
        <FormItem label="取消原因">
          <Select v-model="data.cancel_type">
            <Option
              v-for="(type, index) in select.reason"
              :key="index"
              :value="index"
            >{{type}}
            </Option>
          </Select>
        </FormItem>

        <FormItem label="原因描述" prop="cancel_cause">
          <Input
            type="textarea"
            v-model="data.cancel_cause"
            row="10"
          ></Input>
        </FormItem>
      </Form>

    </div>
  </custom-modal>
</template>

<script>

import ModalMixin from '@/mixins/modal'

import {orderServiceCancel} from '@/api/order_flow/action'
import {selectDepartment} from '@/api/select/department'
import dayjs from 'dayjs'
import {CANCEL_REASON} from '@/constants/order_flow'
import * as validate from '@/libs/validate'

const currentDate = dayjs().format('YYYY-MM-DD HH:mm:ss')

export default {
  name: 'mx-order-cancel',
  mixins: [ModalMixin],
  data () {
    return {
      data: {
        cancel_type: 0,
        cancel_cause: '',
      },
      select: {
        reason: CANCEL_REASON
      },
      rules: {
        cancel_cause: [
          validate.notEmpty('取消原因必填')
        ]
      }
    }
  },
  methods: {
    onSubmit (e) {
      let refs = this.$refs
      refs['cancelForm'].validate(async (valid) => {
        if (valid) {
          await orderServiceCancel(this.data.id, 'repair', this.data)
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
