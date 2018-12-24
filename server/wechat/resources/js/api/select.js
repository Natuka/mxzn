import { getApi } from '../util/axios'

// 获取
export function fetchEquipmentList() {
    return getApi(`equipment`)
}

// 选择项目
export function fetchProjectList(name = '', page = 1) {
    return getApi('select/project', { name, page })
}

// 选择部件
export function fetchPartList(name = '', page = 1) {
    return getApi('select/part', { name, page })
}

// 选择工程师
export function fetchEngineerList(name = '', page = 1) {
    return getApi('select/engineer', { name, page })
}
