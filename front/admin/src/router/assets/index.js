import Main from '@/view/main'

export default [
  {
    path: '/assets',
    name: 'assets',
    component: Main,
    children: [
      {
        path: '/',
        name: 'assets_list',
        meta: {
          icon: '_qq',
          title: '资产管理'
        },
        component: () => import('@/view/assets/index.vue')
      }
    ]
  }
]
