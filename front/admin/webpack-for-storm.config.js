const path = require('path')

module.exports = {
  resolve: {
    alias: {
      '@': path.join(__dirname, 'src'),
      '_c': path.join(__dirname, 'src/components'),
      '_conf': path.join(__dirname, 'src/config')
    }
  }
}
