<template>
    <div>
        <van-nav-bar
            fixed
            title="工单"
            left-text="返回"
            right-text="提报"
            left-arrow
            @click-left="onClickLeft"
            @click-right="onClickRight"
        />
        <van-search
            v-model="value"
            placeholder="请输入搜索关键词"
            show-action
            @search="onSearch"
        >
            <div slot="action" @click="onSearch">搜索</div>
        </van-search>
        <van-tabs v-model="active">
            <van-tab v-for="menu in menus" :title="menu.name" :key="menu.type">
                <van-pull-refresh v-model="isLoading" @refresh="onRefresh">
                    <van-list
                        v-model="menu.loading"
                        :finished="menu.finished"
                        @load="onLoad"
                    >
                        <van-panel
                            :key="key"
                            v-for="(item, key) in menu.data"
                            :title="getServiceTitle(item)"
                            :status="getServiceStatus(item)">

                            <div slot="header" class="pt-20 pr-20 pl-20 mx-flex">
                                <van-row type="flex" justify="space-between">
                                    <span class="mx-flex-1">{{getServiceTitle(item)}}</span>
                                    <span class="mx-text-danger">{{getServiceStatus(item)}}</span>
                                </van-row>
                            </div>

                            <div class="p-20">
                                <van-row type="flex" justify="space-between">
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
                                </van-row>
                                <van-row type="flex" justify="space-between">
                                    <van-col :span="6">
                                        <span class="mx-label">配件费</span>
                                        <span class="mx-text-danger">
                                            {{getServicePartFee(item)}}
                                        </span>
                                    </van-col>
                                    <van-col :span="6">
                                        <span class="mx-label">服务费</span>
                                        <span class="mx-text-danger">
                                            {{getServiceFee(item)}}
                                        </span>
                                    </van-col>
                                    <van-col :span="6">

                                        <span class="mx-label">附加费</span>
                                        <span class="mx-text-danger">
                                            {{getServiceExtraFee(item)}}
                                        </span>
                                    </van-col>
                                    <van-col :span="6">
                                        <span class="mx-label">合计</span>
                                        <span class="mx-text-danger">
                                            {{getServiceFeeTotal(item)}}
                                        </span>
                                    </van-col>

                                </van-row>

                            </div>
                            <div slot="footer" class="text-right">
                                <van-button size="small" @click="onAttendance(item)">签到</van-button>
                                <van-button size="small" @click="onAction(item)">处理</van-button>
                                <van-button size="small" @click="onDocument(item)">附件</van-button>
                                <van-button size="small" type="danger"
                                    @click="onClick(item)"
                                >更多</van-button>
                            </div>
                        </van-panel>
                    </van-list>
                </van-pull-refresh>
            </van-tab>
        </van-tabs>

        <mx-actions ref="action" :data="data" :from="$route.fullPath"></mx-actions>

    </div>
</template>

<script>
import { list } from '../../const/repair'

import Action from '../actions'
import actionMixin from '../../mixins/action'
import infoMixin from '../../mixins/service-info'

import { repairList } from '../../api'
import { Toast } from 'vant'

export default {
  name: 'mx-repair-list',
  components: {
    [Action.name]: Action
  },
  mixins: [actionMixin, infoMixin],
  data() {
    return {
      active: 2,
      list: [],
      loading: false,
      finished: false,
      menus: list,
      isLoading: false,
      value: '',
      data: {},
      page: 1,
      isRefresh: false
    }
  },
  methods: {
    onClickLeft() {
      this.$toast('返回')
    },
    onClickRight() {
      this.$router.push('/repair/create')
      //   this.$toast('按钮')
    },
    async onRefresh() {
      this.isRefresh = true
      await this.loadData()
      await this.onLoad()
    },

    async setOrderInfo(info) {
      this.$store.dispatch('setServiceOrder', info)
      this.$router.push('/repair/info')
    },

    async loadData() {
      let dataWrap = this.menus[this.active]
      if (this.isRefresh) {
        dataWrap.loading = true
        dataWrap.finished = false
        dataWrap.page = 1
      } else {
        dataWrap.finished = false
      }

      try {
        let { data, current_page, last_page, per_page } = await repairList({
          page: dataWrap.page,
          type: dataWrap.type
        })
        if (this.isRefresh) {
          dataWrap.data = []
        }

        dataWrap.page++
        dataWrap.data.push(...data)
        if (!data.length || data.length < per_page) {
          dataWrap.finished = true
        }
      } catch (e) {
      } finally {
        this.loading = false
      }
    },

    async onLoad() {
      this.isRefresh = false
      await this.loadData()
    },
    onSearch() {},
    onClick(item) {
      this.data = item
      this.$refs['action'].open()
    }
  }
}
</script>

<style scoped>
.text-right {
  text-align: right;
}
</style>
