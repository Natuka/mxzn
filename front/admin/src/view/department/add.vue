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
        <FormItem label="编号" prop="number">
          <Input v-model="data.number" placeholder="编号"></Input>
        </FormItem>
        <FormItem label="姓名" prop="name">
          <Input v-model="data.name" placeholder="姓名"></Input>
        </FormItem>
        <FormItem label="简称" prop="name_short">
          <Input v-model="data.name_short" placeholder="简称"></Input>
        </FormItem>
        <FormItem label="类别">
          <RadioGroup v-model="data.type">
            <Radio :label="1">
              <span>A</span>
            </Radio>
            <Radio :label="0">
              <span>B</span>
            </Radio>
          </RadioGroup>
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
        name_short: '',
        type: 1
      },
      rules: {
        name: [
          {required: true, message: '名称不能为空', trigger: 'blur'},
        ],
        number: [
          {required: true, message: '编号不能为空', trigger: 'blur'}
        ],
        name_short: [
          {required: true, message: '简称不能为空', trigger: 'blur'}
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
