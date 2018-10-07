import {colors} from '@/constants/color'

export default {
  methods: {
    getConstValue (value, list = []) {
      if (list.length === 0) {
        return ''
      }
      return list[value]
    },
    constWithRender (h, value, list = [], color = false) {
      let str = this.getConstValue(value, list)
      if (color) {
        return h('Tag', {
          props: {
            color: colors[value]
          }
        }, str)
      }
      return h('span', str)
    },
    // 获取渲染行数
    constRender (key, list = [], color = true) {
      return (h, {row}) => {
        return this.constWithRender(h, row[key], list, color)
      }
    }
  }
}
