<template>
  <div>
    <Card>
      <div slot="title">
        <Button type="primary" @click="onAdd" v-if="accessAdd()">
          新增
          <Icon type="md-add"/>
        </Button>

        <Button type="primary" @click="refresh" v-if="accessAdd()" class="ml-5">
          刷新
          <Icon type="md-add"/>
        </Button>
      </div>
      <agent-search ref="search" @on-search="onSearch"></agent-search>
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
      <!--<Button style="margin: 10px 0;" type="primary" @click="exportExcel">导出为Csv文件</Button>-->
    </Card>
    <customer-add ref="add" @refresh="refresh"></customer-add>
    <customer-edit ref="edit" @refresh="refreshWithPage"></customer-edit>
  </div>
</template>

<script>
import Tables from '_c/tables'

import search from './search'
import add from './add'
import edit from './edit'

import * as customerConst from '../../constants/customer'

import listMixin from '../../mixins/list'
import constsMixin from '../../mixins/consts'

export default {
  name: 'tables_page',
  components: {
    Tables,
    [search.name]: search,
    [add.name]: add,
    [edit.name]: edit
  },
  mixins: [listMixin, constsMixin],
  data () {
    return {
      url: 'customer',
      access: {
        add: 'customer_add',
        view: 'customer_view',
        edit: 'customer_edit',
        remove: 'customer_remove'
      },
      columns: [
        {
          fixed: 'left',
          width: 120,
          title: '客户类别',
          key: 'type',
          sortable: false,
          render: this.constRender('type', customerConst.TYPE_LIST)
        },
        {
          width: 120,
          title: '所属行业',
          key: 'industry',
          sortable: true,
          render: this.constRender('industry', customerConst.INDUSTRY_LIST)
        },
        {
          width: 120,
          title: '客户级别',
          key: 'level',
          sortable: true,
          render: this.constRender('level', customerConst.LEVEL_LIST)
        },
        {
          width: 120,
          title: '客户编号',
          key: 'number',
          sortable: true
        },
        {
          width: 150,
          title: '公司名称',
          key: 'name',
          sortable: true
        },
        {
          width: 120,
          title: '客户来源',
          key: 'source',
          sortable: true,
          render: this.constRender('source', customerConst.SOURCE_LIST)
        },
        {
          width: 160,
          title: '跟进状态',
          key: 'follow_up_status',
          sortable: true,
          render: this.constRender('follow_up_status', customerConst.FOLLOW_UP_STATUS_LIST)
        },
        {
          width: 120,
          title: '人员规模',
          key: 'staff_scale',
          sortable: true,
          render: this.constRender('staff_scale', customerConst.STAFF_SCALE_LIST)
        },
        {
          width: 120,
          title: '购买力',
          key: 'purchasing_power',
          sortable: true,
          render: this.constRender('purchasing_power', customerConst.PURCHASING_POWER_LIST)
        },
        {
          width: 150,
          title: '所在地址',
          key: 'address',
          // sortable: true
        },
        {
          width: 120,
          title: '所属业务员',
          key: 'salesman_id',
          sortable: false
        },
        {
          width: 160,
          title: '最近联系时间',
          key: 'contact_lasttime',
          sortable: false
        },
        {
          width: 120,
          title: '下次跟进时间',
          key: 'follow_up_nexttime',
          sortable: false
        },
        {
          width: 120,
          title: '是否黑名单',
          key: 'blacklist',
          // sortable: true,
          render: this.constRender('blacklist', customerConst.BLACK_LIST)
        },
        {
          width: 120,
          title: 'Handle',
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
                [h('Button', '自定义删除')]
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
                      this.onEdit()
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
    }
  },
  mounted () {
    this.refresh()
  }
}
</script>

<style>
</style>
