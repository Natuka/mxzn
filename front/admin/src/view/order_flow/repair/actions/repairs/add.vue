<template>
  <custom-modal
    ref="ref"
    width="1000px"
    title="维修工单-新增"
    @on-submit="onSubmit"
    @on-cancel="onCancel"
    class="mxcs-two-column"
  >
    <div>
      <Form
            ref="addForm1"
            :label-width="90"
            class="mxcs-two-column"
      >
        <FormItem label="故障描述" prop="fault.desc" style="width: 100%;">
          <Input
            type="textarea"
            :value="fault.desc"
          ></Input>
        </FormItem>

        <FormItem label="故障类型" prop="type">
          <Select v-model="fault.type">
            <Option
              v-for="(type, index) in select.faultType"
              :key="index"
              :value="index"
            >{{type}}
            </Option>
          </Select>
        </FormItem>
        <FormItem label="故障频率" prop="sequence">
          <Select v-model="fault.sequence">
            <Option
              v-for="(type, index) in select.sequenceType"
              :key="index"
              :value="index"
            >{{type}}
            </Option>
          </Select>
        </FormItem>
        <FormItem label="线路是否破损" prop="is_line_broken">
          <Select :value="fault.is_line_broken">
            <Option
              v-for="(type, index) in select.lineBroken"
              :key="index"
              :value="index"
            >{{type}}
            </Option>
          </Select>
        </FormItem>
        <FormItem label="部品是否损坏" prop="is_part_broken">
          <Select :value="fault.is_part_broken">
            <Option
              v-for="(type, index) in select.partBroken"
              :key="index"
              :value="index"
            >{{type}}
            </Option>
          </Select>
        </FormItem>
        <FormItem label="故障频率" prop="sequence">
          <Select :value="fault.sequence">
            <Option
              v-for="(type, index) in select.sequenceType"
              :key="index"
              :value="index"
            >{{type}}
            </Option>
          </Select>
        </FormItem>

      </Form>

      <Form :model="data"
            ref="addForm"
            :rules="rules"
            :label-width="90"
            class="mxcs-two-column"
      >
        <FormItem label="处理工程师" prop="fault.sequence">
          <remote-select
            :init="data.receive_staff_id"
            :initData="init.receiveStaff"
            label="name"
            url="select/staff"
            @on-change="receiveStaffChange"
            @on-change-data="receiveStaffChangeData"
          ></remote-select>
        </FormItem>

        <FormItem label="处理进度" prop="fault.sequence">
          <Select v-model="data.fault.sequence">
            <Option
              v-for="(type, index) in select.processList"
              :key="index"
              :value="index"
            >{{type}}
            </Option>
          </Select>
        </FormItem>

        <FormItem label="处理措施结果" prop="fault.desc" style="width: 100%;">
          <Input
            type="textarea"
            :value="data.fault.desc"
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

        <FormItem label="故障原因" prop="fault.desc" style="width: 100%;">
          <Input
            type="textarea"
            :value="data.fault.desc"
          ></Input>
        </FormItem>

        <FormItem label="附件" prop="fault.desc" style="width: 100%;">
          <Upload action="//jsonplaceholder.typicode.com/posts/">
            <Button icon="ios-cloud-upload-outline">上传</Button>
          </Upload>
        </FormItem>

        <FormItem label="下一步处理" prop="fault.sequence">
          <Select v-model="data.fault.sequence">
            <Option
              v-for="(type, index) in select.sequenceType"
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

import {addRepair} from '@/api/order_flow/repair'
// import {selectOrganization} from '../../../api/select/organization'
import {selectDepartment} from '@/api/select/department'
import * as orderConst from '@/constants/order_flow'

export default {
  name: 'repair-add',
  mixins: [ModalMixin, AreaMixin],
  data () {
    return {
      data: {
        org_id: 0,
        number: '',
        name: '',
        sex: 1,
        birthday: '',
        dep_id: 0,
        post: 0,
        job: 0,
        graduated_school: '',
        education: 0,
        skill_expertise: '',
        hobby: '',
        mobile: '',
        email: '',
        entry_date: '',
        status: 1,
        arrived_at: '',
        complete_at: '',
        province_id: 0,
        city_id: 0,
        district_id: 0,
        address: '',
        remark: '',
        cause: ''
      },
      fault: {},
      rules: {
        name: [
          {required: true, message: '姓名不能为空', trigger: 'blur'}
        ]
      },
      select: {
        job: [],
        post: [],
        education: [],
        department: [],
        processList: orderConst.REPAIR_PROCESS
      },
      init: {
        organization: [],
        department: []
      }
    }
  },
  methods: {
    onSubmit (e) {
      this.$refs.addForm.validate(async (valid) => {
        if (valid) {
          try {
            let data = await addRepair(this.data)
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
    onCancel (e) {
      e()
    },
    async beforeOpen () {
      return true
    },
    async receiveStaffChange (staffId) {
      this.data.receive_staff_id = staffId
    },
    async receiveStaffChangeData (staff) {
      this.data.receive_staff_id = staff.id
      this.data.receive_staff = staff
    }
  }
}
</script>
