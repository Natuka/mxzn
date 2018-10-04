<script src="../../constants/customercontact.js"></script>
<script src="../../constants/staff.js"></script>
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
      <customercontact-search ref="search" @on-search="onSearch"></customercontact-search>
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
    <customercontact-add ref="add" @refresh="refresh"></customercontact-add>
    <customercontact-edit ref="edit" @refresh="refreshWithPage"></customercontact-edit>
    <!--<Button @click="onOpen()">开启</Button>-->
  </div>
</template>

<script>
import Tables from '_c/tables'
// import {getCustomercontactList} from '@/api/customercontact'

import search from './search'
import add from './add'
import edit from './edit'

import listMixin from '../../mixins/list'
import constsMixin from '../../mixins/consts'
import * as customercontactConst from '../../constants/customercontact'

export default {
  name: 'tables_page',
  components: {
    Tables,
    [search.name]: search,
    [add.name]: add,
    [edit.name]: edit
  },
  mixins: [listMixin, constsMixin],
  data () {
    return {
      url: 'customercontact',
      access: {
        add: 'customercontact_add',
        view: 'customercontact_view',
        edit: 'customercontact_edit',
        remove: 'customercontact_remove'
      },
      columns: [
        {
          width: 120,
          fixed: 'left',
          title: '公司',
          key: 'cust_id',
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
          width: 120,
          title: '性别',
          key: 'sex',
          sortable: true,
          render: this.constRender('sex', customercontactConst.SEX_LIST)
        },
        {
          width: 120,
          title: '出生日期',
          key: 'birthday',
          sortable: true
        },
        {
          width: 120,
          title: '所属部门',
          key: 'department',
          sortable: true,
          render: this.constRender('department', customercontactConst.DEPT_LIST)
        },
        {
          width: 120,
          title: '职位',
          key: 'post',
          sortable: false,
          render: this.constRender('post', customercontactConst.POST_LIST)
        },
        {
          width: 120,
          title: '职务',
          key: 'job',
          sortable: false
        },
        {
          width: 120,
          title: '手机',
          key: 'mobile',
          sortable: true
        },
        {
          width: 120,
          title: '微信',
          key: 'weixin',
          sortable: true
        },
        {
          width: 120,
          title: '在职状态',
          key: 'status',
          sortable: false,
          render: this.constRender('status', customercontactConst.STATUS_LIST)
        },
        {
          width: 160,
          title: '建档日期',
          key: 'created_at',
          sortable: false
        },
        {
          width: 300,
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
                      this.onDelete(params.row)
                    }
                  }
                },
                [h('Button', '删除')]
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
    //   return getCustomercontactList().then(({data}) => ({
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
