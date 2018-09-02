import Main from '@/view/main'

export default [
  {
    path: '/agent',
    name: 'agent',
    component: Main,
    children: [
      {
        path: '/',
        name: 'agent_list',
        meta: {
          icon: '_qq',
          title: '代理商管理'
        },
        component: () => import('@/view/agent/index.vue')
      }
    ]
  }
]
