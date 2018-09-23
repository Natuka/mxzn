import Main from '@/view/main'

export default [
  {
    path: '/organization',
    name: 'organization',
    component: Main,
    meta: {
      access: ['organization_list']
    },
    children: [
      {
        path: '/',
        name: 'organization_list',
        meta: {
          icon: '_qq',
          title: '公司/组织',
          access: ['organization_list']
        },
        component: () => import('@/view/organization/index.vue')
      }
    ]
  }
]
