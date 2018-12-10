let config = {
    host: 'https://mp.mxhj.net/'
}

if (process.env.NODE_ENV === 'development') {
    config.host = 'http://wx.mxcs.com/'
}

export default config
