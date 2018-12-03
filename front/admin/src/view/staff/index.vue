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
      <staff-search ref="search" @on-search="onSearch"></staff-search>
      <tables
        ref="tables"
        :loading="loading"
        editable
        search-place="top"
        v-model="list"
        :columns="columns"
        @on-delete="handleDelete"
        :width="tableWidth"
      />
      <br/>
      <Page :current="page" :total="total" show-elevator @on-change="toPage"/>
      <Button style="margin: 10px 0;" type="primary" @click="exportExcel">导出为Csv文件</Button>
    </Card>
    <staff-add ref="add" @refresh="refresh"></staff-add>
    <staff-edit ref="edit" @refresh="refreshWithPage"></staff-edit>
  </div>
</template>

<script>
import Tables from '_c/tables'

import search from './search'
import add from './add'
import edit from './edit'

import listMixin from '../../mixins/list'
import constsMixin from '../../mixins/consts'
import baseMixin from '../../mixins/base'
import * as staffConst from '../../constants/staff'

export default {
  name: 'tables_page',
  components: {
    Tables,
    [search.name]: search,
    [add.name]: add,
    [edit.name]: edit
  },
  mixins: [listMixin, constsMixin, baseMixin],
  data () {
    return {
      url: 'staff',
      access: {
        add: 'staff_add',
        view: 'staff_view',
        edit: 'staff_edit',
        remove: 'staff_remove'
      },
      columns: [
        {
          width: 120,
          fixed: 'left',
          title: '编号',
          key: 'number',
          sortable: false
        },
        {
          width: 120,
          fixed: 'left',
          title: '姓名',
          key: 'name',
          sortable: false
        },
        {
          width: 70,
          title: '性别',
          key: 'sex',
          sortable: false,
          render: this.constRender('sex', staffConst.SEX_LIST)
        },
        {
          width: 120,
          title: '出生日期',
          key: 'birthday',
          sortable: false
        },
        {
          width: 160,
          title: '组织/公司',
          key: 'org_id',
          sortable: false,
          render: (h, {row: {organization}}) => {
            if (!organization) {
              return h('span')
            }
            return h('sapn', {}, organization.name)
          }
        },
        {
          width: 150,
          title: '部门',
          key: 'department',
          sortable: false,
          render: (h, {row: {dept}}) => {
            if (!dept) {
              return h('span')
            }
            return h('sapn', {}, dept.name)
          }
        },
        {
          width: 80,
          title: '职位',
          key: 'post',
          sortable: false,
          render: this.baseRender('post', 'findPost')
        },
        {
          width: 80,
          title: '职务',
          key: 'job',
          sortable: false,
          render: this.baseRender('job', 'findJob')
        },
        {
          width: 100,
          title: '手机',
          key: 'mobile',
          sortable: false
        },
        {
          width: 100,
          title: '在职状态',
          key: 'status',
          sortable: false,
          render: this.constRender('status', staffConst.STATUS_LIST)
        },
        {
          width: 150,
          title: '建档日期',
          key: 'created_at',
          sortable: false
        },
        {
          title: ' ',
          key: ''
        },
        {
          fixed: 'right',
          width: 160,
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
                    title: '你确定要删除吗?',
                    options: {
                      positionFixed: true
                    }
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
    // ,
    // async fetchList () {
    //   return getStaffList().then(({data}) => ({
    //     data: data.data,
    //     total: data.total
    //   }))
    // }
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
