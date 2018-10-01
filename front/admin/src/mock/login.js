import { getParams } from '@/libs/util'
const USER_MAP = {
  super_admin: {
    name: 'super_admin',
    user_id: '1',
    access: ['super_admin',
      'admin',
      'agent_add',
      'agent_list',
      'agent_view',
      'agent_edit',

      'staff_list',
      'staff_add',
      'staff_view',
      'staff_edit',
      'department_list',
      'department_add',
      'department_view',
      'department_edit',
      'job_list',
      'job_add',
      'job_view',
      'job_edit',
      'post_list',
      'post_add',
      'post_view',
      'post_edit',
      'signin_list',
      'signin_add',
      'signin_view',
      'signin_edit',
      'customer_list',
      'customer_add',
      'customer_edit',
      'customer_docs',
      'customer_contact',

      'order_list',
      'order_check',
      'order_dispatch',
      'order_do',
      'order_confirm',
      'order_service',
      'order_service_repair',
      'order_service_setups',
      'order_service_keep',
      'order_settle',
      'order_feedback',

      'machine_list',
      'machine_add',
      'machine_edit',
      'machine_price',
      'machine_customer',
      'machine_qrcode',
      'machine_stock'
    ], // 权限列表
    token: 'super_admin',
    avator: 'https://file.iviewui.com/dist/a0e88e83800f138b94d2414621bd9704.png'
  },
  admin: {
    name: 'admin',
    user_id: '2',
    access: ['admin'],
    token: 'admin',
    avator: 'https://avatars0.githubusercontent.com/u/20942571?s=460&v=4'
  }
}

export const login = req => {
  req = JSON.parse(req.body)
  return { token: USER_MAP[req.userName].token }
}

export const getUserInfo = req => {
  const params = getParams(req.url)
  return USER_MAP[params.token]
}

export const logout = req => {
  return null
}
