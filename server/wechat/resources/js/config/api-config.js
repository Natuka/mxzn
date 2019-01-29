let config = {
    host: 'http://wx.mxcs.com/'
}

if (process.env.NODE_ENV === 'development') {
    // 'http://wx.mxcs.com/' 'https://mp.mxhj.net/'
    config.host = 'http://wx.mxcs.com/'
}

export default config
