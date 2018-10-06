import Main from '@/view/main'

export default [
  {
    path: '/report',
    name: 'report',
    component: Main,
    meta: {
      access: ['report_list'],
      title: '报表管理',
    },
    redirect: '/kpm/doc',
    children: [
      {
        path: '/',
        name: 'orderclose_list',
        meta: {
          icon: '_qq',
          title: '已结工单',
          access: ['kpm_list']
        },
        component: () => import('@/view/kpm/index.vue')
      },
      {
        path: '/',
        name: 'orderrepair_list',
        meta: {
          icon: '_qq',
          title: '工单修复',
          access: ['kpm_list']
        },
        component: () => import('@/view/kpm/index.vue')
      },
      {
        path: '/',
        name: 'orderincome_list',
        meta: {
          icon: '_qq',
          title: '工单收入',
          access: ['kpm_list']
        },
        component: () => import('@/view/kpm/index.vue')
      },
      {
        path: '/',
        name: 'orderpart_list',
        meta: {
          icon: '_qq',
          title: '配件销售',
          access: ['kpm_list']
        },
        component: () => import('@/view/kpm/index.vue')
      },
      {
        path: '/',
        name: 'orderresponse_list',
        meta: {
          icon: '_qq',
          title: '响应时效',
          access: ['kpm_list']
        },
        component: () => import('@/view/kpm/index.vue')
      },
      {
        path: '/',
        name: 'orderrate_list',
        meta: {
          icon: '_qq',
          title: '工单评级',
          access: ['kpm_list']
        },
        component: () => import('@/view/kpm/index.vue')
      },
    ]
  }
]
