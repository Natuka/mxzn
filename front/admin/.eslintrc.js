module.exports = {
  root: true,
  "parserOptions": {
    "parser": "babel-eslint",
  },
  'extends': [
    'plugin:vue/essential',
    '@vue/standard'
  ],
  rules: {
    "eslint.autoFixOnSave": true,
    'space-before-function-paren': 0,
    // allow async-await
    'generator-star-spacing': 'off',
    // allow debugger during development
    'no-debugger': process.env.NODE_ENV === 'production' ? 'error' : 'off',
    'vue/no-parsing-error': [2,{ 'x-invalid-end-tag': false }],
    'no-undef': 'off'
  }
}
