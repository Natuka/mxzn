<template>
  <div>
    <Card>
      <div slot="title">
        <Button type="primary" @click="onAdd" v-if="accessAdd()">
          新增 <Icon type="md-add" /></Button>

        <Button type="primary" @click="refresh" v-if="accessAdd()">
          刷新 <Icon type="md-add" /></Button>
      </div>
      <agent-search ref="search" @on-search="onSearch"></agent-search>
      <tables ref="tables" :loading="loading" editable search-place="top" v-model="list" :columns="columns" @on-delete="handleDelete"/>
      <br />
      <Page :current="page" :total="total" show-elevator @on-change="toPage" />
      <Button style="margin: 10px 0;" type="primary" @click="exportExcel">导出为Csv文件</Button>
    </Card>
    <agent-add ref="add" @refresh="refresh"></agent-add>
    <agent-edit ref="edit"  @refresh="refreshWithPage"></agent-edit>
    <Button @click="onOpen()">开启</Button>
  </div>
</template>

<script>
import Tables from '_c/tables'
import { getTablePageData } from '@/api/data'

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
    [edit.name]: edit,
  },
  mixins: [listMixin],
  data () {
    return {
      url: 'agent',
      access: {
        add: 'agent_add',
        view: 'agent_view',
        edit: 'agent_edit',
        remove: 'agent_remove',
      },
      columns: [
        {title: 'Name', key: 'name', sortable: true},
        {title: 'Email', key: 'email', editable: true},
        {title: 'Create-Time', key: 'createTime'},
        {
          title: 'Handle',
          key: 'handle',
          options: ['delete'],
          button: [
            (h, params, vm) => {
              return h('Poptip', {
                props: {
                  confirm: true,
                  title: '你确定要删除吗?'
                },
                on: {
                  'on-ok': () => {
                    vm.$emit('on-delete', params)
                    vm.$emit('input', params.tableData.filter((item, index) => index !== params.row.initRowIndex))
                  }
                }
              }, [
                h('Button', '自定义删除')
              ])
            },
            (h, params, vm) => {
              if (!this.accessView()) {
                return
              }
              return h('Button', {
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
              }, '修改')
            },

          ]
        }
      ],
      tableData: []
    }
  },
  methods: {
    handleDelete (params) {
      console.log(params)
    },
    exportExcel () {
      this.$refs.tables.exportCsv({
        filename: `table-${(new Date()).valueOf()}.csv`
      })
    },
    onOpen () {
      this.$refs.add.open()
    },
    onSubmit (e) {
      console.log('onsubmit', e)
      setTimeout(_ => e(), 2000)
    },
    onCancel (e) {
      console.log('oncancel', e)
      e()
    },
    async fetchList () {
      return getTablePageData().then(res => ({
        data: res.data.data,
        total: res.data.total
      }))
    }
  },
  mounted () {
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
