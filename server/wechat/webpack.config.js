const webpackConfig = require('./node_modules/laravel-mix/setup/webpack.config')

module.exports = vuxLoader.merge(webpackConfig, {
    plugins: ['vux-ui']
})

// console.log('加载了')
