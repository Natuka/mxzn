<template>
  <div>
    <Card>
      <div slot="title">
        <!--<Button type="primary" @click="onAdd" v-if="accessAdd()">
          新增
          <Icon type="md-add"/>
        </Button>-->
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
    <confirm-add ref="add" @refresh="refresh"></confirm-add>
    <confirm-edit ref="edit" @refresh="refreshWithPage"></confirm-edit>

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
    name: 'mx-order-confirm',
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
        url: 'order_flow/maintain/confirm',
        access: {
          add: 'order_flow_maintain_add',
          view: 'order_flow_maintain_view',
          edit: 'order_flow_maintain_edit',
          remove: 'order_flow_maintain_remove'
        },
        columns: [
          {
            width: 110,
            fixed: 'left',
            title: '是否解决',
            key: 'is_solve',
            sortable: true,
            render: this.constRender('is_solve', orderConst.SERVICE_COMPLETE)
          },
          {
            width: 180,
            title: '整体满意度',
            key: 'overall_satisfaction',
            sortable: true,
            render: (h, params) => {
              let rateNums = params.row.overall_satisfaction
              return h('Rate', {
                props: {
                  disabled: true,
                  value: rateNums
                }
              })
            }
          },
          {
            width: 180,
            title: '服务及时性',
            key: 'timeliness',
            sortable: true,
            render: (h, params) => {
              let rateNums = params.row.timeliness
              return h('Rate', {
                props: {
                  disabled: true,
                  value: rateNums
                }
              })
            }
          },
          {
            width: 180,
            title: '服务人员满意度',
            key: 'service_staff_atisfaction',
            sortable: true,
            render: (h, params) => {
              let rateNums = params.row.service_staff_atisfaction
              return h('Rate', {
                props: {
                  disabled: true,
                  value: rateNums
                }
              })
            }
          },
          {
            width: 180,
            title: '性价比满意度',
            key: 'cost_performance',
            sortable: true,
            render: (h, params) => {
              let rateNums = params.row.cost_performance
              return h('Rate', {
                props: {
                  disabled: true,
                  value: rateNums
                }
              })
            }
          },
          {
            width: 160,
            title: '建议与意见',
            key: 'opinions_suggestions',
            sortable: false
          },
          {
            width: 120,
            title: '确认人员',
            key: 'confirm_user_name',
            sortable: true
          },
          {
            width: 160,
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
        this.url = `order_flow/maintain/${data.id}/confirm`
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
