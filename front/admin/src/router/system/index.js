import Main from '@/view/main'
import parentView from '@/components/parent-view'

export default [
  {
    path: '/system',
    name: 'system',
    meta: {
      icon: 'md-menu',
      title: '系统管理'
    },
    component: Main,
    children: [
      {
        path: 'level_2_1',
        name: 'level_2_1',
        meta: {
          icon: 'md-funnel',
          title: '二级-1'
        },
        component: () => import('@/view/multilevel/level-2-1.vue')
      },
      {
        path: 'base',
        name: 'base',
        meta: {
          access: ['super_admin'],
          icon: 'md-funnel',
          showAlways: true,
          title: '二级-2'
        },
        component: parentView,
        children: [
          {
            path: 'base_1',
            name: 'base_1',
            meta: {
              icon: 'md-funnel',
              title: '三级'
            },
            component: () => import('@/view/base/level-2-2/level-3-1.vue')
          }
        ]
      },
      {
        path: 'level_2_3',
        name: 'level_2_3',
        meta: {
          icon: 'md-funnel',
          title: '二级-3'
        },
        component: () => import('@/view/multilevel/level-2-3.vue')
      },
    ]
  },
]
