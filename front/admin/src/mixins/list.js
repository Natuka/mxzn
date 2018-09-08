export default {
  data () {
    return {
      list: [], // 列表页
      total: 0,
      page: 1,
      params: {},
      url: '',
      loading: false,
      method: 'fetchList',
      access: {
        add: '',
        edit: '',
        view: ''
      }
    }
  },
  methods: {
    // 允许编辑
    accessEdit () { 
      return this.$store.getters.hasAccess(this.access.edit)
    },
    // 允许查看
    accessView () { 
      return this.$store.getters.hasAccess(this.access.view)
    },
    // 允许新增
    accessAdd () {
      return this.$store.getters.hasAccess(this.access.add)
    },
    onAdd () {
      this.$refs.add.open()
    },
    async onEdit (data) {
      let edit = this.$refs.edit
      await edit.setData(data, this.accessEdit())
      edit.open()
    },
    // 跳转到第x页
    async toPage (page = 1) {
      this.page = page
      this.loading = true
      await this.loadData()
      this.loading = false
    },
    // 这边需要获取页数
    async loadData () {
      let page = this.page
      let params = this.params
      let res = await this[this.method](this.getUrl(),{ page,...params })
      // console.log('res', res)
      this.list = res.data
      this.total = res.total
      return res
    },
    // 获取URL
    getUrl () {
      return this.url
    },
    // 刷新从第一页开始
    async refresh () {
      this.toPage(1)
    },
    // 刷新当前页面
    async refreshWithPage () {
      this.toPage(this.page)
    },
    // 进行查询
    async onSearch (params) {
      this.params = params
      await this.refresh()
      console.log('onSearch', params)
      this.closeSearchLoading()
    },
    closeSearchLoading () {
      this.$refs.search && this.$refs.search.closeLoading()
    }
  }
}
