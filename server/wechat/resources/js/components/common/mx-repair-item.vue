<template>
  <van-pull-refresh v-model="isLoading" @refresh="onRefresh">
    <van-list v-model="loading" :finished="finished" @load="onLoad">
      <van-panel :key="key" v-for="(item, key) in data" :title="getServiceTitle(item)">
        <div slot="header" class="pt-20 pr-20 pl-20 mx-flex">
          <van-row type="flex" justify="space-between">
            <span class="mx-flex-1">{{getCreatedDate(item)}}</span>
            <!-- <span class="mx-text-danger">{{getServiceStatus(item)}}</span> -->
          </van-row>
        </div>

        <!-- <div slot="header" class="pt-20 pr-20 pl-20 mx-flex">
          <van-row type="flex" justify="space-between">
            <span class="mx-flex-1">{{getServiceTitle(item)}}</span>
            <span class="mx-text-danger">{{getServiceStatus(item)}}</span>
          </van-row>
        </div>-->
        <div class="p-20">
          <van-row type="flex" justify="space-between">
            <van-col :span="24">
              <span class="mx-label">反馈单号</span>
              {{item.number}}
            </van-col>
          </van-row>
          <van-row type="flex" justify="space-between">
            <van-col :span="24">
              <span class="mx-label">单据状态</span>
              {{getServiceStatus(item)}}
            </van-col>
          </van-row>
          <van-row type="flex" justify="space-between">
            <van-col :span="24">
              <span class="mx-label">客户</span>
              {{getCustomerName(item)}}
            </van-col>
          </van-row>
          <van-row type="flex" justify="space-between">
            <van-col :span="24">
              <span class="mx-label">反馈人员</span>
              {{getFeedbackInfoString(item)}}
            </van-col>
          </van-row>
          <van-row type="flex" justify="space-between">
            <van-col :span="24">
              <span class="mx-label">设备</span>
              {{getServiceEquipmentName(item)}}
            </van-col>
          </van-row>

          <van-row type="flex" justify="space-between">
            <van-col :span="24">
              <span class="mx-label">故障</span>
              <span>{{getServiceFaultDesc(item)}}</span>
            </van-col>
          </van-row>

          <!-- <van-row type="flex" justify="space-between">
            <van-col :span="24">
              <span class="mx-label">报修</span>
            </van-col>
          </van-row>

          <van-row type="flex" justify="space-between">
            <van-col :span="12">
              <span class="mx-label">地址</span>
              <span>{{getServiceAddr(item)}}</span>
            </van-col>
            <van-col :span="12">
              <span class="mx-label">区域</span>
              <span>{{getServiceArea(item)}}</span>
            </van-col>
          </van-row>

          <van-row type="flex" justify="space-between">
            <van-col :span="12">
              <span class="mx-label">机器</span>
              <span>{{getServiceEquipmentName(item)}}</span>
            </van-col>
            <van-col :span="12">
              <span class="mx-label">序列号</span>
              {{getServiceEquipmentSerializeNo(item)}}
            </van-col>
          </van-row>

          <van-row type="flex" justify="space-between">
            <van-col :span="24">
              <span class="mx-label">故障</span>
              <span>{{getServiceFaultDesc(item)}}</span>
            </van-col>
          </van-row>

          <van-row type="flex" justify="space-between">
            <van-col :span="12">
              <span class="mx-label">技术员</span>
              <span>{{getServiceEngineer(item)}}</span>
            </van-col>
            <van-col :span="12">
              <span class="mx-label">预约时间</span>
              <span>{{getServicePlanOoutAt(item)}}</span>
            </van-col>
          </van-row>-->
          <van-row type="flex" justify="space-between">
            <van-col :span="6">
              <span class="mx-label">配件费</span>
              <span class="mx-text-danger">{{getServicePartFee(item)}}</span>
            </van-col>
            <van-col :span="6">
              <span class="mx-label">服务费</span>
              <span class="mx-text-danger">{{getServiceFee(item)}}</span>
            </van-col>
            <van-col :span="6">
              <span class="mx-label">附加费</span>
              <span class="mx-text-danger">{{getServiceExtraFee(item)}}</span>
            </van-col>
            <van-col :span="6">
              <span class="mx-label">合计</span>
              <span class="mx-text-danger">{{getServiceFeeTotal(item)}}</span>
            </van-col>
          </van-row>
        </div>
        <div slot="footer" class="text-right">
          <van-button size="small" @click="onAttendance(item)">签到</van-button>
          <van-button size="small" @click="onAction(item)">处理</van-button>
          <!--<van-button size="small" @click="onDocument(item)">附件</van-button>-->
          <van-button size="small" type="danger" @click="onClick(item)">更多</van-button>
        </div>
      </van-panel>
    </van-list>
  </van-pull-refresh>
</template>

<script>
// import { list } from "../../const/repair";

import Action from "../actions";
import actionMixin from "../../mixins/action";
import infoMixin from "../../mixins/service-info";

import { repairList } from "../../api";
import { Toast } from "vant";

export default {
  name: "mx-repair-item",
  components: {
    [Action.name]: Action
  },
  mixins: [actionMixin, infoMixin],
  props: {
    type: {
      type: [Number, String],
      default: 0
    }
  },
  data() {
    return {
      active: 2,
      data: [],
      item: {},
      loading: false,
      finished: false,
      // menus: list,
      isLoading: false,
      value: "",
      page: 1,
      isRefresh: false
    };
  },
  methods: {
    async onRefresh() {
      this.isRefresh = true;
      await this.loadData();
      await this.onLoad();
    },

    async setOrderInfo(info) {
      this.$store.dispatch("setServiceOrder", info);
      this.$router.push("/repair/info");
    },

    async loadData() {
      let dataWrap = this.data;
      if (this.isRefresh) {
        this.loading = true;
        this.finished = false;
        this.page = 1;
      } else {
        this.finished = false;
      }

      try {
        let { data, current_page, last_page, per_page } = await repairList({
          page: this.page,
          type: this.type
        });
        if (this.isRefresh) {
          this.data = [];
        }

        this.page++;
        this.data.push(...data);
        if (!data.length || data.length < per_page) {
          this.finished = true;
          this.isLoading = false;
        }
      } catch (e) {
      } finally {
        this.loading = false;
        this.isLoading = false;
      }
    },

    async onLoad() {
      this.isRefresh = false;
      await this.loadData();
    },
    onSearch() {},
    onClick(item) {
      this.item = item;
      // this.$refs["action"].open();
    }
  }
};
</script>
