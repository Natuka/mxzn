import Main from '@/view/main'

export default [
  {
    path: '/staff',
    name: 'staff',
    component: Main,
    children: [
      {
        path: '/',
        name: 'staff_list',
        meta: {
          icon: '_qq',
          title: '账号管理'
        },
        component: () => import('@/view/staff/index.vue')
      }
    ]
  }
]
