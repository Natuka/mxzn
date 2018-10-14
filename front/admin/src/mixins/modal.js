export default {
  data () {
    return {
      refName: 'ref',
      data: {},
      access: true
    }
  },
  methods: {
    async formatData (data) {
      return Promise.resolve(data)
    },
    // 执行设定值
    setDataBefore () {
    },
    async setData (data, access = true) {
      this.data = await this.formatData(data)
      this.access = access
      await this.afterSetData()
    },
    // 设定数据
    async afterSetData () {
    },
    async beforeOpen () {
      return Promise.resolve(true)
    },
    afterOpen () {
    },
    // 开启页面
    onOpen () {
      this.getModal().open()
    },
    // 开启
    async open () {
      let can = await this.beforeOpen()
      if (!can) {
        return
      }
      console.log('this.open', this.$refs)
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
    // 关闭
    async close () {
      let can = await this.beforeClose()
      if (!can) {
        return
      }
      this.getModal().close()
    },
    // 获取ref
    getModal () {
      return this.$refs[this.refName]
    },
    // 执行刷新
    withRefresh (e) {
      e && e()
      this.$emit('refresh')
    },
    // 关闭loading
    closeLoading () {
      this.getModal().closeLoading()
    },
    listByConstant (list) {
      return list.map((value, index) => ({
        value,
        index
      }))
    }
  }
}
