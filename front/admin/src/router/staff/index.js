import Main from '@/view/main'

export default [
  {
    path: '/staff',
    name: 'staff',
    component: Main,
    meta: {
      access: ['staff_list'],
      title: '人事管理',
    },
    // redirect: '/staff/doc',
    children: [
      {
        path: '/',
        name: 'staff_list',
        meta: {
          icon: '_qq',
          title: '人员档案',
          access: ['staff_list']
        },
        component: () => import('@/view/staff/index.vue')
      },
      {
        path: '/',
        name: 'out_apply',
        meta: {
          icon: '_qq',
          title: '外出申请',
          access: ['staff_docs']
        },
        component: () => import('@/view/staff/index.vue')
      },
      {
        path: '/',
        name: 'contact',
        meta: {
          icon: '_qq',
          title: '客户管理',
          access: ['staff_contact']
        },
        component: () => import('@/view/staff/index.vue')
      }
    ]
  }
]
