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
          <remote-select
            :init="data.org_id"
            :initData="init.organization"
            label="name"
            url="select/organization"
            :filter="(data) => data.name"
            :valueMap="(data) => data.id"
            @on-change="organizationChange"
          ></remote-select>
        </FormItem>
        <FormItem label="上级部门" prop="parent_id">
          <static-select
            :data="select.department"
            :init="data.parent_id"
            @on-change="(value) => this.data.parent_id = value"
          >
            <span slot="prev" slot-scope="{option}">
              <span v-if="option.level == 1">|--</span>
              <span v-if="option.level == 2">|----</span>
              <span v-if="option.level == 3">|------</span>
              <span v-if="option.level == 4">|--------</span>
            </span>
          </static-select>
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
import {selectDepartment} from '../../api/select/department'
export default {
  name: 'department-add',
  mixins: [ModalMixin],
  data () {
    return {
      data: {
        name: '',
        number: '',
        org_id: 0,
        parent_id: 0,
        type: 1
      },
      rules: {
        org_id: [
          {
            type: 'number',
            required: true,
            message: '组织/公司不能为空',
            trigger: 'change'
          }
        ],
        number: [
          {
            required: true,
            message: '部门编号不能为空',
            trigger: 'blur'
          }
        ],
        name: [
          {required: true, message: '部门名称不能为空', trigger: 'blur'}
        ]
      },
      select: {
        job: [],
        post: [],
        education: [],
        department: []
      },
      init: {
        organization: [],
        department: []
      }
    }
  },
  methods: {
    onSubmit (e) {
      console.log('on submit')
      this.$refs.addForm.validate(async (valid) => {
        if (valid) {
          try {
            let data = await addDepartment(this.data)
            console.log('addForm data', data)
            this.withRefresh(e)
          } catch (e) {
            this.closeLoading()
          }
        } else {
          this.closeLoading()
        }
      })
    },
    async beforeOpen () {
      return true
    },
    async organizationChange (id) {
      this.data.org_id = +id
      if (!id) {
        return
      }
      let {data} = await selectDepartment(id)
      this.select.department = data || []
      if (data.length) {
        let info = data.find(info => +info.id === +this.data.parent_id)
        if (!info) {
          this.data.parent_id = data[0].id
        }
      }
    },
    onCancel (e) {
      e()
    }
  }
}
</script>
