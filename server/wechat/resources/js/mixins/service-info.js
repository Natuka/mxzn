import {ORDER_STATUS} from "../const/repair";

// 制单中 0, 已受理 1,待派单 2,处理中 3,已取消 4,已关闭 5,无法处理 6

import dayjs from 'dayjs'

export default {
    methods: {
        getServiceStatus(info) {
            switch (info.status) {
                case 0:
                    return ''
                case 1:
                    return '正在派单中'
                case 2:
                    return '已受理'
                case 3:
                    let fromAt = dayjs(info.receive_at)

                    let diffDay = dayjs().diff(fromAt, 'days')
                    let today = dayjs(dayjs().format('YYYY-MM-DD 00:00:00'))
                    let diffHour = dayjs().diff(today, 'hours')

                    if (!diffDay) {
                        return `已处理${diffHour}小时`
                    }

                    return `已处理${diffDay}天${diffHour}小时`
                case 4:
                    return '已取消'
                case 5:
                    return '已关闭'
                case 6:
                default:

            }
            return ''
        },
        getServiceTitle(info) {
            let text = ORDER_STATUS[info.status]
            return `【${text}】单号：${info.number}`
        },
        getServiceAddr (info) {
            return 'wwww'
        },
        getServiceArea () {
            return 'aaaa'
        },
        getServiceEquipmentName (info) {
            return ''
        },
        getServiceEquipmentSerializeNo (info) {
            return '2222'
        },
        getServiceFaultDesc (info) {
            return ''
        },
        getServiceEngineer (info) {
            return '小于'
        },
        getServicePlanOoutAt (info) {
            return 0
        },
        getServicePartFee (info) {
            return 0
        },
        getServiceFee (info) {
            return 0
        },
        getServiceExtraFee (info) {
            return 0
        },
        getServiceFeeTotal (info) {
            return 0
        },
    }
}
