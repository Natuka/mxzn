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
    <repairs-add ref="add" @refresh="refresh"></repairs-add>
    <repairs-edit ref="edit" @refresh="refreshWithPage"></repairs-edit>

  </div>
</template>

<script>
import dayjs from 'dayjs'

import Tables from '_c/tables'

import search from './search'
import add from './add'
import edit from './edit'

import listMixin from '@/mixins/list'
import constsMixin from '@/mixins/consts'
import baseMixin from '@/mixins/base'
import * as orderConst from '@/constants/order_flow'

export default {
  name: 'mx-order-repairs',
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
      url: 'order_flow/dispose/repairs',
      access: {
        add: 'order_flow_dispose_add',
        view: 'order_flow_dispose_view',
        edit: 'order_flow_dispose_edit',
        remove: 'order_flow_dispose_remove'
      },
      columns: [
        {
          width: 150,
          fixed: 'left',
          title: '操作时间',
          key: 'created_at',
          sortable: false
        },
        // {
        //   width: 120,
        //   // fixed: 'left',
        //   title: '处理方式',
        //   key: 'status',
        //   sortable: false,
        //   render: this.constRenderCustomData('status', orderConst.ORDER_STATUS, true, this.data)
        // },
        {
          width: 120,
          title: '工程师',
          key: 'staff_name',
          sortable: false
        },
        {
          width: 150,
          title: '到达时间',
          key: 'arrived_at',
          sortable: false
        },
        {
          width: 150,
          title: '完成时间',
          key: 'complete_at',
          sortable: false
        },
        {
          width: 120,
          title: '处理时长',
          key: 'progress_use_time',
          sortable: false,
          render: (h, {row}) => {
            let text = '进行中'
            if (row.complete_at) {
              text = dayjs(row.complete_at).diff(dayjs(row.arrived_at), 'hours') + '时'
            }

            return h('span', {}, text)
          }
        },
        {
          width: 120,
          title: '故障原因',
          key: 'cause',
          sortable: false
        },
        {
          width: 120,
          title: '处理措施/结果',
          key: 'step_result',
          sortable: false
        },
        {
          width: 120,
          title: '处理进度',
          key: 'process_id',
          sortable: false,
          render: this.constRender('process_id', orderConst.REPAIR_PROCESS)
        },
        {
          width: 160,
          title: '下一步处理',
          key: 'next_step',
          sortable: false
        },
        {
          width: 160,
          title: '处理人员',
          key: 'staff_name',
          sortable: false
        },
        {
          width: 160,
          title: '操作人员',
          key: 'created_by',
          sortable: false
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
      this.url = `order_flow/dispose/${data.id}/repairs`
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
