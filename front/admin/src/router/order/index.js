import Main from '@/view/main'

export default [
  {
    path: '/order',
    name: 'order_parent',
    component: Main,
    children: [
      {
        path: '/',
        name: 'order',
        meta: {
          icon: '_qq',
          title: '工单管理'
        },
        component: () => import('@/view/order/index.vue')
      }
    ]
  }
]
