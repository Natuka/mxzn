import Main from '@/view/main'

export default [
  {
    path: '/customer',
    name: 'customer',
    component: Main,
    meta: {
      access: ['customer_list'],
      title: '客户管理',
    },
    redirect: '/customer/doc',
    children: [
      // {
      //   path: '/',
      //   name: 'customer_list',
      //   meta: {
      //     icon: '_qq',
      //     title: '客户管理',
      //     access: ['customer_list']
      //   },
      //   component: () => import('@/view/customer/index.vue')
      // },
      {
        path: '/',
        name: 'docs',
        meta: {
          icon: '_qq',
          title: '客户档案',
          access: ['customer_docs']
        },
        component: () => import('@/view/customer/index.vue')
      },
      {
        path: '/',
        name: 'contact',
        meta: {
          icon: '_qq',
          title: '客户管理',
          access: ['customer_contact']
        },
        component: () => import('@/view/customer/index.vue')
      },
    ]
  }
]
