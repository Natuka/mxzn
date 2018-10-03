export default {
  methods: {
    getConstValue (value, list = []) {
      if (list.length === 0) {
        return ''
      }
      return list[value]
    },
    constWithRender (h, value, list = []) {
      let str = this.getConstValue(value, list)
      return h('span', str)
    },
    // 获取渲染行数
    constRender (key, list = []) {
      return (h, {row}) => {
        return this.constWithRender(h, row[key], list)
      }
    }
  }
}
