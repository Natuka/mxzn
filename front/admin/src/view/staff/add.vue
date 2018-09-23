<template>
  <custom-modal
    ref="ref"
    width="800px"
    title="人事档案新增"
    @on-submit="onSubmit"
    @on-cancel="onCancel"
  >
    <div>
      <Form :model="formItem" :label-width="80">
        <FormItem label="编号">
          <Input v-model="formItem.number" placeholder="编号"></Input>
        </FormItem>
        <FormItem label="姓名">
          <Input v-model="formItem.name" placeholder="姓名"></Input>
        </FormItem>
        <FormItem label="性别">
          <RadioGroup v-model="formItem.sex">
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
        <FormItem label="编号">
          <Input v-model="formItem.number" placeholder="编号"></Input>
        </FormItem>
        <FormItem label="Select">
          <Select v-model="formItem.select">
            <Option value="beijing">New York</Option>
            <Option value="shanghai">London</Option>
            <Option value="shenzhen">Sydney</Option>
          </Select>
        </FormItem>
        <FormItem label="生日">
          <DatePicker type="date" placeholder="生日" v-model="formItem.birthday"></DatePicker>
        </FormItem>
        <FormItem label="Radio">
          <RadioGroup v-model="formItem.radio">
            <Radio label="male">Male</Radio>
            <Radio label="female">Female</Radio>
          </RadioGroup>
        </FormItem>
        <FormItem label="Checkbox">
          <CheckboxGroup v-model="formItem.checkbox">
            <Checkbox label="Eat"></Checkbox>
            <Checkbox label="Sleep"></Checkbox>
            <Checkbox label="Run"></Checkbox>
            <Checkbox label="Movie"></Checkbox>
          </CheckboxGroup>
        </FormItem>
        <FormItem label="Switch">
          <i-switch v-model="formItem.switch" size="large">
            <span slot="open">On</span>
            <span slot="close">Off</span>
          </i-switch>
        </FormItem>
        <FormItem label="Slider">
          <Slider v-model="formItem.slider" range></Slider>
        </FormItem>
        <FormItem label="Text">
          <Input v-model="formItem.textarea" type="textarea" :autosize="{minRows: 2,maxRows: 5}"
                 placeholder="Enter something..."></Input>
        </FormItem>
        <FormItem>
          <Button type="primary">Submit</Button>
          <Button style="margin-left: 8px">Cancel</Button>
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
      formItem: {
        input: '',
        select: '',
        radio: 'male',
        checkbox: [],
        switch: true,
        date: '',
        time: '',
        slider: [20, 50],
        textarea: '',
        sex: 1,
        birthday: ''
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
