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
      console.log('this.$refs', this.$refs)
      console.log('this.refName', this.refName)
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
