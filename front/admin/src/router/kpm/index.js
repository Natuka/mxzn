import Main from '@/view/main'

export default [
  {
    path: '/kpm',
    name: 'kpm',
    component: Main,
    meta: {
      access: ['kpm_list'],
      title: '知识库管理',
      icon: 'ios-book'
    },
    redirect: '/kpm/doc',
    children: [
      {
        path: '/',
        name: 'kpm_list',
        meta: {
          icon: '_qq',
          title: '知识库维护',
          access: ['kpm_list']
        },
        component: () => import('@/view/kpm/index.vue')
      },
      {
        path: '/',
        name: 'kpmquery_list',
        meta: {
          icon: '_qq',
          title: '知识库查询',
          access: ['kpm_list']
        },
        component: () => import('@/view/kpm/index.vue')
      },
    ]
  }
]
