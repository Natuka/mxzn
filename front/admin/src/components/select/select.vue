<template>
    <Select
      ref="select"
      v-model="model"
      filterable
      :loading="loading"
      clearable
      @on-query-change="getDataFromRemote"
      @on-change="onChange"
    >
      <Option
        v-for="(option, index) in options"
        :value="valueMap(option)"
        :key="index"
      >{{filter(option)}}</Option>
    </Select>
</template>

<script>
import {getApi} from '../../libs/api.request'
export default {
  name: 'mx-select',
  props: {
    url: {
      type: String,
      default: ''
    },
    params: {
      type: Object,
      default () {
        return {}
      }
    },
    value: {
      type: [Object, String, Array, Number],
      default () {
        return ''
      }
    },
    valueMap: {
      type: [Function],
      default (data) {
        return data.id
      }
    },
    name: {
      type: String,
      default: 'name'
    },
    init: {
      type: Boolean,
      default () {
        return false
      }
    },
    filter: {
      type: Function,
      default () {
        return (option) => {
          return option.label
        }
      }
    },
    map: {
      type: Function,
      default (data) {
        return data
      }
    }
  },
  data () {
    return {
      model: [],
      options: [],
      loading: false
    }
  },
  methods: {
    async getDataFromRemote (query) {
      this.loading = true
      if (!query) {
        this.loading = false
        this.$emit('on-change', 0)
        this.$refs.select.clearSingleSelect()
        return
      }

      let data = await this.getData(query)
      this.options = data

      this.loading = false
    },
    async getData (value = '') {
      let {data} = await getApi(this.url, {
        ...this.params || {},
        [this.name]: value
      })
      console.log('data', data)
      return data.map(this.map)
    },
    onChange (value) {
      this.$emit('on-change', value)
    },
    // 初始化数据
    async initData () {
      let data = await this.getData()
    }
  },
  async mounted () {
  },
  watch: {
    value (value) {
      console.log('change value', value)
    },
    model (value) {
      console.log('model', value)
    }
  }
}
</script>

<style scoped>

</style>
