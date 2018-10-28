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
      <tables
        ref="tables"
        :loading="loading"
        editable
        search-place="top"
        v-model="list"
        :columns="columns"
        @on-delete="handleDelete"
        @on-row-click="onRowClick"
        :width="tableWidth"
      />
      <br/>
      <Page :current="page" :total="total" show-elevator @on-change="toPage"/>
    </Card>
    <service-add ref="add" @refresh="refresh"></service-add>
    <service-edit ref="edit" @refresh="refreshWithPage"></service-edit>

  </div>
</template>

<script>
import Tables from '_c/tables'

import search from './search'
import add from './add'
import edit from './edit'

import listMixin from '@/mixins/list'
import constsMixin from '@/mixins/consts'
import baseMixin from '@/mixins/base'
import * as orderConst from '@/constants/order_flow'

export default {
  name: 'mx-order-service',
  components: {
    Tables,
    [search.name]: search,
    [add.name]: add,
    [edit.name]: edit
  },
  mixins: [listMixin, constsMixin, baseMixin],
  props: {
    data: {
      type: Object,
      default () {
        return {}
      }
    }
  },
  data () {
    return {
      url: 'order_flow/dispatch/service',
      access: {
        add: 'order_flow_dispatch_add',
        view: 'order_flow_dispatch_view',
        edit: 'order_flow_dispatch_edit',
        remove: 'order_flow_dispatch_remove'
      },
      columns: [
        {
          width: 120,
          fixed: 'left',
          title: '服务名称',
          key: 'name',
          sortable: false
        },
        {
          width: 120,
          title: '服务内容',
          key: 'content',
          sortable: false
        },
        {
          width: 120,
          title: '服务时间',
          key: 'workday',
          sortable: false
        },
        {
          width: 120,
          title: '地区',
          key: 'area',
          sortable: false,
          render: this.constRender('area', orderConst.SERVICE_AREA)
        },
        {
          width: 120,
          title: '单价',
          key: 'price',
          sortable: false
        },
        {
          width: 120,
          title: '单位',
          key: 'unit',
          sortable: false
        },
        {
          width: 120,
          title: '数量',
          key: 'quantity',
          sortable: false
        },
        {
          width: 120,
          title: '金额',
          key: 'amount',
          sortable: false
        },
        {
          width: 120,
          title: '提成',
          key: 'reward',
          sortable: false
        },
        {
          width: 160,
          title: '是否含陆路交通费',
          key: 'is_land_traffic',
          sortable: false,
          render: this.constRender('is_land_traffic', orderConst.SERVICE_LAND_TRAFFIC)
        },
        {
          width: 160,
          title: '是否含住宿',
          key: 'is_hotel',
          sortable: false,
          render: this.constRender('is_hotel', orderConst.SERVICE_HOTEL)
        },
        {
          width: 160,
          title: '结算方式',
          key: 'settlement_method',
          sortable: false,
          render: this.constRender('settlement_method', orderConst.SERVICE_SETTLEMENT_METHOD)
        },
        {
          width: 160,
          title: '工时',
          key: 'working_hours',
          sortable: false
        },
        {
          width: 160,
          title: '是否完工',
          key: 'is_complete',
          sortable: false,
          render: this.constRender('is_complete', orderConst.SERVICE_COMPLETE)
        },
        {
          width: 160,
          title: '备注',
          key: 'remark',
          sortable: false
        },
        {
          fixed: 'right',
          width: 250,
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
    },
    onRowClick (data, index) {
      console.log('data', data, index)
    },
    setUrl (data) {
      this.url = `order_flow/dispatch/${data.id}/service`
    },
    onAddSetData () {
      this.$refs.add.setDataBefore(this.data)
    },
    onEditSetData () {
      this.$refs.edit.setDataBefore(this.data)
    }
  },
  mounted () {
    // this.refresh()
  }
}
</script>

<style scoped>

</style>
