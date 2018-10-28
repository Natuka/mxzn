<template>
  <div>
    <Tabs @on-click="onClick"
          type="card"
          :animated="false"
          v-model="name"
    >
      <TabPane label="处理过程" name="repairs">
        <mx-order-repairs ref="repairs" :data="data"></mx-order-repairs>
      </TabPane>
      <TabPane label="服务项目" name="service">
        <mx-order-service ref="service" :data="data"></mx-order-service>
      </TabPane>
      <TabPane label="配件耗材" name="parts">
        <mx-order-parts ref="parts" :data="data"></mx-order-parts>
      </TabPane>
      <TabPane label="催单记录" name="followup">
        <mx-order-follow-up ref="followup" :data="data"></mx-order-follow-up>
      </TabPane>
      <TabPane label="签到记录" name="attendance">
        <mx-order-attendance ref="attendance" :data="data"></mx-order-attendance>
      </TabPane>
      <TabPane label="客户确认" name="confirm">
        <mx-order-confirm ref="confirm" :data="data"></mx-order-confirm>
      </TabPane>
      <TabPane label="附件" name="doc">
        <mx-order-doc ref="doc" :data="data"></mx-order-doc>
      </TabPane>
    </Tabs>
  </div>
</template>

<script>
import attendance from './actions/attendance/index'
import confirm from './actions/confirm/index'
import document from './actions/document/index'
import followUp from './actions/follow-up/index'
import parts from './actions/parts/index'
import repairs from './actions/repairs/index'
import service from './actions/service/index'

export default {
  name: 'mx-relation',
  components: {
    [attendance.name]: attendance,
    [confirm.name]: confirm,
    [document.name]: document,
    [followUp.name]: followUp,
    [parts.name]: parts,
    [repairs.name]: repairs,
    [service.name]: service
  },
  data () {
    return {
      name: 'repairs',
      data: {},
      cached: {}
    }
  },
  methods: {
    getRef (name) {
      const map = {
        repairs: 'repairs',
        service: 'service',
        parts: 'parts',
        followup: 'followup',
        attendance: 'attendance',
        confirm: 'confirm',
        doc: 'doc'
      }

      if (map[name]) {
        return this.$refs[map[name]]
      }
      return null
    },
    // 点击切换
    onClick (name) {
      // 如果已经缓存，那么不需要再次进行刷新页面
      if (this.cached[name]) {
        return
      }

      if (!this.data.id) {
        return this.$Message.info('请选择要操作的工单')
      }

      this.cached[name] = true
      let ref = this.getRef(name)
      if (ref) {
        ref.setUrl(this.data)
        ref.refresh()
      }
    },
    // 刷新
    refresh () {
      let ref = this.onClick(this.name)
    },
    // 设置数据
    setData (data, index) {
      this.data = data
      // 清理缓存，重新加载
      this.cached = {}
      this.refresh()
    }
  }
}
</script>

<style>
</style>
