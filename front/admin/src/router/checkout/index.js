import Main from '@/view/main'

export default [
  {
    path: '/checkout',
    name: 'checkout',
    component: Main,
    children: [
      {
        path: '/',
        name: 'checkout_list',
        meta: {
          icon: '_qq',
          title: '签到管理'
        },
        component: () => import('@/view/checkout/index.vue')
      }
    ]
  }
]
