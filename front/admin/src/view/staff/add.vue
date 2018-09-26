<template>
  <custom-modal
    ref="ref"
    width="1000px"
    title="人事档案新增"
    @on-submit="onSubmit"
    @on-cancel="onCancel"
  >
    <div>
      <Form :model="data"
            ref="addForm"
            :rules="rules"
            :label-width="90">
        <FormItem label="组织/公司">
          <Select v-model="data.org_id">
            <Option value="beijing">New York</Option>
            <Option value="shanghai">London</Option>
            <Option value="shenzhen">Sydney</Option>
          </Select>
        </FormItem>
        <FormItem label="编号">
          <Input v-model="data.number" placeholder="编号" disabled></Input>
        </FormItem>
        <FormItem label="姓名">
          <Input v-model="data.name" placeholder="姓名"></Input>
        </FormItem>
        <FormItem label="性别">
          <RadioGroup v-model="data.sex">
            <Radio :label="1">
              <Icon type="md-male"></Icon>
              <span>男</span>
            </Radio>
            <Radio :label="0">
              <Icon type="md-female"></Icon>
              <span>女</span>
            </Radio>
          </RadioGroup>
        </FormItem>
        <FormItem label="出生日期">
          <DatePicker type="date" placeholder="生日" v-model="data.birthday"></DatePicker>
        </FormItem>
        <FormItem label="部门">
          <Select v-model="data.dep_id">
            <Option value="beijing">New York</Option>
            <Option value="shanghai">London</Option>
            <Option value="shenzhen">Sydney</Option>
          </Select>
        </FormItem>
        <FormItem label="职位">
          <Select v-model="data.post">
            <Option value="beijing">New York</Option>
            <Option value="shanghai">London</Option>
            <Option value="shenzhen">Sydney</Option>
          </Select>
        </FormItem>
        <FormItem label="职务">
          <Select v-model="data.job">
            <Option value="beijing">New York</Option>
            <Option value="shanghai">London</Option>
            <Option value="shenzhen">Sydney</Option>
          </Select>
        </FormItem>
        <FormItem label="毕业院校">
          <Input v-model="data.graduated_school" placeholder="毕业院校"></Input>
        </FormItem>
        <FormItem label="学历">
          <Select v-model="data.education">
            <Option value="beijing">New York</Option>
            <Option value="shanghai">London</Option>
            <Option value="shenzhen">Sydney</Option>
          </Select>
        </FormItem>
        <FormItem label="技能专长">
          <Input v-model="data.skill_expertise" placeholder="技能专长"></Input>
        </FormItem>
        <FormItem label="兴趣爱好">
          <Input v-model="data.hobby" placeholder="兴趣爱好"></Input>
        </FormItem>
        <FormItem label="手机">
          <Input v-model="data.mobile" placeholder="手机"></Input>
        </FormItem>
        <FormItem label="邮箱">
          <Input v-model="data.email" placeholder="邮箱"></Input>
        </FormItem>
        <FormItem label="在职状态">
          <RadioGroup v-model="data.status">
            <Radio :label="1">
              <span>在职</span>
            </Radio>
            <Radio :label="0">
              <span>离职</span>
            </Radio>
          </RadioGroup>
        </FormItem>
        <FormItem label="入职日期">
          <DatePicker type="date" placeholder="入职日期" v-model="data.entry_date"></DatePicker>
        </FormItem>
        <FormItem label="离职日期">
          <DatePicker type="date" placeholder="离职日期" v-model="data.leave_date"></DatePicker>
        </FormItem>
        <FormItem label="所在省">
          <Input v-model="data.province_id" placeholder="所在省"></Input>
        </FormItem>
        <FormItem label="详细地址">
          <Input v-model="data.address" placeholder="详细地址"></Input>
        </FormItem>
        <FormItem label="备注">
          <Input v-model="data.remark" type="textarea" :autosize="{minRows: 2,maxRows: 5}"
                 placeholder="备注..."></Input>
        </FormItem>

        <FormItem label="建立人员">
          <Input v-model="data.created_by" placeholder="建立人员" disabled></Input>
        </FormItem>
        <FormItem label="建立日期">
          <Input v-model="data.created_at" placeholder="建立日期" disabled></Input>
        </FormItem>
        <FormItem label="最近修改人员">
          <Input v-model="data.updated_by" placeholder="最近修改人员" disabled></Input>
        </FormItem>
        <FormItem label="最近修改日期">
          <Input v-model="data.updated_at" placeholder="最近修改日期" disabled></Input>
        </FormItem>

      </Form>
    </div>
  </custom-modal>
</template>

<script>

import ModalMixin from '@/mixins/modal'

export default {
  name: 'agent-add',
  mixins: [ModalMixin],
  data () {
    return {
      data: {
        input: '',
        select: '',
        radio: 'male',
        checkbox: [],
        entry_date: '',
        leave_date: '',
        remark: '',
        sex: 1,
        birthday: '',
        status: 1
      }
    }
  },
  methods: {
    onSubmit (e) {
      //   console.log('onsubmit', e)
      // ....
      this.withRefresh(e)
    },
    onCancel (e) {
      console.log('oncancel', e)
      e()
    }
  }
}
</script>
