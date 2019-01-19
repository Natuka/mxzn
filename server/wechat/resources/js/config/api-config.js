let config = {
    host: 'https://mp.mxhj.net/'
}

if (process.env.NODE_ENV === 'development') {
    // 'http://wx.mxcs.com/' 'https://mp.mxhj.net/'
    config.host = 'https://mp.mxhj.net/'
}

export default config
