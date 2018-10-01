<template>
  <custom-modal
    ref="ref"
    width="1000px"
    title="客户联系人-新增"
    @on-submit="onSubmit"
    @on-cancel="onCancel"
    class="mxcs-two-column"
  >
    <div>
      <Form :model="data"
            ref="addForm"
            :rules="rules"
            :label-width="90">
        <FormItem label="客户公司" prop="org_id">
          <Select v-model="data.cust_id">
            <Option value="beijing">New York</Option>
            <Option value="shanghai">London</Option>
            <Option value="shenzhen">Sydney</Option>
          </Select>
        </FormItem>
        <FormItem label="姓名" prop="name">
          <Input v-model="data.name" placeholder="姓名"></Input>
        </FormItem>
        <FormItem label="出生日期" prop="birthday">
          <DatePicker type="date" placeholder="生日" v-model="data.birthday"></DatePicker>
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
        <FormItem label="部门" prop="dep_id">
          <Select v-model="data.department">
            <Option value="beijing">New York</Option>
            <Option value="shanghai">London</Option>
            <Option value="shenzhen">Sydney</Option>
          </Select>
        </FormItem>
        <FormItem label="职位" prop="post">
          <Select v-model="data.post">
            <Option value="beijing">New York</Option>
            <Option value="shanghai">London</Option>
            <Option value="shenzhen">Sydney</Option>
          </Select>
        </FormItem>
        <FormItem label="职务" prop="job">
          <Select v-model="data.job">
            <Option value="beijing">New York</Option>
            <Option value="shanghai">London</Option>
            <Option value="shenzhen">Sydney</Option>
          </Select>
        </FormItem>
        <FormItem label="手机" prop="mobile">
          <Input v-model="data.mobile" placeholder="手机"></Input>
        </FormItem>
        <FormItem label="微信" prop="weixin">
          <Input v-model="data.weixin" placeholder="微信"></Input>
        </FormItem>
        <FormItem label="QQ" prop="qq">
          <Input v-model="data.qq" placeholder="QQ"></Input>
        </FormItem>
        <FormItem label="邮箱" prop="email">
          <Input v-model="data.email" placeholder="邮箱"></Input>
        </FormItem>
        <FormItem label="兴趣爱好" prop="hobby">
          <Input v-model="data.hobby" placeholder="兴趣爱好"></Input>
        </FormItem>
        <FormItem label="详细地址">
          <Input v-model="data.address" placeholder="详细地址"></Input>
        </FormItem>
        <FormItem label="在职状态" >
          <RadioGroup v-model="data.status">
            <Radio :label="1">
              <span>在职</span>
            </Radio>
            <Radio :label="0">
              <span>离职</span>
            </Radio>
          </RadioGroup>
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

import {addCustomercontact} from '../../api/customercontact'

import * as customercontactConst from '../../constants/customercontact'

export default {
  name: 'customercontact-add',
  mixins: [ModalMixin],
  data () {
    return {
      data: {
        cust_id: 0,
        name: '',
        sex: 1,
        birthday: '',
        department: 0,
        post: '',
        job: '',
        mobile: '',
        email: '',
        weixin: '',
        qq: '',
        hobby: '',
        status: 1,
        address: '',
        remark: ''
      },
      rules: {
        name: [
          {required: true, message: '姓名不能为空', trigger: 'blur'}
        ]
      },
      educationList: customercontactConst.EDUCATION_LIST
    }
  },
  methods: {
    onSubmit (e) {
      this.$refs.addForm.validate(async (valid) => {
        if (valid) {
          try {
            let data = await addCustomercontact(this.data)
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
    }
  }
}
</script>
