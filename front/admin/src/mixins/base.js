export default {
  methods: {
    baseRender (key = '', getterName) {
      return (h, {row}) => {
        console.log('getterName', getterName)
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
