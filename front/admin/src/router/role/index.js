import Main from '@/view/main'

export default [
  {
    path: '/role',
    name: 'role',
    component: Main,
    children: [
      {
        path: '/',
        name: 'role_list',
        meta: {
          icon: '_qq',
          title: '角色管理'
        },
        component: () => import('@/view/role/index.vue')
      }
    ]
  }
]
