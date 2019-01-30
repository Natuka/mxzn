import dayjs from 'dayjs'

const currentDate = dayjs().format('YYYY-MM-DD HH:mm:ss')

export default {
    attach_ids: '',
    customer_id: 0,
    feedback_staff_id: 0,
    receive_staff_id: 0,
    confirm_staff_id: 0,
    emergency_degree: 0,
    number: '',
    mobile: '',
    feedback_at: '',
    receive_at: currentDate,
    confirm_at: '',
    plan_out_at: '',
    plan_finish_at: '',
    is_out: 0,
    is_charge: 0, // 是否服务收费
    is_quote: 0, // 是否报价
    settle_status: 0,
    status: 0,
    source: 0,
    type: 3, // 维修工单
    level: 0,
    address: '',
    remark: '',
    engineers: [],
    engineer_ids: [], // 工程师列表
    machine_id: 0,
    customer: {
        id: 0,
        erp_cust_id: 0,
        number: '',
        name_short: '',
        industry: '',
        name: '',
        address: '',
        type: 0,
        level: 0,
        follow_up_status: 0,
        source: 0,
        staff_scale: 0,
        purchasing_power: 0
    },
    equipment: {
        type: 0,
        model: '',
        installation_staff: '',
        technology_staff: '',
        number: '',
        sets: '',
        main_no: '',
        control_box_no: '',
        welding_machine_no: '',
        welding_machine_model: '',
        axis1_no: '',
        axis2_no: '',
        axis3_no: '',
        axis4_no: '',
        axis5_no: '',
        axis6_no: '',
        code_chinese: '',
        identification_code: '',
        manufacture_date: '',
        purchase_date: '',
        installation_date: '',
        acceptance_date: '',
        warranty_date: '',
        maintenance_times: '',
        remark: '',
        contract_number: '',
        name: '',
        code_id: 0
    },
    fault: {
        type: 0, // 故障类型
        sequence: 0, // 故障频率
        is_line_broken: 0, // 线路是否破损
        is_part_broken: 0, // 部品是否损坏
        desc: '',
        code: '', // 故障代码
        file: '', // 故障附件
        remark: '' // 备注
    }
}

export const repair = {
    staff: {},
    staff_id: 0,
    service_order_id: 0,
    staff_name: '',
    process_id: 1,
    process: '',
    step_result: '',
    arrived_at: currentDate,
    complete_at: currentDate,
    cause_id: 1,
    next_step: 1,
    cause: '',
    step_doc_ids: '',
    cause_doc_ids: '',
    fault_doc_ids: '',
    remark: ''
} // 进度ID // 进度内容 // 处理措施结果
