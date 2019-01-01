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
        :width="1135"
      />
      <br>
      <Page :current="page" :total="total" show-elevator @on-change="toPage"/>
    </Card>
    <equipments-add ref="add" @refresh="refresh"></equipments-add>
    <equipments-edit ref="edit" @refresh="refreshWithPage"></equipments-edit>
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
  name: "mx-order-equipments",
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
      url: "order_flow/equipments",
      access: {
        add: "order_flow_equipments_add",
        view: "order_flow_equipments_view",
        edit: "order_flow_equipments_edit",
        remove: "order_flow_equipments_remove"
      },
      showBtn: false,
      columns: [
        {
          width: 120,
          // fixed: 'left',
          title: "安装日期",
          key: "installation_date",
          sortable: true
        },
        {
          width: 120,
          title: "保修日期",
          key: "warranty_date",
          sortable: true
        },
        {
          width: 120,
          title: "备注",
          key: "remark",
          sortable: false
        },
        {
          width: 80,
          title: "类别",
          key: "unit",
          sortable: false
        },
        {
          width: 100,
          title: "设备编号",
          key: "quantity",
          sortable: false
        },
        {
          width: 100,
          title: "设备名称",
          key: "price",
          sortable: false
        },
        {
          width: 100,
          title: "型号规格",
          key: "amount",
          sortable: false
        },
        {
          width: 100,
          title: "本体编号",
          key: "discount",
          sortable: false
        },
        {
          width: 100,
          title: "本体型号",
          key: "discount_amount",
          sortable: false
        },
        {
          width: 120,
          title: "控制箱编号",
          key: "tax_rate",
          sortable: false
        },
        {
          width: 120,
          title: "控制箱型号",
          key: "delivery_date",
          sortable: false
        },
        {
          width: 60,
          title: "焊机编号",
          key: "tax_rate",
          sortable: false
        },
        {
          width: 100,
          title: "焊机型号",
          key: "delivery_date",
          sortable: false
        },
        {
          width: 100,
          title: "1轴编号",
          key: "delivery_date",
          sortable: false
        },
        {
          width: 100,
          title: "2轴编号",
          key: "delivery_date",
          sortable: false
        },
        {
          width: 100,
          title: "3轴编号",
          key: "delivery_date",
          sortable: false
        },
        {
          width: 100,
          title: "4轴编号",
          key: "delivery_date",
          sortable: false
        },
        {
          width: 100,
          title: "5轴编号",
          key: "delivery_date",
          sortable: false
        },
        {
          width: 100,
          title: "6轴编号",
          key: "delivery_date",
          sortable: false
        },
        {
          width: 100,
          title: "中文编码",
          key: "delivery_date",
          sortable: false
        },
        {
          width: 100,
          title: "识别码",
          key: "delivery_date",
          sortable: false
        },
        {
          width: 100,
          title: "制造日期",
          key: "delivery_date",
          sortable: false
        },
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
      this.url = `customerquotation/`+ quotation_id + `/equipments`;
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
