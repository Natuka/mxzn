<template>
  <v-select
    class="v-select"
    :options="options"
    v-model="info"
    :label="label"
    @search="onSearch"
    ref="ref"
  >
    <span slot="no-options">未匹配到数据</span>
    <Spin v-show="loading" slot="spinner"></Spin>
  </v-select>
</template>

<script>
import debonce from 'lodash/debounce'
import {getApi} from '../../libs/api.request'

export default {
  name: 'remote-select',
  props: {
    // 初始化值
    init: {
      type: [Number, String],
      default: 0
    },
    // 调用url
    url: {
      type: String,
      default: ''
    },
    // 默认参数
    params: {
      type: Object,
      default () {
        return {}
      }
    },
    // 设定该值一般情况下是 v-model
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
    // 一般是匹配字段的名称
    name: {
      type: String,
      default: 'id'
    },
    // 一般是匹配字段的名称
    label: {
      type: String,
      default: 'name'
    },
    // 初始化参数，一般是数组
    initData: {
      type: Array,
      default () {
        return []
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
      value: 0,
      info: {},
      model: [],
      options: [],
      loading: false
    }
  },
  methods: {
    setInfo (value) {
      if (!value) {
        return
      }
      let name = this.name
      let info = this.options.find(info => +info[name] === +value)
      if (!info) {
        return
      }
      this.info = info
    },
    async onSearch (search, loading) {
      loading(true)
      this.loading = true
      this.search(loading, search, this)
    },
    search: debonce((loading, search, vm) => {
      // 模拟API加载
      setTimeout(async () => {
        await vm.getDataFromRemote(search)
        vm.loading = false
        loading(false)
      }, 1000)
    }, 350),
    async getDataFromRemote (query) {
      if (!query) {
        this.$emit('on-change', 0)
        return
      }
      let data = await this.getData(query)
      this.options = data
    },
    async getData (value = '') {
      let {data} = await getApi(this.url, {
        ...this.params || {},
        [this.label]: value // 以label进行查询，跟界面上的一致
      })
      console.log('data', data)
      return data.map(this.map)
    },
    onChange (value) {
      this.$emit('on-change', value)
    }
  },
  watch: {
    init (value) {
      this.setInfo(value)
    },
    info (info) {
      if (info) {
        this.onChange(info.id)
      }
    },
    // 初始化数据
    initData (data) {
      console.log('data', data)
      this.options = data || []
      if (this.options.length) {
        this.setInfo(this.init)
      }
    }
  }
}
</script>

<style scoped>
  .v-select{
  }
  .v-select >>> .dropdown-toggle{
    height: 32px;
    border: 1px solid #dcdee2;
  }

  .v-select.open >>> .dropdown-toggle{
    border-color: #57a3f3;
    outline: 0;
    -webkit-box-shadow: 0 0 0 2px rgba(45, 140, 240, 0.2);
    box-shadow: 0 0 0 2px rgba(45, 140, 240, 0.2);
  }

</style>
