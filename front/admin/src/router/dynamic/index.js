import Main from '@/view/main'

export default [
  {
    path: '/argu',
    name: 'argu',
    meta: {
      hideInMenu: true
    },
    component: Main,
    children: [
      {
        path: 'params/:id',
        name: 'params',
        meta: {
          icon: 'md-flower',
          title: '动态路由',
          notCache: true
        },
        component: () => import('@/view/argu-page/params.vue')
      },
      {
        path: 'query',
        name: 'query',
        meta: {
          icon: 'md-flower',
          title: '带参路由',
          notCache: true
        },
        component: () => import('@/view/argu-page/query.vue')
      }
    ]
  }
]
