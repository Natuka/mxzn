<template>
  <div>
    <Card>
      <div slot="title">
        <Button type="primary" @click="onAdd" v-if="accessAdd()">
          新增
          <Icon type="md-add"/>
        </Button>
        <Button
          type="primary"
          @click="refresh"
          v-if="accessAdd()"
          class="ml-5"
        >
          刷新
          <Icon type="md-refresh"/>
        </Button>
      </div>
      <department-search ref="search" @on-search="onSearch"></department-search>
      <tables ref="tables" :loading="loading" editable search-place="top" v-model="list" :columns="columns"
              @on-delete="handleDelete"/>
      <br/>
      <Page :current="page" :total="total" show-elevator @on-change="toPage"/>
      <Button style="margin: 10px 0;" type="primary" @click="exportExcel">导出为Csv文件</Button>
    </Card>
    <department-add ref="add" @refresh="refresh"></department-add>
    <department-edit ref="edit" @refresh="refreshWithPage"></department-edit>
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
  data () {
    return {
      url: 'department',
      access: {
        add: 'department_add',
        view: 'department_view',
        edit: 'department_edit',
        remove: 'department_remove'
      },
      columns: [
        {
          width: 160,
          title: '组织/公司',
          key: 'org_id',
          sortable: false,
          render: (h, {row}) => {
            return h('span', {}, row.organization ? row.organization.name : '')
          }
        },
        {
          width: 150,
          title: '上级部门',
          key: 'parent_id',
          editable: false,
          render: (h, {row}) => {
            return h('span', {}, row.parent ? row.parent.name : '')
          }
        },
        {
          width: 150,
          title: '部门编号',
          key: 'number',
          editable: false
        },
        {
          width: 150,
          title: '部门名称',
          key: 'name',
          editable: false
        },
        {
          width: 160,
          title: '创建时间',
          key: 'created_at'
        },
        {
          fixed: 'right',
          width: 340,
          title: '操作',
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
                      this.onDelete(params.row)
                    }
                  }
                }
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
                      this.onEdit(params.row)
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
    handleDelete (params) {
      console.log(params)
    },
    exportExcel () {
      this.$refs.tables.exportCsv({
        filename: `table-${new Date().valueOf()}.csv`
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
