import store from './store'

import Vue from 'vue'
import VueRouter from 'vue-router'

import auth from './auth'
import { user } from './api'

import { Toast } from 'vant'

let routes = [
    {
        path: '/404',
        component: () => import('./components/404'),
        meta: {
            auth: false
        }
    },
    {
        path: '/403',
        component: () => import('./components/403'),
        meta: {
            auth: false
        }
    },
    {
        path: '/login',
        component: () => import('./components/login'),
        meta: {
            auth: false
        }
    },
    {
        path: '/bind',
        component: () => import('./components/bind'),
        meta: {
            auth: true
        }
    },
    {
        path: '/upload',
        component: () => import('./components/upload'),
        meta: {
            auth: true
        }
    },
    {
        path: '/',
        component: () => import('./components/index'),
        meta: {
            auth: true
        }
    },
    {
        path: '/repair/detail',
        component: () => import('./components/repair/detail'),
        meta: {
            auth: true
        }
    },
    {
        path: '/repair/change',
        component: () => import('./components/repair/change'),
        meta: {
            auth: true
        }
    },
    {
        path: '/repair/attendance',
        component: () => import('./components/repair/attendance'),
        meta: {
            auth: true
        }
    },
    {
        path: '/repair/cancel',
        component: () => import('./components/repair/cancel'),
        meta: {
            auth: true
        }
    },
    {
        path: '/repair/edit',
        component: () => import('./components/repair/edit'),
        meta: {
            auth: true
        }
    },
    {
        path: '/repair/create',
        component: () => import('./components/repair/create'),
        meta: {
            auth: true
        }
    },
    {
        path: '/repair/list',
        component: () => import('./components/repair/list.vue'),
        meta: {
            auth: true
        }
    },
    {
        path: '/repair/engineer',
        component: () => import('./components/repair/engineer'),
        meta: {
            auth: true
        }
    },
    {
        path: '/repair/equipment',
        component: () => import('./components/repair/equipment'),
        meta: {
            auth: true
        }
    },
    {
        path: '/repair/followup',
        component: () => import('./components/repair/followup.vue'),
        meta: {
            auth: true
        }
    },
    {
        path: '/repair/log',
        component: () => import('./components/repair/log'),
        meta: {
            auth: true
        }
    },
    {
        path: '/repair/action',
        component: () => import('./components/repair/action'),
        meta: {
            auth: true
        }
    },
    {
        path: '/repair/repair-list',
        component: () => import('./components/repair/repair-list'),
        meta: {
            auth: true
        }
    },
    {
        path: '/repair/evaluate',
        component: () => import('./components/repair/evaluate'),
        meta: {
            auth: true
        }
    },
    {
        path: '/repair/service',
        component: () => import('./components/repair/service'),
        meta: {
            auth: true
        }
    },
    {
        path: '/select/engineer',
        component: () => import('./components/select/engineer'),
        meta: {
            auth: true
        }
    },
    {
        path: '/select/project',
        component: () => import('./components/select/project'),
        meta: {
            auth: true
        }
    },
    {
        path: '/select/part',
        component: () => import('./components/select/part'),
        meta: {
            auth: true
        }
    }
]

Vue.use(VueRouter)

const router = new VueRouter({
    routes
})

export default router

const toPage = location.hash.splice(1)

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.auth)) {
        if (!auth.loggedIn()) {
            next({ path: '/403', query: { redirect: to.fullPath } })
            return
        }
        next()
        return
    }

    if (auth.loggedIn()) {
        next(false)
    } else {
        next()
    }
})

router.afterEach((to, from) => {})

Toast.loading({
    mask: true,
    message: '加载中...'
})

// 首先先获取一次用户是否存在，然后进行跳转
user()
    .then(data => {
        store.dispatch('setUser', data)
        if (!data.mobile) {
            router.push({
                path: '/bind',
                query: {
                    redirect: toPage || '/repair/list'
                }
            })
        } else {
            router.push(toPage || '/repair/list')
        }

        Toast.clear()
    })
    .catch(() => {
        localStorage.userId = ''
        router.push('/403')
    })
