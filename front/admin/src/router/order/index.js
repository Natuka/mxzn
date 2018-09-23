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
            path: '/repair',
            name: 'order_service_repair',
            meta: {
              icon: '_qq',
              title: '维修工单',
              access: [ 'order_service_repair' ]
            },
            component: () => import( '@/view/order/index.vue' )
          },
          {
            path: '/repair',
            name: 'order_service_setups',
            meta: {
              icon: '_qq',
              title: '安装工单',
              access: [ 'order_service_setups' ]
            },
            component: () => import( '@/view/order/index.vue' )
          },
          {
            path: '/repair',
            name: 'order_service_keep',
            meta: {
              icon: '_qq',
              title: '保养工单',
              access: [ 'order_service_keep' ]
            },
            component: () => import( '@/view/order/index.vue' )
          },
        ]
      },
      {
        path: '/confirm',
        name: 'order_confirm',
        meta: {
          icon: '_qq',
          title: '工单确认',
          access: [ 'order_confirm' ]
        },
        component: () => import( '@/view/order/index.vue' )
      },
      {
        path: '/',
        name: 'dispatch',
        meta: {
          icon: '_qq',
          title: '工单派工',
          access: [ 'order_dispatch' ]
        },
        component: () => import( '@/view/order/index.vue' )
      },
      {
        path: '/do',
        name: 'order_do',
        meta: {
          icon: '_qq',
          title: '工单处理',
          access: [ 'order_do' ]
        },
        component: () => import( '@/view/order/index.vue' )
      },
      {
        path: '/settle',
        name: 'order_settle',
        meta: {
          icon: '_qq',
          title: '结算收费',
          access: [ 'order_settle' ]
        },
        component: () => import( '@/view/order/index.vue' )
      },
      {
        path: '/check',
        name: 'order_check',
        meta: {
          icon: '_qq',
          title: '审核关闭',
          access: [ 'order_check' ]
        },
        component: () => import( '@/view/order/index.vue' )
      },
      {
        path: '/feedback',
        name: 'order_feedback',
        meta: {
          icon: '_qq',
          title: '客户回访',
          access: [ 'order_feedback' ]
        },
        component: () => import( '@/view/order/index.vue' )
      },
    ]
  }
]
