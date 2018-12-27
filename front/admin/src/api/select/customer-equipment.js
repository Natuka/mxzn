import {getApi} from '../../libs/api.request'

// 联系人
export function selectCustomerEquipment (customerId, id, name) {
  return getApi('select/customer-equipment', {
    customer_id: customerId,
    id: id,
    name
  })
}
