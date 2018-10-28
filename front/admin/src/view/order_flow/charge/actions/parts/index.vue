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
    <parts-add ref="add" @refresh="refresh"></parts-add>
    <parts-edit ref="edit" @refresh="refreshWithPage"></parts-edit>

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
    name: 'mx-order-parts',
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
        url: 'order_flow/charge/parts',
        access: {
          add: 'order_flow_charge_add',
          view: 'order_flow_charge_view',
          edit: 'order_flow_charge_edit',
          remove: 'order_flow_charge_remove'
        },
        columns: [
          {
            width: 120,
            fixed: 'left',
            title: '操作时间',
            key: 'created_at',
            sortable: false
          },
          {
            width: 120,
            // fixed: 'left',
            title: '料号',
            key: 'number',
            sortable: true
          },
          {
            width: 120,
            title: '名称',
            key: 'name',
            sortable: true
          },
          {
            width: 120,
            title: '型号规格',
            key: 'model',
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
            sortable: true
          },
          {
            width: 120,
            title: '单价',
            key: 'price',
            sortable: false
          },
          {
            width: 120,
            title: '小计',
            key: 'amount',
            sortable: false
          },
          {
            width: 120,
            title: '折扣',
            key: 'discount',
            sortable: false
          },
          {
            width: 160,
            title: '折扣后金额',
            key: 'amount_dis',
            sortable: false
          },
          {
            width: 160,
            title: '保修日期',
            key: 'warranty_date',
            sortable: false
          },
          {
            width: 160,
            title: '备注',
            key: 'remark',
            sortable: false
          },
          {
            width: 160,
            title: '建档人员',
            key: 'created_by',
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
        this.url = `order_flow/charge/${data.id}/parts`
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
