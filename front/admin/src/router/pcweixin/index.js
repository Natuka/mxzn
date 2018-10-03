import Main from '@/view/main'

export default [
  {
    path: '/pcweixin',
    name: 'pcweixin',
    component: Main,
    meta: {
      access: ['pcweixin_list']
    },
    children: [
      {
        path: '/',
        name: 'pcweixin_list',
        meta: {
          icon: '_qq',
          title: '报修记录',
          access: ['pcweixin_list']
        },
        component: () => import('@/view/pcweixin/index.vue')
      }
    ]
  }
]
