<template>
  <div>
    <Card>
      <div slot="title">
        <Button type="primary" @click="onAdd" v-if="accessAdd()">
          新增
          <Icon type="md-add"/>
        </Button>
        <Button type="primary" @click="refresh" class="ml-5">
          刷新
          <Icon type="md-refresh"/>
        </Button>
      </div>
      <knowledge-search ref="search" @on-search="onSearch"></knowledge-search>
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
    <knowledge-add ref="add" @refresh="refresh"></knowledge-add>
    <knowledge-edit ref="edit" @refresh="refreshWithPage"></knowledge-edit>
  </div>
</template>

<script>
import Tables from '_c/tables'

import search from './search'
import add from './add'
import edit from './edit'

import * as knowledgeConst from '../../constants/knowledge'

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
      url: 'knowledge',
      access: {
        add: 'knowledge_add',
        view: 'knowledge_view',
        edit: 'knowledge_edit',
        remove: 'knowledge_remove'
      },
      columns: [
        {
          width: 120,
          title: '类别',
          key: 'type',
          sortable: true,
          render: this.constRender('type', knowledgeConst.TYPE_LIST)
        },
        {
          width: 180,
          title: '子类别',
          key: 'type1',
          sortable: true,
          render: this.constRender('type1', knowledgeConst.TYPE1_LIST)
        },
        {
          width: 300,
          title: '主题',
          key: 'subject_name',
          sortable: false
        },
        {
          width: 100,
          title: '下载量',
          key: 'downloads',
          sortable: true
        },
        {
          width: 260,
          title: '附件',
          key: 'attach_file',
          sortable: false
        },
        {
          width: 180,
          title: '备注',
          key: 'remark',
          sortable: false
        },
        // {
        //   width: 200,
        //   title: '主要内容',
        //   key: 'text',
        //   sortable: false
        // },
        {
          width: 100,
          title: '建立人员',
          key: 'created_by'
        },
        {
          width: 100,
          title: '修改人员',
          key: 'updated_by'
        },
        {
          title: ' ',
          key: ''
        },
        {
          fixed: 'right',
          width: 160,
          title: '操作',
          key: 'handle',
          options: ['delete'],
          button: [
            (h, params, vm) => {
              let buttonTile = '查看'
              if (!this.accessView()) {
                return
              } else {
                if (this.accessEdit()) {
                  buttonTile = '修改'
                }
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
                buttonTile
              )
            },
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
