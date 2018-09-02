import Main from '@/view/main'

export default [
  {
    path: '/customer',
    name: 'customer',
    component: Main,
    children: [
      {
        path: '/',
        name: 'customer_list',
        meta: {
          icon: '_qq',
          title: '客户管理'
        },
        component: () => import('@/view/customer/index.vue')
      }
    ]
  }
]
