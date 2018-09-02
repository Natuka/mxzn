<template>
  <Modal
    :title="title"
    v-model="modal"
    :closable="escClosable"
    :draggable="draggable"
    :mask-closable="maskClosable"
    :on-ok="onOk"
    :on-cancel="onCancel"
    :width="width"
  >
      <div v-if="$slots.header" slot="header"><slot slot="header"></slot></div>
      <slot></slot>
      <div slot="footer">
        <Button v-if="postable" type="primary" :loading="loading" @click="onOk()">提交</Button>
        <Button type="default" :disabled="loading" @click="onCancel()">取消</Button>
      </div>
    </Modal>
</template>

<script>
export default {
  name: 'custom-modal',
  props: {
    maskClosable: {
      type: Boolean,
      default: false
    },
    escClosable: {
      type: Boolean,
      default: false
    },
    draggable: {
      type: Boolean,
      default: false
    },
    title: {
      type: String,
      default: ''
    },
    width: {
      type: [Number, String],
      default: 416
    },
    postable: {
      type: Boolean,
      default: true
    }
  },
  data () {
    return {
      modal: false,
      loading: false
    }
  },
  methods: {
    open () {
      this.modal = true
    },
    close () {
      this.modal = false
    },
    openLoading () {
      this.loading = true
    },
    closeLoading () {
      this.loading = false
    },
    onClose () {
      return _ => {
        this.closeLoading()
        this.close()
      }
    },
    onOk () {
      this.openLoading()
      this.$emit('on-submit', this.onClose())
    },
    onCancel () {
      this.$emit('on-cancel', this.onClose())
    }
  },
  mounted () {
    console.log(this.$slots.body)
  }
}
</script>

