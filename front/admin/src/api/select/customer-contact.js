import {getApi} from '../../libs/api.request'

// 联系人
export function selectCustomerContact (customerId) {
  return getApi('select/customer-contact', {
    customer_id: customerId
  })
}
