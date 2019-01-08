import Main from '@/view/main'

export default [
  {
    path: '/quotation',
    name: 'quotation',
    component: Main,
    meta: {
      icon: 'md-contacts',
      access: ['quotation_list'],
      title: '报价管理'
    },
    // redirect: '/customer/doc',
    children: [
      {
        path: '/',
        name: 'customerquotation_list',
        meta: {
          icon: '_qq',
          title: '报价维护',
          access: ['customerquotation_list']
        },
        component: () => import('@/view/customer-quotation/index.vue')
      },
      {
        path: '/customer-quotation-materiel',
        name: 'customerquotation_materiel_list',
        meta: {
          icon: '_qq',
          title: '报价查询',
          access: ['customer_list']
        },
        component: () => import('@/view/customer-quotation-materiel/index.vue')
      }
    ]
  }
]
