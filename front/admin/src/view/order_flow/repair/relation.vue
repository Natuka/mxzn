<template>
  <div>
    <Tabs :animated="false">
      <TabPane label="处理过程">
        <mx-order-attendance></mx-order-attendance>
      </TabPane>
      <TabPane label="服务项目">
        <mx-order-service></mx-order-service>
      </TabPane>
      <TabPane label="配件耗材">
        <mx-order-parts></mx-order-parts>
      </TabPane>
      <TabPane label="催单记录">
        <mx-order-repairs></mx-order-repairs>
      </TabPane>
      <TabPane label="签到记录">
        <mx-order-attendance></mx-order-attendance>
      </TabPane>
      <TabPane label="客户确认">
        <mx-order-confirm></mx-order-confirm>
      </TabPane>
      <TabPane label="附件">
        <mx-order-doc></mx-order-doc>
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
    }
  },
  methods: {
  }
}
</script>

<style>
</style>
