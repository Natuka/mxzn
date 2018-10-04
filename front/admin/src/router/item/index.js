import Main from '@/view/main'
import parentView from '@/components/parent-view'

export default [
  {
    path: '/item',
    name: 'item',
    component: Main,
    meta: {
      access: ['item_list'],
      title: '设备管理',
    },
    // redirect: '/machine/list',
    children: [
      {
        path: '/',
        name: 'machine_list',
        meta: {
          icon: '_qq',
          title: '设备资料',
          access: ['machine_list']
        },
        component: () => import('@/view/machine/index.vue')
      },
      {
        path: '/stock',
        name: 'machine_stock',
        meta: {
          icon: '_qq',
          title: '库存查询',
          access: ['machine_stock']
        },
      },
      {
        path: '/price',
        name: 'machine_price',
        meta: {
          icon: '_qq',
          title: '价格管理',
          access: ['machine_price']
        },
        component: () => import('@/view/machine/index.vue')
      },
      {
        path: '/qrcode',
        name: 'machine_qrcode',
        meta: {
          icon: '_qq',
          title: '二维码管理',
          access: ['machine_qrcode']
        },
        component: () => import('@/view/machine/index.vue')
      },
      {
        path: '/customer',
        name: 'machine_customer',
        meta: {
          icon: '_qq',
          title: '客户设备管理',
          access: ['machine_customer']
        },
        component: () => import('@/view/machine/index.vue')
      },
    ]
  }
]
