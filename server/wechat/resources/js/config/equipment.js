import dayjs from 'dayjs'

const currentDate = dayjs().format('YYYY-MM-DD HH:mm:ss')

export default {
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
}

export const TYPE_LIST = '系统,单机,配件,损耗件,其他'.split(',')
