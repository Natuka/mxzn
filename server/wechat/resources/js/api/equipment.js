import { getApi, postApi } from '../util/axios'

// 获取
export function fetchEquipmentList() {
    return getApi(`equipment`)
}

export const createEquipment = (data = {}) => postApi('equipment/create', data)
