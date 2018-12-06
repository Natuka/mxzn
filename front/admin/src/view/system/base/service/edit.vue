<template>
  <custom-modal
    ref="ref"
    width="1000px"
    title="服务项目-修改"
    @on-submit="onSubmit"
    @on-cancel="onCancel"
    class="mxcs-two-column"
  >
    <div>
      <Form :model="data"
            ref="addForm"
            :rules="rules"
            :label-width="100">
        <FormItem label="编号:" prop="number">
          <Input v-model="data.number" placeholder="编号(唯一)" readonly></Input>
        </FormItem>

        <FormItem label="服务名称:" prop="name">
          <Input v-model="data.name" placeholder="服务名称"></Input>
        </FormItem>

        <FormItem label="服务内容:" prop="content">
          <Input v-model="data.content" placeholder="服务内容"></Input>
        </FormItem>

        <FormItem label="服务时间:" prop="workday">
          <Input v-model="data.workday" placeholder="服务时间"></Input>
        </FormItem>

        <FormItem label="地区:" prop="area">
          <Select v-model="data.area">
            <Option
              v-for="(type, index) in areaList"
              :key="index"
              :value="index"
            >{{type}}
            </Option>
          </Select>
        </FormItem>

        <FormItem label="单价:" prop="price">
          <Input v-model="data.price" placeholder="单价"></Input>
        </FormItem>

        <FormItem label="单位:" prop="unit">
          <Input v-model="data.unit" placeholder="单位"></Input>
        </FormItem>

        <FormItem label="含陆路交通费">
          <RadioGroup v-model="data.is_land_traffic">
            <Radio :label="1">
              <Icon type="md-checkmark" />
              <span>是</span>
            </Radio>
            <Radio :label="0">
              <Icon type="md-close" />
              <span>否</span>
            </Radio>
          </RadioGroup>
        </FormItem>

        <FormItem label="含住宿">
          <RadioGroup v-model="data.is_hotel">
            <Radio :label="1">
              <Icon type="md-checkmark" />
              <span>是</span>
            </Radio>
            <Radio :label="0">
              <Icon type="md-close" />
              <span>否</span>
            </Radio>
          </RadioGroup>
        </FormItem>

        <FormItem label="生效日期" prop="effective_date">
          <DatePicker
            type="date"
            placeholder="生效日期"
            v-model="data.effective_date"
            @on-change="date => this.data.effective_date = date"
          ></DatePicker>
        </FormItem>
        <FormItem label="失效日期" prop="expiration_date">
          <DatePicker
            type="date"
            placeholder="失效日期"
            v-model="data.expiration_date"
            @on-change="date => this.data.expiration_date = date"
          ></DatePicker>
        </FormItem>

        <FormItem label="备注:" prop="remark" style="width: 100%">
          <Input v-model="data.remark" placeholder="备注"></Input>
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

import {updateService} from '@/api/base/service'
import * as serviceConst from '../../../../constants/service'

export default {
  name: 'service-edit',
  mixins: [ModalMixin],
  data () {
    return {
      data: {
        number: '',
        name: '',
        content: '',
        workday: '',
        area: 0,
        price: 0,
        unit: '',
        is_land_traffic: 0,
        is_hotel: 0,
        effective_date: '',
        expiration_date: '',
        remark: ''
      },
      rules: {
        name: [
          {required: true, message: '服务名称不能为空', trigger: 'blur'}
        ],
        content: [
          {required: true, message: '服务内容不能为空', trigger: 'blur'}
        ]
      },
      areaList: serviceConst.SERVICE_AREA
    }
  },
  methods: {
    onSubmit (e) {
      this.$refs.addForm.validate(async (valid) => {
        if (valid) {
          try {
            let data = await updateService(this.data, this.data.id)
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
