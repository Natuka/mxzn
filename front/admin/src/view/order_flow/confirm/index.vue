<template>
  <div>
    <Card>
      <div slot="title">
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
          type="warning"
          @click="back"
          v-if="accessAdd()"
          class="ml-5"
        ><Icon type="md-arrow-back" />
          退回
        </Button>
        <Button
          type="success"
          @click="next"
          v-if="accessAdd()"
          class="ml-5"
        >
          下一站
          <Icon type="md-arrow-forward" />
        </Button>
      </div>
      <confirm-search ref="search" @on-search="onSearch"></confirm-search>
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
    <confirm-add ref="add" @refresh="refresh"></confirm-add>
    <repair-edit ref="edit" @refresh="refreshWithPage"></repair-edit>
    <repair-edit2 ref="edit2" @refresh="refreshWithPage"></repair-edit2>
  </div>
</template>

<script>
import Tables from '_c/tables'

import {confirmBack, confirmNext} from '@/api/order_flow/confirm'
import search from './search'
import add from './add'
import edit from '../repair/edit'
import edit2 from '../repair/edit2'
import relation from './relation'

import listMixin from '../../../mixins/list'
import constsMixin from '../../../mixins/consts'
import baseMixin from '../../../mixins/base'
import * as orderConst from '../../../constants/order_flow'

export default {
  name: 'confirm_list',
  components: {
    Tables,
    [search.name]: search,
    [add.name]: add,
    [edit.name]: edit,
    [edit2.name]: edit2,
    [relation.name]: relation
  },
  mixins: [listMixin, constsMixin, baseMixin],
  data () {
    return {
      url: 'order_flow/confirm',
      access: {
        add: 'order_flow_confirm_add',
        view: 'order_flow_confirm_view',
        edit: 'order_flow_confirm_edit',
        remove: 'order_flow_confirm_remove'
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
          title: '客户名称',
          key: 'customer_id',
          sortable: false,
          render: (h, {row}) => {
            return h('span', row.customer ? row.customer.name_short : '')
          }
        },
        // {
        //   width: 120,
        //   title: '服务级别',
        //   key: 'level',
        //   sortable: false,
        //   render: (h, {row}) => {
        //     let level = row.customer ? row.customer.level : 0
        //     return this.constRender(level, orderConst.ORDER_LEVEL)
        //   }
        // },
        {
          title: ' ',
          key: ''
        },
        {
          width: 120,
          title: '客户设备',
          key: 'equipment_id',
          sortable: false,
          render: (h, {row}) => {
            if (row.fault.length <= 0) {
              return h('span', '1')
            }
            let equipment = row.fault[0].equipment
            if (equipment.length <= 0) {
              return h('span', '2')
            }
            return h('span', equipment ? equipment.name : '3')
          }
        },
        // {
        //   width: 120,
        //   title: '处理进度',
        //   key: 'progress',
        //   sortable: false
        // },
        // {
        //   width: 120,
        //   title: '处理时长',
        //   key: 'progress_use_time',
        //   sortable: false
        // },
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
            // (h, params, vm) => {
            //   return h(
            //     'Poptip',
            //     {
            //       props: {
            //         confirm: true,
            //         title: '你确定要删除吗?'
            //       },
            //       on: {
            //         'on-ok': () => {
            //           vm.$emit('on-delete', params)
            //           vm.$emit(
            //             'input',
            //             params.tableData.filter(
            //               (item, index) => index !== params.row.initRowIndex
            //             )
            //           )
            //         }
            //       }
            //     },
            //     [h('Button', {
            //       nativeOn: {
            //         click: this.delayLock((e) => {
            //           console.log('open poper-show')
            //         })
            //       }
            //     }, '删除')]
            //   )
            // },
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
                      if (+params.row.type === 3) {
                        // 维修工单编辑页面不一样
                        this.onEdit(params.row)
                      } else {
                        this.onEdit2(params.row)
                      }
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
      selected: []
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
      // console.log('EditData', data)
      this.$refs.relation.setData(data, index)
    },
    back () {
      if (!this.selected.length) {
        return this.$Message.error('请选择要操作的项次')
      }

      let post = this.selected.map(el => el.id)

      this.$Modal.confirm({
        title: '提示',
        content: '确认退回上一站？',
        loading: true,
        onOk: () => {
          confirmBack({
            post
          }).then(({data}) => {
            this.$Notice.success({
              title: '上一站',
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
    next () {
      if (!this.selected.length) {
        return this.$Message.error('请选择要操作的项次')
      }

      let post = this.selected.map(el => el.id)

      this.$Modal.confirm({
        title: '提示',
        content: '确认送往下一站？',
        loading: true,
        onOk: () => {
          confirmNext({
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
