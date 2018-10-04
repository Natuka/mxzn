export default {
  methods: {
    baseRender (key = '', getterName) {
      return (h, {row}) => {
        const fn = this.$store.getters[getterName]
        let info = fn(row[key])
        if (!info) {
          return h('span', {}, '')
        }
        return h('span', {}, info.name)
      }
    }
  }
}
