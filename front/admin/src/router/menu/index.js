import Main from '@/view/main'

export default [
  {
    path: '/menu',
    name: 'menu_parent',
    component: Main,
    children: [
      {
        path: '/',
        name: 'menu',
        meta: {
          icon: '_qq',
          title: '菜单管理'
        },
        component: () => import('@/view/menu/index.vue')
      }
    ]
  }
]
