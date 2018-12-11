export default {
    computed: {
        equipment() {
            return this.$store.getters.machine
        }
    },
    methods: {
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
        equipmentType() {
            return this.equipment.maintenance_times || ''
        },
        //维修次数
        maintenanceTimes() {
            return this.equipment.maintenance_times || ''
        }
    }
}
