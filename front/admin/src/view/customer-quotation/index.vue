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
      <customerquotation-search ref="search" @on-search="onSearch"></customerquotation-search>
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
    <customerquotation-add ref="add" @refresh="refresh"></customerquotation-add>
    <customerquotation-edit ref="edit" @refresh="refreshWithPage"></customerquotation-edit>
    <!--<Button @click="onOpen()">开启</Button>-->
  </div>
</template>

<script>
import Tables from '_c/tables'
// import {getCustomerquotationList} from '@/api/customerquotation'

import search from './search'
import add from './add'
import edit from './edit'

import listMixin from '../../mixins/list'
import constsMixin from '../../mixins/consts'
import * as customerquotationConst from '../../constants/customerquotation'

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
      url: 'customerquotation',
      access: {
        add: 'customerquotation_add',
        view: 'customerquotation_view',
        edit: 'customerquotation_edit',
        remove: 'customerquotation_remove'
      },
      columns: [
        {
          width: 60,
          fixed: 'left',
          title: '序号',
          key: 'id',
          sortable: false
        },
        {
          width: 150,
          fixed: 'left',
          title: '制单日期',
          key: 'created_at',
          sortable: false
        },
        {
          width: 120,
          fixed: 'left',
          title: '报价单号',
          key: 'billno',
          sortable: false
        },
        {
          width: 120,
          title: '单据状态',
          key: 'status',
          sortable: true,
          render: this.constRender('status', customerquotationConst.STATUS_LIST)
        },
        {
          width: 120,
          title: '有效日期',
          key: 'expiration_date',
          sortable: true
        },
        {
          width: 120,
          title: '客户名称',
          key: 'customer_name',
          sortable: false,
          render: (h, {row: {customer}}) => {
            if (!customer) {
              return h('span')
            }
            return h('span', {}, customer.name_short)
          }
        },
        {
          width: 120,
          title: '联系人',
          key: 'contact_name',
          sortable: false,
          render: (h, {row: {contact}}) => {
            if (!contact) {
              return h('span')
            }
            return h('span', {}, contact.name)
          }
        },
        {
          width: 120,
          title: '手机',
          key: 'contact_mobile',
          sortable: false,
          render: (h, {row: {contact}}) => {
            if (!contact) {
              return h('span')
            }
            return h('span', {}, contact.mobile)
          }
        },
        {
          width: 120,
          title: '付款方式',
          key: 'pay',
          sortable: true,
          render: this.constRender('pay', customerquotationConst.PAY_LIST)
        },
        {
          width: 120,
          title: '运费',
          key: 'carriage',
          sortable: true,
          render: this.constRender('carriage', customerquotationConst.CARRIAGE_LIST)
        },
        {
          width: 120,
          title: '工单编号',
          key: 'order_number',
          sortable: false,
          render: (h, {row: {order}}) => {
            if (!order) {
              return h('span')
            }
            return h('span', {}, order.number)
          }
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
              let buttonTile = '查看'
              if (!this.accessView()) {
                return
              } else {
                if (this.accessEdit()) {
                  buttonTile = '修改'
                }
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
                buttonTile
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
    //   return getCustomerquotationList().then(({data}) => ({
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
