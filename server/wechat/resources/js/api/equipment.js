import { getApi, postApi } from '../util/axios'

// 获取
export function fetchEquipmentList(id = 0) {
    return getApi(`equipment`, { id })
}

export const createEquipment = (data = {}) => postApi('equipment/create', data)
