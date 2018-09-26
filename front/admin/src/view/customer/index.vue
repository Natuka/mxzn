<template>
  <div>
    <Card>
      <div slot="title">
        <Button type="primary" @click="onAdd" v-if="accessAdd()">
          新增 <Icon type="md-add" /></Button>

        <Button type="primary" @click="refresh" v-if="accessAdd()" class="ml-5">
          刷新 <Icon type="md-add" /></Button>
      </div>
      <agent-search ref="search" @on-search="onSearch"></agent-search>
      <tables ref="tables" :loading="loading" editable search-place="top" v-model="list" :columns="columns" @on-delete="handleDelete"/>
      <br />
      <Page :current="page" :total="total" show-elevator @on-change="toPage" />
      <!--<Button style="margin: 10px 0;" type="primary" @click="exportExcel">导出为Csv文件</Button>-->
    </Card>
    <customer-add ref="add" @refresh="refresh"></customer-add>
    <customer-edit ref="edit"  @refresh="refreshWithPage"></customer-edit>
  </div>
</template>

<script>
import Tables from '_c/tables'

import search from './search'
import add from './add'
import edit from './edit'

import listMixin from '../../mixins/list'

export default {
  name: 'tables_page',
  components: {
    Tables,
    [search.name]: search,
    [add.name]: add,
    [edit.name]: edit
  },
  mixins: [listMixin],
  data() {
    return {
      url: 'customer',
      access: {
        add: 'customer_add',
        view: 'customer_view',
        edit: 'customer_edit',
        remove: 'customer_remove'
      },
      columns: [
        { title: '公司编号', key: 'number', sortable: true },
        { title: '公司名称', key: 'name', sortable: true },
        { title: '所属行业', key: 'industry', editable: true },
        { title: '客户类别', key: 'type', sortable: true },
        { title: '客户级别', key: 'level', sortable: true },
        { title: '跟进状态', key: 'follow_up_status', editable: true },
        { title: '客户来源', key: 'source', editable: true },
        { title: '建档日期', key: 'createTime' },
        {
          title: 'Handle',
          key: 'handle',
          options: ['delete'],
          button: [
            (h, params, vm) => {
              return h(
                'Poptip',
                {
                  props: {
                    confirm: true,
                    title: '你确定要删除吗?'
                  },
                  on: {
                    'on-ok': () => {
                      vm.$emit('on-delete', params)
                      vm.$emit(
                        'input',
                        params.tableData.filter(
                          (item, index) => index !== params.row.initRowIndex
                        )
                      )
                    }
                  }
                },
                [h('Button', '自定义删除')]
              )
            },
            (h, params, vm) => {
              if (!this.accessView()) {
                return
              }
              return h(
                'Button',
                {
                  props: {
                    type: 'primary'
                  },
                  style: {
                    marginLeft: '.6rem'
                  },
                  on: {
                    click: () => {
                      this.onEdit()
                    }
                  }
                },
                '修改'
              )
            }
          ]
        }
      ],
      tableData: []
    }
  },
  methods: {
    handleDelete(params) {
      console.log(params)
    },
    exportExcel() {
      this.$refs.tables.exportCsv({
        filename: `table-${new Date().valueOf()}.csv`
      })
    },
    onOpen() {
      this.$refs.add.open()
    },
    onSubmit(e) {
      console.log('onsubmit', e)
      setTimeout(_ => e(), 2000)
    },
    onCancel(e) {
      console.log('oncancel', e)
      e()
    }
    // ,
    // async fetchList() {
    //   return getTablePageData().then(res => ({
    //     data: res.data.data,
    //     total: res.data.total
    //   }))
    // }
  },
  mounted() {
    this.refresh()
    // getTablePageData().then(res => {
    //   console.log('res', res)
    //   this.tableData = res.data.data
    //   this.total = res.data.total
    // })
  }
}
</script>

<style>
</style>
