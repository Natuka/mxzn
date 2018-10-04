import Main from '@/view/main'
// import parentView from '@/components/parent-view'

export default [
  {
    path: '/machine',
    name: 'machine',
    component: Main,
    meta: {
      access: ['machine_list'],
      title: '设备管理'
    },
    // redirect: '/machine/list',
    children: [
      {
        path: '/',
        name: 'machine_list',
        meta: {
          icon: '_qq',
          title: '物料资料管理',
          access: ['machine_list']
        },
        component: () => import('@/view/machine/index.vue')
      },
      {
        path: '/stock',
        name: 'machine_stock',
        meta: {
          icon: '_qq',
          title: '物料库存查询',
          access: ['machine_stock']
        }
      },
      {
        path: '/price',
        name: 'machine_price',
        meta: {
          icon: '_qq',
          title: '物料价格管理',
          access: ['machine_price']
        },
        component: () => import('@/view/machine/index.vue')
      },
      {
        path: '/qrcode',
        name: 'machine_qrcode',
        meta: {
          icon: '_qq',
          title: '设备二维码管理',
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
      }
    ]
  }
]
