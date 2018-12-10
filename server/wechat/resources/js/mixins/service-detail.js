import { ORDER_TYPE, ORDER_DEGREE, ORDER_LEVEL } from '../const/repair'
export default {
    computed: {
        order() {
            return this.$store.getters.serviceOrder
        },
        fault() {
            return this.$store.getters.fault
        },
        equipment() {
            return this.$stoer.getters.equipment
        }
    },
    methods: {
        getStatus(info = null) {
            if (!info) {
                info = this.order
            }
            switch (info.status) {
                case 0:
                    return ''
                case 1:
                    return '正在派单中'
                case 2:
                    return '已受理'
                case 3:
                    return '处理中'
                case 4:
                    return '已取消'
                case 5:
                    return '已关闭'
                case 6:
                default:
            }
            return ''
        },
        getType() {
            return ORDER_TYPE[this.order.type] || ''
        },
        // 处理方式
        actionType() {
            if (+this.order.is_out === 1) {
                return '上门'
            }
            return ''
        },
        receiveAt() {
            return this.order.receive_at
        },
        receiveStaff() {
            return (
                (this.order.receive_staff && this.order.receive_staff.name) ||
                ''
            )
        },
        orderDegree() {
            return ORDER_DEGREE[this.order.emergency_degree]
        },
        orderLevel() {
            return ORDER_LEVEL[this.order.level]
        },
        orderCustomer() {
            return (this.order.customer && this.order.customer.name) || ''
        },
        orderFeedbackStaff() {
            return (
                (this.order.feedback_staff && this.order.feedback_staff.name) ||
                ''
            )
        },
        orderFeedbackTel() {
            return ''
        },
        orderAddress() {
            return (this.order.customer && this.order.customer.address) || ''
        },
        // 服务工程师
        serviceStaff() {
            if (this.order.engineers && this.order.engineers.length) {
                return this.order.engineers.map(el => el.name).join(', ')
            }

            return ''
        },
        faultDesc() {
            return this.fault.desc
      },
      faultImage () {
          return this.
        }
    }
}
