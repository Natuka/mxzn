import Main from '@/view/main'

export default [
  {
    path: '/order-progress',
    name: 'order_progress',
    component: Main,
    children: [
      {
        path: '/',
        name: 'order_progress_list',
        meta: {
          icon: '_qq',
          title: '工单进度管理'
        },
        component: () => import('@/view/order-progress/index.vue')
      }
    ]
  }
]
