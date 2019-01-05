<template>
  <div>
    <Card>
      <div slot="title">
        <Button type="primary" @click="refresh" v-if="accessView()" class="ml-5">
          刷新
          <Icon type="md-refresh"/>
        </Button>
      </div>
      <quotation-materiel-search ref="search" @on-search="onSearch"></quotation-materiel-search>
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

  </div>
</template>

<script>
import Tables from '_c/tables'

import search from './search'

import listMixin from '../../mixins/list'
import constsMixin from '../../mixins/consts'
import * as customerquotationConst from '../../constants/customerquotation'

export default {
  name: 'tables_page',
  components: {
    Tables,
    [search.name]: search
  },
  mixins: [listMixin, constsMixin],
  data () {
    return {
      url: 'customerquotation/materiel',
      access: {
        view: 'customerquotation_materiel_view',
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
          title: '制单日期',
          key: 'created_at',
          sortable: false
        },
        {
          width: 120,
          title: '报价单号',
          key: 'billno',
          sortable: false,
          render: (h, {row: {quotation}}) => {
            if (!quotation) {
              return h('span')
            }
            return h('span', {}, quotation.billno)
          }
        },
        {
          width: 120,
          title: '单据状态',
          key: 'status',
          sortable: true,
          render: (h, {row: {quotation}}) => {
            if (!quotation) {
              return h('span')
            }
            return this.constRender('status', customerquotationConst.STATUS_LIST)
          }
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
          width: 100,
          title: '有效日期',
          key: 'expiration_date',
          sortable: false
        },
        {
          width: 130,
          title: '料号',
          key: 'number',
          sortable: false
        },
        {
          width: 160,
          title: '品名',
          key: 'name',
          editable: false,
          sortable: false
        },
        {
          width: 100,
          title: '型号规格',
          key: 'model',
          editable: false,
          sortable: false
        },
        {
          width: 100,
          title: '单位',
          key: 'unit'
        },
        {
          width: 100,
          title: '数量',
          key: 'quantity'
        },
        {
          width: 100,
          title: '单价',
          key: 'price',
          editable: false,
          sortable: false
        },
        {
          width: 100,
          title: '金额',
          key: 'amount'
        },

        {
          width: 100,
          title: '折扣',
          key: 'discount',
          sortable: false
        },
        {
          width: 100,
          title: '折扣后金额',
          key: 'discount_amount'
        },
        {
          width: 120,
          title: '税率',
          key: 'tax_rate',
          render: (h, {row: {tax_rate}}) => {
            if (+tax_rate === 0) {
              return h('span', {}, '不含税')
            }
            return h('span', {}, tax_rate + '%')
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
          width: 100,
          title: '备注',
          key: 'remark'
        },
        {
          title: ' ',
          key: ''
        }
        // ,
        // {
        //   width: 200,
        //   fixed: 'right',
        //   title: '操作',
        //   key: 'handle',
        //   options: ['delete'],
        //   button: [
        //     (h, params, vm) => {
        //       return h(
        //         'Poptip',
        //         {
        //           props: {
        //             confirm: true,
        //             title: '你确定要删除吗?'
        //           },
        //           on: {
        //             'on-ok': () => {
        //               this.onDelete(params.row)
        //             }
        //           }
        //         }
        //       )
        //     },
        //     (h, params, vm) => {
        //       if (!this.accessView()) {
        //         return
        //       }
        //       return h(
        //         'Button',
        //         {
        //           props: {
        //             type: 'primary'
        //           },
        //           style: {
        //             marginLeft: '.6rem'
        //           },
        //           on: {
        //             click: () => {
        //               this.onEdit(params.row)
        //             }
        //           }
        //         },
        //         '修改'
        //       )
        //     }
        //   ]
        // }
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
  }
}
</script>
<style>
</style>
