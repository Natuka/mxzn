import store from './store'

import Vue from "vue";
import VueRouter from "vue-router";

import auth from './auth'
import {user} from "./api";

import {Toast} from 'vant'

let routes = [
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
            auth: false
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
        path: '/repair/service',
        component: () => import('./components/repair/service'),
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

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.auth)) {
        if (!auth.loggedIn()) {
            next({
                path: '/login',
                query: {redirect: to.fullPath}
            })
        } else {
            next()
        }
    } else {
        if (auth.loggedIn()) {
            console.log('login', to.path)
            next(false)
        } else {
            next()
        }
    }
})

router.afterEach((to, from) => {

})

Toast.loading({
    mask: true,
    message: '加载中...'
})

// 首先先获取一次用户是否存在，然后进行跳转
user().then((data) => {
    console.log('data', data)
    store.dispatch('setUser', data)
    router.push('/repair/list')
    Toast.clear()
}).catch(() => {
    localStorage.userId = ''
    router.push('/login')
})
