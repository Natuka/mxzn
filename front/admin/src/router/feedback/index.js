import Main from '@/view/main'

export default [
  {
    path: '/feedback',
    name: 'feedback',
    component: Main,
    children: [
      {
        path: '/',
        name: 'feedback_list',
        meta: {
          icon: '_qq',
          title: '反馈管理'
        },
        component: () => import('@/view/feedback/index.vue')
      }
    ]
  }
]
