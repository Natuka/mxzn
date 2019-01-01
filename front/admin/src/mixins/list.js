import {getApi, deleteApi} from '../libs/api.request'

export default {
  data () {
    return {
      list: [], // 列表页
      // 复制的列表
      cloneList: [],
      // 已选择的列表
      selected: [],
      total: 0,
      page: 1,
      params: {},
      url: '',
      deleteUrl: '',
      tableWidth: 1000,
      loading: false,
      method: 'fetchList',
      access: {
        add: '',
        edit: '',
        del: '',
        view: ''
      },
      lock: false
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
    // 允许删除
    accessDel () {
      return this.$store.getters.hasAccess(this.access.del)
    },
    // 暂时执行空转函数
    // 用于需要自定义设定值时
    onAddSetData () {
    },
    // 添加时，额外设定内容
    onEditSetData () {
    },
    // 添加时，额外设定内容
    onViewSetData () {
    },
    onAdd () {
      console.log('onAdd563')
      this.onAddSetData()
      this.$refs.add.open()
    },
    onAdd2 () {
      console.log('onAdd2-96656')
      this.onAddSetData()
      this.$refs.add2.open()
    },
    async onEdit (data) {
      let edit = this.$refs.edit
      this.onEditSetData()
      await edit.setData(data, this.accessEdit())
      edit.open()
    },
    async onEdit2 (data) {
      let edit = this.$refs.edit2
      this.onEditSetData()
      await edit.setData(data, this.accessEdit())
      edit.open()
    },
    async onView (data) {
      let view = this.$refs.view
      this.onViewSetData()
      await view.setData(data, this.accessView())
      view.open()
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
      let res = await this[this.method](this.getUrl(), {page, ...params})
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
    },
    async fetchList (url, params = {}) {
      return getApi(url, params).then(({data}) => ({
        data: data.data,
        total: data.total
      }))
    },
    // 设定表单宽度
    setTableWidth () {
      let leftSider = document.querySelector('.left-sider')
      this.tableWidth = window.innerWidth - leftSider.offsetWidth - 80
    },
    getDeleteUrl (params) {
      let url = this.url
      if (this.deleteUrl) {
        url = this.deleteUrl
      }

      return url + '/' + params.id
    },
    // 删除API
    async onDelete (params) {
      try {
        await deleteApi(this.getDeleteUrl(params), params)
        // 刷新当前页
        this.refreshWithPage()
      } catch (e) {
        console.log('e', e)
      }
    },
    /**
     * 获取选中的节点
     * @return {[type]} [description]
     */
    getSelectedDataFromClone () {
      if (!this.selected.length) {
        return []
      }
      let selectedIds = this.selected.map(el => el.id)
      // console.log('selectedIds', selectedIds)
      return this.cloneList.filter(el => ~selectedIds.indexOf(el.id))
    },
    delayLock (fn = () => {}, delay = 50) {
      return (...args) => {
        const innerFn = () => fn(...args)
        this.$refs.tables.delayLock(innerFn, delay)
      }
    },
    fnWithoutOpenRow (fn) {
      return (...args) => {
        this.runWithoutOpenRow(fn, args)
      }
    },
    runWithoutOpenRow (fn, args = []) {
      try {
        this.lock = true
        fn(...args)
      } finally {
        setTimeout(() => {
          this.lock = false
        }, 50)
      }
    }
  },
  mounted () {
    this.setTableWidth()
  }
}
