export default {
  data () {
    return {
      refName: 'ref',
      data: {},
      access: true
    }
  },
  methods: {
    async setData (data, access = true) {
      this.data = data
      this.access = access
      console.log('access', access)
      await this.afterSetData()
    },
    // 设定数据
    async afterSetData () {
      return Promise.resolve(true)
    },
    async beforeOpen () {
      return Promise.resolve(true)
    },
    async afterOpen () {
      return Promise.resolve(true)
    },
    // 开启页面
    async onOpen () {
      await this.beforeOpen()
      this.getModal().open()
      this.afterOpen()
    },
    async open () {
      let can = await this.beforeOpen()
      if (!can) {
        return
      }
      this.getModal().open()
      this.afterOpen()
      // 刷新上一层的数据
      // this.$emit('refreshData')
    },
    async beforeClose () {
      return Promise.resolve(true)
    },
    afterClose () {
    },
    async close () {
      let can = await this.beforeClose()
      if (!can) {
        return
      }
      this.getModal().close()
    },
    getModal () {
      return this.$refs[this.refName]
    },
    withRefresh (e) {
      e && e()
      this.$emit('refresh')
    },
    closeLoading () {
      this.getModal().closeLoading()
    }
  }
}
