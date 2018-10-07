export default {
  props: {
    data: {
      type: Object,
      default () {
        return {}
      }
    }
  },
  methods: {
    setUrl (data) {
      this.url = `order_flow/repair/${data.id}/attendance`
    }
  }
}
