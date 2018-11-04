import Main from '@/view/main'
import parentView from '@/components/parent-view'

export default [
  {
    path: '/order_flow',
    name: 'order_flow',
    meta: {
      icon: 'md-menu',
      title: '工单管理',
      access: ['order_flow']
    },
    component: Main,
    children: [
      {
        path: 'repair',
        name: 'order_flow_repair_list',
        meta: {
          icon: '_qq',
          title: '工单维护',
          access: ['order_flow_repair_list']
        },
        component: () => import('@/view/order_flow/repair/index.vue')
      },
      {
        path: 'confirm',
        name: 'order_flow_confirm_list',
        meta: {
          icon: '_qq',
          title: '工单确认',
          access: ['order_flow_confirm_list']
        },
        component: () => import('@/view/order_flow/confirm/index.vue')
      },
      {
        path: 'dispatch',
        name: 'order_flow_dispatch_list',
        meta: {
          icon: '_qq',
          title: '工单派工',
          access: ['order_flow_dispatch_list']
        },
        component: () => import('@/view/order_flow/dispatch/index.vue')
      },
      {
        path: 'dispose',
        name: 'order_flow_dispose_list',
        meta: {
          icon: '_qq',
          title: '工单处理',
          access: ['order_flow_dispose_list']
        },
        component: () => import('@/view/order_flow/dispose/index.vue')
      },
      {
        path: 'charge',
        name: 'order_flow_charge_list',
        meta: {
          icon: '_qq',
          title: '结算收费',
          access: ['order_flow_charge_list']
        },
        component: () => import('@/view/order_flow/charge/index.vue')
      },
      {
        path: 'close',
        name: 'order_flow_close_list',
        meta: {
          icon: '_qq',
          title: '审核关闭',
          access: ['order_flow_close_list']
        },
        component: () => import('@/view/order_flow/close/index.vue')
      },
      {
        path: 'review',
        name: 'order_flow_review_list',
        meta: {
          icon: '_qq',
          title: '客户回访',
          access: ['order_flow_review_list']
        },
        component: () => import('@/view/order_flow/review/index.vue')
      }
    ]
  }
]
