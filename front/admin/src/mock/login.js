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

      'pcweixin_add',
      'pcweixin_list',
      'pcweixin_view',
      'pcweixin_edit',

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
      'customercontact_list',
      'customercontact_add',
      'customercontact_view',
      'customercontact_edit',
      'order_list',
      'order_service',
      'order_repair_list',
      'order_repair_add',
      'order_repair_view',
      'order_repair_edit',
      'order_install_list',
      'order_install_add',
      'order_install_view',
      'order_install_edit',
      'order_maintain_list',
      'order_maintain_add',
      'order_maintain_view',
      'order_maintain_edit',
      'order_confirm_list',
      'order_confirm_add',
      'order_confirm_view',
      'order_confirm_edit',
      'order_dispatch_list',
      'order_dispatch_add',
      'order_dispatch_view',
      'order_dispatch_edit',
      'order_dispose_list',
      'order_dispose_add',
      'order_dispose_view',
      'order_dispose_edit',
      'order_charge_list',
      'order_charge_add',
      'order_charge_view',
      'order_charge_edit',
      'order_close_list',
      'order_close_add',
      'order_close_view',
      'order_close_edit',
      'order_review_list',
      'order_review_add',
      'order_review_view',
      'order_review_edit',

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
