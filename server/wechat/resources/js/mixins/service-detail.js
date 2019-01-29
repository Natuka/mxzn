import {
    ORDER_TYPE,
    ORDER_DEGREE,
    ORDER_LEVEL,
    ORDER_SOURCE,
    FAULT_TYPE,
    SEQUENCE_TYPE,
    LINE_BROKEN,
    PART_BROKEN,
    MACHINE_TYPE,
    TYPE_LIST,
    DFROM_LIST
} from '../const/repair'

export default {
    computed: {
        order() {
            return this.$store.getters.serviceOrder
        },
        fault() {
            return this.$store.getters.fault
        },
        equipment() {
            return this.$store.getters.equipment
        },
        engineers() {
            return this.$store.getters.orderEngineers
        },
        // 服务工程师
        engineerNames() {
            return this.engineers.map(el => el.staff_name).join(', ')
        }
    },
    methods: {
        orderNumber() {
            return this.order.number || ''
        },
        getStatus(info = null) {
            if (!info) {
                info = this.order
            }
            switch (info.status) {
                case 0:
                    return '制单中'
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
        // 受理来源
        getSource() {
            return ORDER_SOURCE[this.order.source] || ''
        },
        processMode() {
            if (+this.order.is_out === 1) {
                return '上门'
            }
            return '电话(远程)'
        },
        getType() {
            return ORDER_TYPE[this.order.type] || ''
        },
        getTypeRepair() {
            return +this.order.type === 3
        },
        getTypeOther() {
            return +this.order.type !== 3
        },
        getTypeTitle1Staff() {
            if (+this.order.type === 3) {
                return '报修人员'
            }
            return '联系人员'
        },
        getTypeTitleTel() {
            if (+this.order.type === 3) {
                return '报修人电话'
            }
            return '联系电话'
        },
        getTypeTitle1Out() {
            if (+this.order.type === 3) {
                return '预计上门时间'
            }
            return '预计开始时间'
        },
        orderRemark() {
            return this.order.remark
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
        // 紧急程度
        orderDegree() {
            return ORDER_DEGREE[this.order.emergency_degree] || ''
        },
        // 服务级别
        orderLevel() {
            return ORDER_LEVEL[this.order.level] || ''
        },
        // 客户名称
        orderCustomer() {
            return (this.order.customer && this.order.customer.name) || ''
        },
        // 保修人员
        orderFeedbackStaff() {
            return (
                (this.order.feedback_staff && this.order.feedback_staff.name) ||
                ''
            )
        },
        // 保修电话
        orderFeedbackTel() {
            return (
                (this.order.feedback_staff &&
                    this.order.feedback_staff.mobile) ||
                ''
            )
        },
        // 联系地址
        orderAddress() {
            return (this.order.customer && this.order.customer.address) || ''
        },
        // 服务工程师
        serviceStaff() {
            return this.engineerNames
            // if (this.order.engineers && this.order.engineers.length) {
            //     return this.order.engineers.map(el => el.name).join(', ')
            // }

            // return ''
        },
        // 故障信息
        faultDesc() {
            return this.fault.desc || ''
        },
        // 故障图片
        faultImage() {
            return ''
            //   return this.
        },
        // 故障类型
        faultType() {
            if (this.fault) {
                return FAULT_TYPE[this.fault.type]
            }
            return ''
        },
        // 故障频率
        faultSequnce() {
            if (this.fault) {
                return SEQUENCE_TYPE[this.fault.sequence]
            }
            return ''
        },
        faultLineBroken() {
            if (this.fault && +this.fault.is_line_broken === 1) {
                return '是'
            }
            return '否'
        },
        faultPartBroken() {
            if (this.fault && +this.fault.is_part_broken === 1) {
                return '是'
            }
            return '否'
        },
        serviceFee() {
            if (+this.order.is_charge === 1) {
                return '是'
            }
            return '否'
        },
        quoteFee() {
            if (+this.order.is_quote === 1) {
                return '是'
            }
            return '否'
        },
        quoteDocs() {
            return ''
        },
        //技术专管
        technologyStaff() {
            return this.equipment.technology_staff || ''
        },
        // 安装人员
        installationStaff() {
            return this.equipment.installation_staff || ''
        },
        //设备编号
        equipmentNumber() {
            return this.equipment.number || ''
        },
        //设备名称
        equipmentName() {
            return this.equipment.name || ''
        },
        // 型号规格
        equipmentModel() {
            return this.equipment.model || ''
        },
        // 合同编号
        contractNumber() {
            return this.equipment.contract_number || ''
        },
        //类别
        equipmentType() {
            return TYPE_LIST[this.equipment.type] || ''
        },
        //安装日期
        installationDate() {
            return this.equipment.installation_date || ''
        },
        //保修日期
        warrantyDate() {
            return this.equipment.warranty_date || ''
        },
        //验收日期
        acceptanceDate() {
            return this.equipment.acceptance_date || ''
        },
        //制造日期
        manufactureDate() {
            return this.equipment.manufacture_date || ''
        },

        //本体编号
        mainNo() {
            return this.equipment.main_no || ''
        },
        //本体型号
        mainModel() {
            return this.equipment.main_model || ''
        },
        //控制箱编号
        controlBoxNo() {
            return this.equipment.control_box_no || ''
        },
        //控制箱型号
        controlBoxModel() {
            return this.equipment.control_box_model || ''
        },
        //焊机编号
        weldingMachineNo() {
            return this.equipment.welding_machine_no || ''
        },
        //焊机型号
        weldingMachineModel() {
            return this.equipment.welding_machine_model || ''
        },
        //1轴编号
        axis1No() {
            return this.equipment.axis1_no || ''
        },
        //2轴编号
        axis2No() {
            return this.equipment.axis2_no || ''
        },
        //3轴编号
        axis3No() {
            return this.equipment.axis3_no || ''
        },
        //4轴编号
        axis4No() {
            return this.equipment.axis4_no || ''
        },
        //5轴编号
        axis5No() {
            return this.equipment.axis5_no || ''
        },
        //6轴编号
        axis6No() {
            return this.equipment.axis6_no || ''
        },
        //中文编码
        codeChinese() {
            return this.equipment.code_chinese || ''
        },
        //序列号
        equipmentSerialNumber() {
            return this.equipment.number || ''
        },
        //维修次数
        maintenanceTimes() {
            return this.equipment.maintenance_times || ''
        }
    }
}
