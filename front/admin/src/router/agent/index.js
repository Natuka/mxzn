import Main from '@/view/main'

export default [
  {
    path: '/agent',
    name: 'agent',
    component: Main,
    meta: {
      access: ['agent_list']
    },
    children: [
      {
        path: '/',
        name: 'agent_list',
        meta: {
          icon: '_qq',
          title: '代理商管理',
          access: ['agent_list']
        },
        component: () => import('@/view/agent/index.vue')
      }
    ]
  }
]
