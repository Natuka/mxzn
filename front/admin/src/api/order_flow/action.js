import {postApi} from '@/libs/api.request'

// 取消
export function orderServiceCancel (orderId, type = 'repair', data = {}) {
  return postApi(`order_flow/${type}/${orderId}/cancel`, data)
}

// 派工
export function orderServiceDispatch (orderId, type = 'repair', data = {}) {
  return postApi(`order_flow/${type}/${orderId}/dispatch`, data)
}

// 转派
export function orderServiceSwitch (orderId, type = 'repair', data = {}) {
  return postApi(`order_flow/${type}/${orderId}/switch`, data)
}
