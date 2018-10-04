import Main from '@/view/main'
import parentView from '@/components/parent-view'

export default [
  {
    path: '/order',
    name: 'order',
    component: Main,
    meta: {
      access: [ 'order_list' ],
      title: '工单管理',
    },
    redirect: '/order/service',
    children: [
      // {
      //   path: '/',
      //   name: 'order_list',
      //   meta: {
      //     icon: '_qq',
      //     title: '工单管理',
      //     access: ['order_list']
      //   },
      //   component: () => import('@/view/order/index.vue')
      // },
      {
        path: '/service',
        name: 'order_service',
        meta: {
          icon: '_qq',
          title: '工单维护',
          access: [ 'order_service' ]
        },
        component: () => parentView,
        children: [
          {
            path: '/order_flow/repair',
            name: 'order_repair_list',
            meta: {
              icon: '_qq',
              title: '维修工单',
              access: [ 'order_repair_list' ]
            },
            component: () => import( '@/view/order_flow/repair/index.vue' )
          },
          {
            path: '/order_flow/install',
            name: 'order_install_list',
            meta: {
              icon: '_qq',
              title: '安装工单',
              access: [ 'order_install_list' ]
            },
            component: () => import( '@/view/order_flow/install/index.vue' )
          },
          {
            path: '/order_flow/maintain',
            name: 'order_maintain_list',
            meta: {
              icon: '_qq',
              title: '保养工单',
              access: [ 'order_maintain_list' ]
            },
            component: () => import( '@/view/order_flow/maintain/index.vue' )
          },
        ]
      },
      {
        path: '/order_flow/confirm',
        name: 'order_confirm_list',
        meta: {
          icon: '_qq',
          title: '工单确认',
          access: [ 'order_confirm_list' ]
        },
        component: () => import( '@/view/order_flow/confirm/index.vue' )
      },
      {
        path: '/order_flow/dispatch',
        name: 'order_dispatch_list',
        meta: {
          icon: '_qq',
          title: '工单派工',
          access: [ 'order_dispatch_list' ]
        },
        component: () => import( '@/view/order_flow/dispatch/index.vue' )
      },
      {
        path: '/order_flow/dispose',
        name: 'order_dispose_list',
        meta: {
          icon: '_qq',
          title: '工单处理',
          access: [ 'order_dispose_list' ]
        },
        component: () => import( '@/view/order_flow/dispose/index.vue' )
      },
      {
        path: '/order_flow/charge',
        name: 'order_charge_list',
        meta: {
          icon: '_qq',
          title: '结算收费',
          access: [ 'order_charge_list' ]
        },
        component: () => import( '@/view/order_flow/charge/index.vue' )
      },
      {
        path: '/order_flow/close',
        name: 'order_close_list',
        meta: {
          icon: '_qq',
          title: '审核关闭',
          access: [ 'order_close_list' ]
        },
        component: () => import( '@/view/order_flow/close/index.vue' )
      },
      {
        path: '/order_flow/review',
        name: 'order_review_list',
        meta: {
          icon: '_qq',
          title: '客户回访',
          access: [ 'order_review_list' ]
        },
        component: () => import( '@/view/order_flow/review/index.vue' )
      },
    ]
  }
]
