import config from './api-config'

let api = {
    register:config.host + 'user/add',

    login:config.host + 'oauth/token',
    user:config.host + 'user'
}

let client = {
    client_id:1,
    client_secret:'bhMRToP8rbAdtJd8hS36nw6jtlGyTCd47BQ8Oipt'
}

export default{
    api:api,
    client:client
}