import auth from '../auth'
export default {
    requireAuth(to, from, next){
        if(!auth.loggedIn()){
            next({
                path:'/login',
                query:{redirect:to.fullPath}
            })
        }else{
            // 在这里边判断权限吧
            console.log(to)
            next()
        }
    }
}