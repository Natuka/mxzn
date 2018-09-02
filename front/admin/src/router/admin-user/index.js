import Main from '@/view/main'

export default [
  {
    path: '/admin-user',
    name: 'admin-user',
    component: Main,
    children: [
      {
        path: '/',
        name: 'admin-user_list',
        meta: {
          icon: '_qq',
          title: '账号管理'
        },
        component: () => import('@/view/admin-user/index.vue')
      }
    ]
  }
]
