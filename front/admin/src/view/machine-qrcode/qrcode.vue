<template>
  <div>
    <Modal :mask-closable="false"
           v-model="modal"
           title="二维码"
           :loading="loading"
           @on-ok="asyncOK"
           @on-cancel="cancel"
           :width="800"
           class="form-three-column"
           :class="hasMenuClass('staff_qrcode')"
    >
      <Form ref="add" :model="data" :rules="rules" :label-width="60">
        <FormItem  prop="code">
          <img v-if="src" :src="src" width="600" />
          <span v-else>暂无图片</span>
        </FormItem>
        <FormItem style="width: 100%">
          <a :href="src" :download="download">下载</a>
        </FormItem>
      </Form>
    </Modal>
  </div>
</template>

<script>
import dialogMixin from '@/mixins/dialog'

export default {
  mixins: [dialogMixin],
  data () {
    let rules = {}

    return {
      rules,
      data: {},
      initData: {},
      path: ''
    }
  },
  computed: {
    src () {
      if (this.path) {
        // return 'http://api.lovework.com' + this.path
        return 'https://service.mxhj.net/' + this.path
      }
      return ''
    },
    download () {
      return '经纪人_' + this.data.name
    }
  },
  methods: {
    asyncOK () {
    },
    cancel () {
      this.close(() => {
        this.$router.push('/staff')
      })
    },
    formatData (data) {
      this.$api.staffQRCode(data.id).then(({data}) => {
        this.path = data.path
      }).catch(({message, response}) => {
      })
    }
  }
}
</script>
