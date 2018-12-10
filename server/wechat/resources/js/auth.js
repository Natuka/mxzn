import config from './config/api-config'
import axios from 'axios'

export default {
    login(email, pass, cb) {
        cb = arguments[arguments.length - 1]
        if (localStorage.token) {
            if (cb) cb(true)
            this.onChange(true)
            return
        }
        pretendRequest(email, pass, res => {
            if (res.authenticated) {
                localStorage.is_admin = res.is_admin
                localStorage.name = res.name
                localStorage.user_type = res.user_type
                localStorage.token = res.token
                if (cb) cb(true)
                this.onChange(true)
            } else {
                if (cb) cb(false)
                this.onChange(false)
            }
        })
    },

    getToken() {
        return localStorage.token
    },

    isAdmin() {
        return localStorage.is_admin
    },

    userType() {
        return localStorage.user_type
    },

    userName() {
        return localStorage.name
    },

    logout(cb) {
        axios
            .get(config.host + 'admin/logout')
            .then(function(response) {})
            .catch(function(err) {})
        delete localStorage.token
        if (cb) cb()
        this.onChange(false)
    },

    loggedIn() {
        return !!localStorage.userId
    },

    onChange() {}
}

function pretendRequest(email, pass, cb) {
    setTimeout(() => {
        axios
            .post(config.host + 'admin/login', {
                username: email,
                password: pass
            })
            .then(function(response) {
                console.log(response)
                if (response.data.code == 0) {
                    cb({
                        authenticated: true,
                        is_admin: response.data.user.is_admin,
                        user_type: response.data.user.user_type,
                        name: response.data.user.name,
                        token: response.data.token
                    })
                } else {
                    cb({ authenticated: false })
                }
            })
            .catch(function(err) {
                console.log(err)
            })
    }, 0)
}
