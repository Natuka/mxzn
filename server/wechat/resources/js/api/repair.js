import { getApi, postApi } from '../util/axios'

export function repairList(params = {}) {
    return getApi('repair/list', params)
}

// 创建工单
export function repairCreate(params = {}) {
    return postApi('repair/create', params)
}

// 获取工单处理列表
export const fetchRepairRepairList = (serviceOrderId, params) =>
    getApi(`repair/${serviceOrderId}/repair`, params)

// 工单处理
export function repairCreateRepair(serviceOrderId, params = {}) {
    return postApi(`repair/${serviceOrderId}/repair`, params)
}

// 获取信息
export function repairInfo(serviceOrderId, params) {
    return getApi(`repair/${serviceOrderId}/info`, params)
}

// 获取最后一笔评价信息
export function repairEvaluateLast() {
    return getApi(`repair/evaluate/last`)
}

// 评价列表
export function repairEvaluateList(params) {
    return getApi(`repair/evaluate/list`, params)
}

// 编辑
export function repairEdit(serviceOrderId, params) {
    return postApi(`repair/${serviceOrderId}`, params)
}

// 切换
export function repairSwitch(serviceOrderId, data) {
    return postApi(`repair/${serviceOrderId}/switch`, data)
}

// 取消
export function repairCancel(serviceOrderId, data) {
    return postApi(`repair/${serviceOrderId}/cancel`, data)
}

// 设备
export function repairEquipment(serviceOrderId) {
    return getApi(`repair/${serviceOrderId}/equipment`)
}

// 服务
export function repairService(serviceOrderId) {
    return getApi(`repair/${serviceOrderId}/service`)
}

// 签到记录
export function repairAttendance(serviceOrderId) {
    return getApi(`repair/${serviceOrderId}/attendance`)
}

// 签到
export function postRepairAttendance(serviceOrderId, params) {
    return postApi(`repair/${serviceOrderId}/attendance`, params)
}

// 操作日志
export function repairLog(serviceOrderId) {
    return getApi(`repair/${serviceOrderId}/log`)
}

// 催单
export function repairFollowUp(serviceOrderId) {
    return getApi(`repair/${serviceOrderId}/follow-up`)
}
