<template>
  <custom-modal
    ref="ref"
    width="1000px"
    title="设备二维码-查看"
    @on-submit="onSubmit"
    @on-cancel="onCancel"
    class="mxcs-two-column"
  >
    <div>
      <Form :model="data"
            ref="addForm"
            :label-width="100">
        <FormItem label="编号:" prop="number">
          <Input v-model="data.number" placeholder="编号(唯一)" disabled></Input>
        </FormItem>

        <FormItem label="设备名称:" prop="name">
          <Input v-model="data.name" placeholder="设备名称" disabled></Input>
        </FormItem>

        <FormItem label="二维码图片:" prop="model" style="height: 320px;">
          <FormItem  prop="qrcode_img">
            <img v-if="src" :src="src" width="300" />
            <span v-else>暂无图片</span>
          </FormItem>
          <FormItem style="width: 100%">
            <a :href="src" target="_blank" :download="download">下载</a>
          </FormItem>
        </FormItem>

        <FormItem label="系列号:" prop="serial_number">
          <Input v-model="data.serial_number" placeholder="系列号" disabled></Input>
        </FormItem>

        <FormItem label="备注:" prop="remark" style="width: 100%">
          <Input v-model="data.remark" placeholder="备注" disabled></Input>
        </FormItem>

      </Form>
    </div>
  </custom-modal>
</template>

<script>

import ModalMixin from '@/mixins/modal'

export default {
  name: 'machineqrcode-view',
  mixins: [ModalMixin],
  data () {
    return {
      data: {
        number: '',
        name: '',
        qrcode_img: '',
        serial_number: '',
        remark: ''
      }
    }
  },
  computed: {
    src () {
      if (this.data.qrcode_img) {
        return 'https://api.mxhj.net/' + this.data.qrcode_img
      }
      return ''
    },
    download () {
      return this.data.number + '_' + this.data.name
    }
  },
  methods: {
    onSubmit (e) {
      e()
    },
    onCancel (e) {
      e()
    }
  }
}
</script>
