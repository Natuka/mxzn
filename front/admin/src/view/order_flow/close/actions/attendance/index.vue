<template>
  <div>
    <Card>
      <div slot="title">
        <Button
          type="primary"
          @click="refresh"
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
    <attendance-edit ref="edit" @refresh="refreshWithPage"></attendance-edit>

  </div>
</template>

<script>
  import dayjs from 'dayjs'

  import Tables from '_c/tables'

  import search from './search'
  import edit from './edit'

  import listMixin from '@/mixins/list'
  import constsMixin from '@/mixins/consts'
  import baseMixin from '@/mixins/base'
  import * as orderConst from '@/constants/order_flow'

  export default {
    name: 'mx-order-attendance',
    components: {
      Tables,
      [search.name]: search,
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
        url: 'order_flow/close/attendance',
        access: {
          add: 'order_flow_close_add',
          view: 'order_flow_close_view',
          edit: 'order_flow_close_edit',
          remove: 'order_flow_close_remove'
        },
        columns: [
          {
            width: 120,
            fixed: 'left',
            title: '姓名',
            key: 'staff_name',
            sortable: false
          },
          {
            width: 160,
            title: '时间',
            key: 'signin_time',
            sortable: true
          },
          {
            width: 120,
            title: '位置',
            key: 'location',
            sortable: true
          },
          {
            width: 120,
            title: '坐标',
            key: 'coordinate',
            sortable: true
          },
          {
            width: 120,
            title: '备注',
            key: 'remark',
            sortable: false
          },
          {
            width: 120,
            title: '确认人员',
            key: 'confirm_user_name',
            sortable: true
          },
          {
            width: 150,
            title: '建档时间',
            key: 'created_at',
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
                      attendance: true,
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
          },
          {
            title: ' ',
            key: ''
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
        this.url = `order_flow/close/${data.id}/attendance`
      },
      onAddSetData () {
        // console.log('data', this.data)
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
