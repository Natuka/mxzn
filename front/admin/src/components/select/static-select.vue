<template>
    <v-select
      class="v-select"
      :options="data"
      v-model="info"
      :label="label"
    >
      <div slot="option" slot-scope="option">
        <slot name="prev" :option="option"></slot>
        {{ option[label] }}
        <slot name="after"></slot>
      </div>
    </v-select>
</template>

<script>
export default {
  name: 'static-select',
  props: {
    init: {
      type: [Number, String],
      default: 0
    },
    data: {
      type: Array,
      default () {
        return []
      }
    },
    label: {
      type: String,
      default () {
        return 'name'
      }
    }
  },
  data () {
    return {
      value: 0,
      info: {}
    }
  },
  methods: {
    onChange (value) {
      this.$emit('on-change', value)
    },
    setInfo (value) {
      let info = this.data.find(info => +info.id === +value)
      if (!info) {
        return
      }
      this.info = info
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
    // 如果值有初始化时,那么也可以进行操作
    data (data) {
      if (data && data.length && this.init) {
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
