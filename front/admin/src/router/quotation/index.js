import Main from '@/view/main'

export default [
  {
    path: '/quotation',
    name: 'quotation',
    component: Main,
    meta: {
      icon: 'md-contacts',
      access: ['quotation_list'],
      title: '报件管理'
    },
    // redirect: '/customer/doc',
    children: [
      {
        path: '/',
        name: 'customer_list',
        meta: {
          icon: '_qq',
          title: '报件管理',
          access: ['customer_list']
        },
        component: () => import('@/view/customer-quotation-materiel/index.vue')
      },
      {
        path: '/customer-quotation',
        name: 'customerquotation_list',
        meta: {
          icon: '_qq',
          title: '报价单',
          access: ['customerquotation_list']
        },
        component: () => import('@/view/customer-quotation/index.vue')
      }
    ]
  }
]
