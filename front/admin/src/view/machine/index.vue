<template>
  <div>
    <Card>
      <div slot="title">
        <Button type="primary" @click="onAdd" v-if="accessAdd()">
          新增
          <Icon type="md-add"/>
        </Button>

        <Button type="primary" @click="onImport" v-if="accessAdd()" class="ml-5">
          导入
          <Icon type="md-add"/>
        </Button>

        <Button type="primary" @click="refresh" v-if="accessAdd()" class="ml-5">
          刷新
          <Icon type="md-refresh"/>
        </Button>
      </div>
      <machine-search ref="search" @on-search="onSearch"></machine-search>
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
    <machine-add ref="add" @refresh="refresh"></machine-add>
    <machine-edit ref="edit" @refresh="refreshWithPage"></machine-edit>
  </div>
</template>

<script>
import Tables from '_c/tables'

import search from './search'
import add from './add'
import edit from './edit'

import listMixin from '../../mixins/list'
// import constsMixin from '../../mixins/consts'

export default {
  name: 'tables_page',
  components: {
    Tables,
    [search.name]: search,
    [add.name]: add,
    [edit.name]: edit
  },
  mixins: [listMixin],
  data () {
    return {
      url: 'machine',
      access: {
        add: 'machine_add',
        view: 'machine_view',
        edit: 'machine_edit',
        remove: 'machine_remove'
      },
      columns: [
        {
          title: '料号',
          key: 'number',
          sortable: true
        },
        {
          title: '品名',
          key: 'name',
          editable: false,
          sortable: true
        },
        {title: '型号规格', key: 'model', editable: false, sortable: true},
        {title: '品牌', key: 'brand', editable: false, sortable: true},
        {title: '统一销售价', key: 'price_sale_least'},
        {title: '库存数量', key: 'stock_qty'},
        {title: '单位', key: 'unit'},
        {title: '默认仓库', key: 'store', sortable: true},
        {title: '安全库存量', key: 'safety_stock_qty'},
        {title: '供应商', key: 'vendor', sortable: true},
        {
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
                      this.onDelete(params.row)
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
