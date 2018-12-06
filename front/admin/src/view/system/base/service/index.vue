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
          <Icon type="md-refresh"/>
        </Button>
      </div>
      <service-search ref="search" @on-search="onSearch"></service-search>
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
    <service-add ref="add" @refresh="refresh"></service-add>
    <service-edit ref="edit" @refresh="refreshWithPage"></service-edit>
  </div>
</template>

<script>
import Tables from '_c/tables'

import search from './search'
import add from './add'
import edit from './edit'

import listMixin from '../../../../mixins/list'
import constsMixin from '../../../../mixins/consts'
import baseMixin from '../../../../mixins/base'
import * as serviceConst from '../../../../constants/service'

export default {
  name: 'tables_page',
  components: {
    Tables,
    [search.name]: search,
    [add.name]: add,
    [edit.name]: edit
  },
  mixins: [listMixin, constsMixin, baseMixin],
  data () {
    return {
      url: 'service',
      access: {
        add: 'base_service_add',
        view: 'base_service_view',
        edit: 'base_service_edit',
        remove: 'base_service_remove'
      },
      columns: [
        {
          width: 130,
          title: '编号',
          key: 'number',
          sortable: false
        },
        {
          width: 140,
          title: '服务名称',
          key: 'name',
          editable: false,
          sortable: false
        },
        {
          width: 200,
          title: '服务内容',
          key: 'content',
          editable: false,
          sortable: false
        },
        {
          width: 100,
          title: '服务时间',
          key: 'workday'
        },
        {
          width: 100,
          title: '地区',
          key: 'area',
          render: this.constRender('area', serviceConst.SERVICE_AREA)
        },
        {
          width: 100,
          title: '单价',
          key: 'price'
        },
        {
          width: 100,
          title: '单位',
          key: 'unit',
          editable: false,
          sortable: false
        },
        {
          width: 110,
          title: '含陆路交通费',
          key: 'is_land_traffic',
          render: this.constRender('is_land_traffic', serviceConst.SERVICE_LAND_TRAFFIC)
        },
        {
          width: 100,
          title: '含住宿',
          key: 'is_hotel',
          render: this.constRender('is_hotel', serviceConst.SERVICE_HOTEL)
        },
        {
          width: 100,
          title: '备注',
          key: 'remark',
          sortable: false
        },
        {
          width: 100,
          title: '建立人员',
          key: 'created_by'
        },
        {
          width: 150,
          title: '建立日期',
          key: 'created_at',
          sortable: false
        },
        {
          title: ' ',
          key: ''
        },
        {
          width: 180,
          fixed: 'right',
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
                      this.onDelete(params.row)
                    }
                  }
                }
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
    }
  },
  mounted () {
    this.refresh()
  }
}
</script>
<style>
</style>
