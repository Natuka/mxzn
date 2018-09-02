import Main from '@/view/main'

export default [
  {
    path: '/stock',
    name: 'role',
    component: Main,
    children: [
      {
        path: '/',
        name: 'stock_list',
        meta: {
          icon: '_qq',
          title: '库存管理'
        },
        component: () => import('@/view/stock/index.vue')
      }
    ]
  }
]
