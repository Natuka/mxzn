import Main from '@/view/main'

export default [
  {
    path: '/repair-logs',
    name: 'repair logs',
    component: Main,
    meta: {
      access: ['repair_logs']
    },
    children: [
      {
        path: '/',
        name: 'repair_logs',
        meta: {
          icon: '_qq',
          title: ' PC/微信报修',
          access: ['repair_logs']
        },
        component: () => import('@/view/repair_logs/index.vue')
      }
    ]
  }
]
