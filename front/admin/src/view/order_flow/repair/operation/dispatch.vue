<template>
  <custom-modal
    ref="ref"
    width="600px"
    title="维修工单-派工"
    @on-submit="onSubmit"
    @on-cancel="onCancel"
    class="mxcs-three-column"
  >
    <div>
      <Form :model="data"
            ref="cancelForm"
            :rules="rules"
            :label-width="90"
      >
      </Form>

    </div>
  </custom-modal>
</template>

<script>

import ModalMixin from '@/mixins/modal'

import {addRepair} from '@/api/order_flow/repair'
import {selectDepartment} from '@/api/select/department'
import dayjs from 'dayjs'

import * as validate from '@/libs/validate'

const currentDate = dayjs().format('YYYY-MM-DD HH:mm:ss')

export default {
  name: 'mx-order-dispatch',
  mixins: [ModalMixin],
  data () {
    return {
      data: {
      },
      rules: {
        name: [
          validate.notEmpty('姓名不能为空')
        ]
      }
    }
  },
  methods: {
    onSubmit (e) {
      let refs = this.$refs
      refs['cancelForm'].validate(async (valid) => {
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
