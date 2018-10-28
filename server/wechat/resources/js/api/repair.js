import {getApi, postApi} from '../util/axios'

export function repairList (params = {}) {
    return getApi('repair/list', params)
}

export function repairInfo (serviceOrderId, params) {
    return getApi(`repair/${serviceOrderId}`, params)
}

export function repairEdit (serviceOrderId, params) {
    return postApi(`repair/${serviceOrderId}`, params)
}

export function repairSwitch (serviceOrderId, data) {
    return postApi(`repair/${serviceOrderId}/switch`, data)
}

export function repairCancel (serviceOrderId, data) {
    return postApi(`repair/${serviceOrderId}/cancel`, data)
}

export function repairEquipment (serviceOrderId) {
    return getApi(`repair/${serviceOrderId}/equipment`)
}

export function repairService (serviceOrderId) {
    return getApi(`repair/${serviceOrderId}/service`)
}

export function repairAttendance (serviceOrderId) {
    return getApi(`repair/${serviceOrderId}/attendance`)
}

export function repairLog (serviceOrderId) {
    return getApi(`repair/${serviceOrderId}/log`)
}

export function repairFollowUp (serviceOrderId) {
    return getApi(`repair/${serviceOrderId}/follow-up`)
}
