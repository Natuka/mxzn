<template>
  <div>
    <Card>
      <div slot="title">
        <Button type="primary" @click="onAdd" v-if="accessAdd()">
          新增
          <Icon type="md-add"/>
        </Button>
        <Button
          type="info"
          @click="refresh"
          v-if="accessAdd()"
          class="ml-5"
        >
          刷新
          <Icon type="md-refresh"/>
        </Button>

        <Button
          type="error"
          @click="handleCancel"
          v-if="accessAdd()"
          class="ml-5"
        >
          取消
          <Icon type="md-backspace"/>
        </Button>
        <Button
          type="info"
          @click="handleDispatch"
          v-if="accessAdd()"
          class="ml-5"
        >
          派工
          <Icon type="md-return-right"/>
        </Button>
        <Button
          type="info"
          @click="handleSwitch"
          v-if="accessAdd()"
          class="ml-5"
        >
          转派
          <Icon type="md-repeat"/>
        </Button>
        <Button
          type="success"
          @click="handleComplete"
          v-if="accessAdd()"
          class="ml-5"
        >
          完工
          <Icon type="md-checkmark-circle"/>
        </Button>

        <Button
          type="success"
          @click="next"
          v-if="accessAdd()"
          class="ml-5"
        >
          下一站
          <Icon type="md-arrow-forward"/>
        </Button>
      </div>
      <repair-search ref="search" @on-search="onSearch"></repair-search>
      <tables
        ref="tables"
        :loading="loading"
        editable
        search-place="top"
        v-model="list"
        :columns="columns"
        @on-delete="handleDelete"
        @on-row-click="onRowClick"
        @on-selection-change="selectionChangeHandler"
        :width="tableWidth"
      />
      <br/>
      <Page :current="page" :total="total" show-elevator @on-change="toPage"/>
      <br>
      <br>
      <mx-relation ref="relation"></mx-relation>
    </Card>
    <repair-add ref="add" @refresh="refresh"></repair-add>
    <repair-edit ref="edit" @refresh="refreshWithPage"></repair-edit>

    <mx-order-dispatch ref="dispatch" @refresh="refreshWithPage"></mx-order-dispatch>
    <mx-order-switch ref="switch" @refresh="refreshWithPage"></mx-order-switch>
    <mx-order-cancel ref="cancel" @refresh="refreshWithPage"></mx-order-cancel>

  </div>
</template>

<script>
import Tables from '_c/tables'

import {repairNext, repairFinished} from '@/api/order_flow/repair'
import search from './search'
import add from './add'
import edit from './edit'
import relation from './relation'
import orderCancel from './operation/cancel'
import orderSwitch from './operation/switch'
import orderDispatch from './operation/dispatch'

import listMixin from '../../../mixins/list'
import constsMixin from '../../../mixins/consts'
import baseMixin from '../../../mixins/base'
import * as orderConst from '../../../constants/order_flow'

