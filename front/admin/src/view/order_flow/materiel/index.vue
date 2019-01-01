<template>
  <div>
    <Card>
      <div slot="title" v-show="showBtn">
        <Button type="primary" @click="onAdd">新增
          <Icon type="md-add"/>
        </Button>
        <Button type="primary" @click="refresh" class="ml-5">刷新
          <Icon type="md-refresh"/>
        </Button>
      </div>
      <tables
        ref="tables"
        :loading="loading"
        editable
        v-model="list"
        :columns="columns"
        @on-delete="handleDelete"
        @on-row-click="onRowClick"
        :width="935"
      />
      <br>
      <Page :current="page" :total="total" show-elevator @on-change="toPage"/>
    </Card>
    <materiel-add ref="add" @refresh="refresh"></materiel-add>
    <materiel-edit ref="edit" @refresh="refreshWithPage"></materiel-edit>
  </div>
</template>

<script>
import dayjs from "dayjs";

import Tables from "_c/tables";

import add from "./add";
import edit from "./edit";

import listMixin from "@/mixins/list";
import constsMixin from "@/mixins/consts";
import baseMixin from "@/mixins/base";

export default {
  name: "mx-order-materiel",
  components: {
    Tables,
    [add.name]: add,
    [edit.name]: edit
  },
  mixins: [listMixin, constsMixin, baseMixin],
  props: {
    quotation_id: {
      type: [Number, String],
      default: 0
    }
  },
  watch: {
    quotation_id(value, old) {
      console.log("quotation_id3434", value, old);
      this.showBtn = value > 0;
      if (value > 0) {
        this.setUrl(value)
      }
    }
  },
  data() {
    return {
      data: {
        id: 0,
      },
      url: "customerquotation/materiel",
      access: {
        add: "customerquotation_materiel_add",
        view: "customerquotation_materiel_view",
        edit: "customerquotation_materiel_edit",
        remove: "customerquotation_materiel_remove"
      },
      showBtn: false,
      columns: [
        {
          width: 120,
          // fixed: 'left',
          title: "料号",
          key: "number",
          sortable: true
        },
        {
          width: 120,
          title: "名称",
          key: "name",
          sortable: true
        },
        {
          width: 120,
          title: "型号规格",
          key: "model",
          sortable: false
        },
        {
          width: 80,
          title: "单位",
          key: "unit",
          sortable: false
        },
        {
          width: 60,
          title: "数量",
          key: "quantity",
          sortable: false
        },
        {
          width: 80,
          title: "单价",
          key: "price",
          sortable: false
        },
        {
          width: 100,
          title: "小计",
          key: "amount",
          sortable: false
        },
        {
          width: 60,
          title: "折扣",
          key: "discount",
          sortable: false
        },
        {
          width: 100,
          title: "折扣后金额",
          key: "discount_amount",
          sortable: false
        },
        {
          width: 60,
          title: "税率",
          key: "tax_rate",
          sortable: false
        },
        {
          width: 100,
          title: "交货日期",
          key: "delivery_date",
          sortable: false
        },
        // {
        //   width: 100,
        //   title: "备注",
        //   key: "remark",
        //   sortable: false
        // },
        {
          fixed: "right",
          width: 180,
          title: "操作",
          key: "handle",
          options: ["delete"],
          button: [
            (h, params, vm) => {
              return h(
                "Poptip",
                {
                  props: {
                    confirm: true,
                    title: "你确定要删除吗?"
                  },
                  on: {
                    "on-ok": () => {
                      vm.$emit("on-delete", params);
                      vm.$emit(
                        "input",
                        params.tableData.filter(
                          (item, index) => index !== params.row.initRowIndex
                        )
                      );
                    }
                  }
                }
              );
            },
            (h, params, vm) => {
              if (!this.accessView()) {
                return;
              }
              return h(
                "Button",
                {
                  props: {
                    type: "primary"
                  },
                  style: {
                    marginLeft: ".6rem"
                  },
                  on: {
                    click: () => {
                      this.onEdit(params.row);
                    }
                  }
                },
                "修改"
              );
            }
          ]
        }
      ],
      tableData: []
    };
  },
  methods: {
    handleDelete(params) {
      console.log(params);
    },
    exportExcel() {
      this.$refs.tables.exportCsv({
        filename: `table-${new Date().valueOf()}.csv`
      });
    },
    onOpen() {
      this.$refs.add.open();
      console.log("quotation_id34563", this.quotation_id);
    },
    onSubmit(e) {
      console.log("onsubmit", e);
      setTimeout(_ => e(), 2000);
    },
    onCancel(e) {
      console.log("oncancel", e);
      e();
    },
    onRowClick(data, index) {
      console.log("data", data, index);
    },
    setUrl(quotation_id) {
      // console.log("quotation_id76867", quotation_id, this.url);
      this.data.id = quotation_id
      this.url = `customerquotation/`+ quotation_id + `/materiel`;
      this.refresh()
    },
    onAddSetData() {
      // console.log('data678454', this.data)
      this.$refs.add.setDataBefore(this.data);
    },
    onEditSetData() {
      this.$refs.edit.setDataBefore(this.data);
    }
  },
  mounted() {
    // this.refresh()
  }
};
</script>

<style scoped>
</style>
