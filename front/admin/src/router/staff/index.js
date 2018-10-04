import Main from '@/view/main'

export default [
  {
    path: '/staff',
    name: 'staff',
    component: Main,
    meta: {
      access: ['staff_list'],
      title: '人事管理'
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
        path: '/out_apply',
        name: 'out_apply',
        meta: {
          icon: '_qq',
          title: '外出申请',
          access: ['staff_docs']
        },
        component: () => import('@/view/staff/index.vue')
      },
      {
        path: '/signin',
        name: 'signin_list',
        meta: {
          icon: '_qq',
          title: '签到记录',
          access: ['signin_list']
        },
        component: () => import('@/view/staff/index.vue')
      },
      {
        path: '/reporting',
        name: 'reporting_list',
        meta: {
          icon: '_qq',
          title: '工作汇报',
          access: ['reporting_list']
        },
        component: () => import('@/view/staff/index.vue')
      },
      {
        path: '/organization',
        name: 'organization_list',
        meta: {
          icon: '_qq',
          title: '公司/组织',
          access: ['organization_list']
        },
        component: () => import('@/view/organization/index.vue')
      },
      {
        path: '/department',
        name: 'department_list',
        meta: {
          icon: '_qq',
          title: '部门管理',
          access: ['department_list']
        },
        component: () => import('@/view/department/index.vue')
      },
      {
        path: '/job',
        name: 'job_list',
        meta: {
          icon: '_qq',
          title: '职务管理',
          access: ['department_list']
        },
        component: () => import('@/view/job/index.vue')
      },
      {
        path: '/post',
        name: 'post_list',
        meta: {
          icon: '_qq',
          title: '职位管理',
          access: ['department_list']
        },
        component: () => import('@/view/department/index.vue')
      }
    ]
  }
]
