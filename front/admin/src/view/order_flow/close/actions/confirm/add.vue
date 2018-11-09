<template>
  <custom-modal
    ref="ref"
    width="600px"
    title="维修工单-客户确认与评价"
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
            :initData="init.staff"
            label="name"
            url="select/staff"
          ></remote-select>
        </FormItem>

      </Form>
    </div>
  </custom-modal>
</template>

<script>

  import ModalMixin from '@/mixins/modal'
  import AreaMixin from '@/mixins/area'

  import {addCloseAction} from '@/api/order_flow/close'
  import * as orderConst from '@/constants/order_flow'
  import * as orderFaultConst from '@/constants/order_fault'

  export default {
    name: 'confirm-add',
    mixins: [ModalMixin, AreaMixin],
    data () {
      return {
        data: {
          service_order_id: 0,
          is_solve: 1,
          overall_satisfaction: 3,
          timeliness: 3,
          service_staff_atisfaction: 3,
          cost_performance: 3,
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
        }
      }
    },
    methods: {
      onSubmit (e) {
        this.$refs.addForm.validate(async (valid) => {
          if (valid) {
            try {
              let data = await addCloseAction(this.data, this.data.service_order_id, 'confirm')
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
