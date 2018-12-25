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
      <customerequipment-search ref="search" @on-search="onSearch"></customerequipment-search>
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
    <customerequipment-add ref="add" @refresh="refresh"></customerequipment-add>
    <customerequipment-edit ref="edit" @refresh="refreshWithPage"></customerequipment-edit>
    <customerequipment-view ref="view" @refresh="refreshWithPage"></customerequipment-view>
  </div>
</template>

<script>
import Tables from '_c/tables'

import search from './search'
import add from './add'
import edit from './edit'
import view from './qrcode'

import listMixin from '../../mixins/list'
import constsMixin from '../../mixins/consts'
import baseMixin from '../../mixins/base'
import * as customerequipmentConst from '../../constants/customerequipment'

export default {
  name: 'tables_page',
  components: {
    Tables,
    [search.name]: search,
    [add.name]: add,
    [edit.name]: edit,
    [view.name]: view
  },
  mixins: [listMixin, constsMixin, baseMixin],
  data () {
    return {
      url: 'customerequipment',
      access: {
        add: 'customerequipment_add',
        view: 'customerequipment_view',
        edit: 'customerequipment_edit',
        remove: 'customerequipment_remove'
      },
      columns: [
        {
          width: 80,
          fixed: 'left',
          title: '序号',
          key: 'id',
          sortable: false
        },
        {
          width: 120,
          fixed: 'left',
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
          fixed: 'left',
          title: '设备编号',
          key: 'number',
          sortable: false
        },
        {
          width: 120,
          title: '设备名称',
          key: 'name',
          sortable: false
        },
        {
          width: 120,
          fixed: 'left',
          title: '规格型号',
          key: 'model',
          sortable: false
        },
        {
          title: '二维码',
          key: 'handle',
          width: 100,
          button: [
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
                      this.onView(params.row)
                    }
                  }
                },
                '查看'
              )
            }
          ]
        },
        {
          width: 95,
          title: '类别',
          key: 'type',
          sortable: false,
          render: this.constRender('type', customerequipmentConst.TYPE_LIST)
        },
        {
          width: 110,
          title: '来源',
          key: 'dfrom',
          sortable: false,
          render: this.constRender('dfrom', customerequipmentConst.DFROM_LIST)
        },
        {
          width: 100,
          title: '合同编号',
          key: 'contract_number',
          sortable: false
        },
        {
          width: 100,
          title: '安装人员',
          key: 'installation_staff',
          sortable: false
        },
        {
          width: 100,
          title: '技术专管',
          key: 'technology_staff',
          sortable: false
        },
        {
          width: 100,
          title: '购买日期',
          key: 'purchase_date',
          sortable: false
        },
        {
          width: 100,
          title: '安装日期',
          key: 'installation_date',
          sortable: false
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
          width: 200,
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
    //   return getCustomerequipmentList().then(({data}) => ({
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
