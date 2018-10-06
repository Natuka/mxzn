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
    <repair-add ref="add" @refresh="refresh"></repair-add>
    <repair-edit ref="edit" @refresh="refreshWithPage"></repair-edit>

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
      url: 'order_flow/repair/service',
      access: {
        add: 'order_flow_repair_add',
        view: 'order_flow_repair_view',
        edit: 'order_flow_repair_edit',
        remove: 'order_flow_repair_remove'
      },
      columns: [
        {
          width: 120,
          fixed: 'left',
          title: '服务单号',
          key: 'number',
          sortable: false
        },
        {
          width: 120,
          // fixed: 'left',
          title: '当前状态',
          key: 'status',
          sortable: false,
          render: this.constRender('status', orderConst.ORDER_STATUS)
        },
        {
          width: 120,
          title: '工单类别',
          key: 'type',
          sortable: false,
          render: this.constRender('type', orderConst.ORDER_TYPE)
        },
        {
          width: 120,
          title: '受理时间',
          key: 'receive_at',
          sortable: false
        },
        {
          width: 120,
          title: '处理进度',
          key: 'progress',
          sortable: false
        },
        {
          width: 120,
          title: '处理时长',
          key: 'progress_use_time',
          sortable: false
        },
        {
          width: 120,
          title: '工程师',
          key: 'engineer_ids',
          sortable: false
        },
        {
          width: 120,
          title: '客户名称',
          key: 'customer_id',
          sortable: false
        },
        {
          width: 120,
          title: '服务级别',
          key: 'level',
          sortable: false,
          render: this.constRender('level', orderConst.ORDER_LEVEL)
        },
        {
          width: 160,
          title: '故障描述',
          key: 'created_at',
          sortable: false
        },
        {
          width: 160,
          title: '报修人员',
          key: 'feedback_staff_id',
          sortable: false
        },
        {
          width: 160,
          title: '电话',
          key: 'created_at',
          sortable: false
        },
        {
          width: 160,
          title: '制单人员',
          key: 'created_at',
          sortable: false
        },
        {
          width: 160,
          title: '制单时间',
          key: 'created_at',
          sortable: false
        },
        {
          width: 160,
          title: '单据状态',
          key: 'status',
          sortable: false,
          render: this.constRender('status', orderConst.ORDER_STATUS)
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
    }
  },
  mounted () {
    // this.refresh()
  }
}
</script>

<style scoped>

</style>
