import Main from '@/view/main'

export default [
  {
    path: '/customer',
    name: 'customer',
    component: Main,
    meta: {
      icon: 'md-contacts',
      access: ['customer_list'],
      title: '客户管理'
    },
    // redirect: '/customer/doc',
    children: [
      {
        path: '/',
        name: 'customer_list',
        meta: {
          icon: '_qq',
          title: '客户管理',
          access: ['customer_list']
        },
        component: () => import('@/view/customer/index.vue')
      },
      // {
      //   path: '/',
      //   name: 'docs',
      //   meta: {
      //     icon: '_qq',
      //     title: '客户管理',
      //     access: ['customer_docs']
      //   },
      //   component: () => import('@/view/customer/index.vue')
      // },
      {
        path: '/customer-contact',
        name: 'customercontact_list',
        meta: {
          icon: '_qq',
          title: '客户联系人',
          access: ['customercontact_list']
        },
        component: () => import('@/view/customer-contact/index.vue')
      }
      // ,
      // {
      //   path: '/customer-quotation',
      //   name: 'customerquotation_list',
      //   meta: {
      //     icon: '_qq',
      //     title: '报价单',
      //     access: ['customerquotation_list']
      //   },
      //   component: () => import('@/view/customer-quotation/index.vue')
      // }
    ]
  }
]
