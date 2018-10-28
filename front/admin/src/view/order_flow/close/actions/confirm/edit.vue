<template>
  <custom-modal
    ref="ref"
    width="600px"
    title="客户确认与评价"
    @on-submit="onSubmit"
    @on-cancel="onCancel"
  >
    <div test="1245">

      <Form :model="data"
            ref="addForm"
            :rules="rules"
            :label-width="100"
      >
        <FormItem label="是否解决">
          <RadioGroup v-model="data.is_solve">
            <Radio :label="1">
              <Icon type="md-checkmark"></Icon>
              <span>是</span>
            </Radio>
            <Radio :label="0">
              <Icon type="md-close"></Icon>
              <span>否</span>
            </Radio>
          </RadioGroup>
        </FormItem>

        <FormItem label="整体满意度" prop="overall_satisfaction">
          <Rate v-model="data.overall_satisfaction" />
        </FormItem>

        <FormItem label="服务及时性" prop="timeliness">
          <Rate v-model="data.timeliness" />
        </FormItem>

        <FormItem label="服务人员满意度" prop="service_staff_atisfaction">
          <Rate v-model="data.service_staff_atisfaction" />
        </FormItem>

        <FormItem label="性价比满意度" prop="cost_performance">
          <Rate v-model="data.cost_performance" />
        </FormItem>

        <FormItem label="建议与意见" prop="opinions_suggestions" style="height: 100px;">
          <Input v-model="data.opinions_suggestions" type="textarea" :autosize="{minRows: 4,maxRows: 8}" placeholder="Enter 建议与意见..." />
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

  import {updateMaintainAction} from '@/api/order_flow/close'
  import * as orderConst from '@/constants/order_flow'

  export default {
    name: 'confirm-edit',
    mixins: [ModalMixin, AreaMixin],
    data () {
      return {
        data: {
          service_order_id: 0,
          is_solve: 0,
          overall_satisfaction: 0,
          timeliness: 0,
          service_staff_atisfaction: 0,
          cost_performance: 0,
          confirm_user_id: 0,
          confirm_user_name: '',
          opinions_suggestions: '',
          created_by: '',
          updated_by: ''
        },
        fault: {},
        rules: {
          opinions_suggestions: [
            {required: true, message: '建议与意见不能为空', trigger: 'blur'}
          ]
        },
        init: {
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
              let data = await updateMaintainAction(this.data, this.data.id, this.data.service_order_id, 'confirm')
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
        return true
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
