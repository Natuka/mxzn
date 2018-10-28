<template>
  <custom-modal
    ref="ref"
    width="1000px"
    title="维修工单-新增"
    @on-submit="onSubmit"
    @on-cancel="onCancel"
    class="mxcs-two-column"
  >
    <div test="1245">
      <Form
        :model="fault"
        ref="addForm1"
        :label-width="90"
        class="mxcs-two-column add-repairs"
      >
        <FormItem label="故障描述" prop="fault.desc" style="width: 100%;">
          <Input
            type="textarea"
            :value="fault.desc"
            disabled
          ></Input>
        </FormItem>

        <FormItem label="故障类型" prop="type">
          <Select v-model="fault.type" disabled>
            <Option
              v-for="(type, index) in select.faultType"
              :key="index"
              :value="index"
            >{{type}}
            </Option>
          </Select>
        </FormItem>
        <FormItem label="故障频率" prop="sequence">
          <Select v-model="fault.sequence" disabled>
            <Option
              v-for="(type, index) in select.sequenceType"
              :key="index"
              :value="index"
            >{{type}}
            </Option>
          </Select>
        </FormItem>
        <FormItem label="线路是否破损" prop="is_line_broken">
          <Select :value="fault.is_line_broken" disabled>
            <Option
              v-for="(type, index) in select.lineBroken"
              :key="index"
              :value="index"
            >{{type}}
            </Option>
          </Select>
        </FormItem>
        <FormItem label="部品是否损坏" prop="is_part_broken">
          <Select :value="fault.is_part_broken" disabled>
            <Option
              v-for="(type, index) in select.partBroken"
              :key="index"
              :value="index"
            >{{type}}
            </Option>
          </Select>
        </FormItem>
        <FormItem label="故障频率" prop="sequence">
          <Select :value="fault.sequence" disabled>
            <Option
              v-for="(type, index) in select.sequenceType"
              :key="index"
              :value="index"
            >{{type}}
            </Option>
          </Select>
        </FormItem>
      </Form>

      <br>
      <br>

      <Form :model="data"
            ref="addForm"
            :rules="rules"
            :label-width="90"
            class="mxcs-two-column"
      >
        <FormItem label="处理工程师" prop="staff_id">
          <remote-select
            :init="data.staff_id"
            :initData="init.staff"
            label="name"
            url="select/staff"
            @on-change="staffChange"
            @on-change-data="staffChangeData"
          ></remote-select>
        </FormItem>

        <FormItem label="处理进度" prop="process_id">
          <Select v-model="data.process_id">
            <Option
              v-for="(type, index) in select.processList"
              :key="index"
              :value="index"
            >{{type}}
            </Option>
          </Select>
        </FormItem>

        <FormItem label="处理措施结果" prop="step_result" style="width: 100%;">
          <Input
            type="textarea"
            v-model="data.step_result"
          ></Input>
        </FormItem>

        <FormItem label="附件" prop="fault.desc" style="width: 100%;">
          <Upload action="//jsonplaceholder.typicode.com/posts/">
            <Button icon="ios-cloud-upload-outline">上传</Button>
          </Upload>
        </FormItem>

        <FormItem label="到达时间" prop="arrived_at">
          <DatePicker
            type="datetime"
            placeholder="到达时间"
            :value="data.arrived_at"
            @on-change="date => this.data.arrived_at = date"
            :start-date="new Date()"
          ></DatePicker>
        </FormItem>

        <FormItem label="完成时间" prop="complete_at">
          <DatePicker
            type="datetime"
            placeholder="完成时间"
            :value="data.complete_at"
            @on-change="date => this.data.complete_at = date"
            :start-date="new Date()"
          ></DatePicker>
        </FormItem>

        <FormItem label="故障原因" prop="cause" style="width: 100%;">
          <Input
            type="textarea"
            v-model="data.cause"
          ></Input>
        </FormItem>

        <FormItem label="附件" prop="fault.desc" style="width: 100%;">
          <Upload action="//jsonplaceholder.typicode.com/posts/">
            <Button icon="ios-cloud-upload-outline">上传</Button>
          </Upload>
        </FormItem>

        <FormItem label="下一步处理" prop="next">
          <Select v-model="data.next">
            <Option
              v-for="(type, index) in select.nextList"
              :key="index"
              :value="index"
            >{{type}}
            </Option>
          </Select>
        </FormItem>

      </Form>
    </div>
  </custom-modal>
</template>

<script>

import ModalMixin from '@/mixins/modal'
import AreaMixin from '@/mixins/area'

import {updateDispatchAction} from '@/api/order_flow/dispatch'
import * as orderConst from '@/constants/order_flow'
import * as orderFaultConst from '@/constants/order_fault'

export default {
  name: 'repairs-edit',
  mixins: [ModalMixin, AreaMixin],
  data () {
    return {
      data: {
        staff: {},
        staff_id: 0,
        service_order_id: 0,
        staff_name: '',
        process_id: 0, // 进度ID
        process: '', // 进度内容
        arrived_at: '',
        complete_at: '',
        cause_id: 0,
        next: 0,
        cause: '',
        step_doc_ids: '',
        step_result: '',
        cause_doc_ids: '',
        remark: ''
      },
      fault: {},
      rules: {
        name: [
          {required: true, message: '姓名不能为空', trigger: 'blur'}
        ]
      },
      select: {
        faultType: orderFaultConst.FAULT_TYPE,
        sequenceType: orderFaultConst.SEQUENCE_TYPE,
        lineBroken: orderFaultConst.LINE_BROKEN,
        partBroken: orderFaultConst.PART_BROKEN,
        processList: orderConst.REPAIR_PROCESS,
        nextList: orderConst.REPAIR_NEXT
      },
      init: {
        department: [],
        staff: []
      }
    }
  },
  methods: {
    onSubmit (e) {
      this.$refs.addForm.validate(async (valid) => {
        if (valid) {
          try {
            let data = await updateDispatchAction(this.data, this.data.id, this.data.service_order_id, 'repairs')
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
      this.init.staff = [{
        id: this.data.staff_id,
        name: this.data.staff_name
      }]
    },
    async staffChange (staffId) {
      this.data.staff_id = staffId
    },
    async staffChangeData (staff) {
      this.data.staff_id = staff.id
      this.data.staff_name = staff.name
      this.data.staff = staff
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