export default {
  name: 'repair_list',
  components: {
    Tables,
    [search.name]: search,
    [add.name]: add,
    [edit.name]: edit,
    [relation.name]: relation,
    [orderCancel.name]: orderCancel,
    [orderSwitch.name]: orderSwitch,
    [orderDispatch.name]: orderDispatch
  },
  mixins: [listMixin, constsMixin, baseMixin],
  data () {
    return {
      url: 'order_flow/repair',
      access: {
        add: 'order_flow_repair_add',
        view: 'order_flow_repair_view',
        edit: 'order_flow_repair_edit',
        remove: 'order_flow_repair_remove'
      },
      columns: [
        {
          type: 'selection',
          width: 45,
          fixed: 'left',
          align: 'center',
          className: 'i-selection'
        },
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
          width: 160,
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
          sortable: false,
          render: (h, {row}) => {
            if (row.engineers.length <= 0) {
              return h('span', '')
            }
            return h('span', row.engineers.map(info => info.staff_name).join(', '))
          }
        },
        {
          width: 120,
          title: '客户名称',
          key: 'customer_id',
          sortable: false,
          render: (h, {row}) => {
            return h('span', row.customer ? row.customer.name : '')
          }
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
          key: 'desc',
          sortable: false,
          render: (h, {row}) => {
            if (row.fault.length <= 0) {
              return h('span', '')
            }
            return h('span', row.fault.map(info => info.desc).join(', '))
          }
        },
        {
          width: 160,
          title: '报修人员',
          key: 'feedback_staff_id',
          sortable: false,
          render: (h, {row}) => {
            if (!row.feedback_staff) {
              return h('span', '')
            }
            return h('span', row.feedback_staff.name)
          }
        },
        {
          width: 160,
          title: '电话',
          key: 'created_at',
          sortable: false,
          render: (h, {row}) => {
            if (!row.feedback_staff) {
              return h('span', '')
            }
            return h('span', row.feedback_staff.mobile)
          }
        },
        {
          width: 160,
          title: '制单人员',
          key: 'created_by',
          sortable: false
        },
        {
          width: 160,
          title: '制单时间',
          key: 'created_at',
          sortable: false
        },
        // {
        //   width: 160,
        //   title: '单据状态',
        //   key: 'status',
        //   sortable: false,
        //   render: this.constRender('status', orderConst.ORDER_STATUS)
        // },
        {
          fixed: 'right',
          width: 250,
          title: '操作',
          key: 'handle',
          // options: ['delete'],
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
                    click: this.delayLock(() => {
                      this.onEdit(params.row)
                    })
                  }
                },
                '修改'
              )
            }
          ]
        }
      ],
      tableData: [],
      selected: [],
      selectedData: {
        data: {},
        index: -1
      }
    }
  },
  methods: {
    handleDelete (params) {
      console.log(params)
    },
    handleCancel () {
      if (this.selectedData.index < 0) {
        return this.$Message.info('请选择要操作的工单')
      }
      this.$refs.cancel.setData(this.selectedData.data, true)
      this.$refs.cancel.open()
    },
    handleSwitch () {
      if (this.selectedData.index < 0) {
        return this.$Message.info('请选择要操作的工单')
      }
      this.$refs.switch.setData(this.selectedData.data, true)
      this.$refs.switch.open()
    },
    handleDispatch () {
      if (this.selectedData.index < 0) {
        return this.$Message.info('请选择要操作的工单')
      }
      this.$refs.dispatch.setData(this.selectedData.data, true)
      this.$refs.dispatch.open()
    },
    handleComplete () {
      if (!this.selected.length) {
        return this.$Message.error('请选择要操作的工单[复选框]')
      }

      let post = this.selected.map(el => el.id)

      this.$Modal.confirm({
        title: '提示',
        content: '确认送往下一站[审核关闭]？',
        loading: true,
        onOk: () => {
          repairFinished({
            post
          }).then(({data}) => {
            this.$Notice.success({
              title: '下一站',
              desc: data.message
            })
            this.$Modal.remove()
            this.refresh()
          }).catch(({message, response}) => {
            this.$Notice.error({
              title: '错误提示',
              desc: (response && response.data && response.data.message) || message
            })
            this.$Modal.remove()
          })
        },
        onCancel: () => {

        }
      })
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
      this.selectedData = {
        data,
        index
      }
      // console.log('EditData', data)
      this.$refs.relation.setData(data, index)
    },
    next () {
      if (!this.selected.length) {
        return this.$Message.error('请选择要操作的工单')
      }

      let post = this.selected.map(el => el.id)

      this.$Modal.confirm({
        title: '提示',
        content: '确认送往下一站？',
        loading: true,
        onOk: () => {
          repairNext({
            post
          }).then(({data}) => {
            this.$Notice.success({
              title: '下一站',
              desc: data.message
            })
            this.$Modal.remove()
            this.refresh()
          }).catch(({message, response}) => {
            this.$Notice.error({
              title: '错误提示',
              desc: (response && response.data && response.data.message) || message
            })
            this.$Modal.remove()
          })
        },
        onCancel: () => {

        }
      })
    },
    selectionChangeHandler (list) {
      this.selected = list
    }
  },
  mounted () {
    this.refresh()
  }
}
</script>

<style>
</style>
