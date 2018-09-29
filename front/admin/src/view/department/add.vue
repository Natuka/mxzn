<template>
  <custom-modal
    ref="ref"
    width="800px"
    title="部门-新增"
    @on-submit="onSubmit"
    @on-cancel="onCancel"
  >
    <div>
      <Form :model="data"
            ref="addForm"
            :rules="rules"
            :label-width="80">
        <FormItem label="组织/公司" prop="org_id">
          <Select v-model="data.org_id">
            <Option value="beijing">New York</Option>
            <Option value="shanghai">London</Option>
            <Option value="shenzhen">Sydney</Option>
          </Select>
        </FormItem>
        <FormItem label="上级部门" prop="parent_id">
          <Select v-model="data.parent_id">
            <Option value="beijing">New York</Option>
            <Option value="shanghai">London</Option>
            <Option value="shenzhen">Sydney</Option>
          </Select>
        </FormItem>
        <FormItem label="部门编号" prop="number">
          <Input v-model="data.number" placeholder="部门编号"></Input>
        </FormItem>
        <FormItem label="部门名称" prop="name">
          <Input v-model="data.name" placeholder="部门名称"></Input>
        </FormItem>
        <FormItem label="排序" prop="name_short">
          <Input v-model="data.sort_no" placeholder="排序"></Input>
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

import {addDepartment} from '../../api/department'

export default {
  name: 'department-add',
  mixins: [ModalMixin],
  data () {
    return {
      data: {
        name: '',
        number: '',
        org_id: 0,
        type: 1
      },
      rules: {
        org_id: [
          {required: true, message: '组织/公司不能为空', trigger: 'blur'}
        ],
        number: [
          {required: true, message: '部门编号不能为空', trigger: 'blur'}
        ],
        name: [
          {required: true, message: '部门名称不能为空', trigger: 'blur'},
        ]
      }
    }
  },
  methods: {
    onSubmit (e) {
      this.$refs.addForm.validate(async (valid) => {
        if (valid) {
          try {
            let data = await addDepartment(this.data)
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
