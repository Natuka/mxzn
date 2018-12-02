import { getApi } from '../util/axios'

// 获取
export function fetchEquipmentList() {
    return getApi(`equipment`)
}
