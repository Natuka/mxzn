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
    }
  }
}
