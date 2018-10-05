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
        path: 'base',
        name: 'base',
        meta: {
          access: ['super_admin'],
          icon: 'md-funnel',
          showAlways: true,
          title: '基础资料'
        },
        component: parentView,
        children: [
          {
            path: 'service',
            name: 'service',
            meta: {
              icon: 'md-funnel',
              title: '服务项目'
            },
            component: () => import('@/view/system/base/level-3-1.vue')
          },
          {
            path: 'vendor',
            name: 'vendor',
            meta: {
              icon: 'md-funnel',
              title: '供应商'
            },
            component: () => import('@/view/system/base/level-3-1.vue')
          },
          {
            path: 'brand',
            name: 'brand',
            meta: {
              icon: 'md-funnel',
              title: '品牌'
            },
            component: () => import('@/view/system/base/level-3-1.vue')
          },
          {
            path: 'unit',
            name: 'unit',
            meta: {
              icon: 'md-funnel',
              title: '单位'
            },
            component: () => import('@/view/system/base/level-3-1.vue')
          },
          {
            path: 'warehouse',
            name: 'warehouse',
            meta: {
              icon: 'md-funnel',
              title: '仓库'
            },
            component: () => import('@/view/system/base/level-3-1.vue')
          }
        ]
      },
      {
        path: 'set',
        name: 'set',
        meta: {
          access: ['super_admin'],
          icon: 'md-funnel',
          showAlways: true,
          title: '系统设置'
        },
        component: parentView,
        children: [
          {
            path: 'baseset',
            name: 'baseset',
            meta: {
              icon: 'md-funnel',
              title: '基本设置'
            },
            component: () => import('@/view/system/set/baseset.vue')
          },
          {
            path: 'billnoset',
            name: 'billnoset',
            meta: {
              icon: 'md-funnel',
              title: '单号设置'
            },
            component: () => import('@/view/system/set/billnoset.vue')
          },
          {
            path: 'checkset',
            name: 'checkset',
            meta: {
              icon: 'md-funnel',
              title: '考勤设置'
            },
            component: () => import('@/view/system/set/checkset.vue')
          },
          {
            path: 'pushset',
            name: 'pushset',
            meta: {
              icon: 'md-funnel',
              title: '推送设置'
            },
            component: () => import('@/view/system/set/pushset.vue')
          },
          {
            path: 'weixinset',
            name: 'weixinset',
            meta: {
              icon: 'md-funnel',
              title: '微信设置'
            },
            component: () => import('@/view/system/set/weixinset.vue')
          }
        ]
      },
      {
        path: 'log',
        name: 'log',
        meta: {
          icon: 'md-funnel',
          title: '系统日志'
        },
        component: () => import('@/view/system/log.vue')
      }
    ]
  },
]
