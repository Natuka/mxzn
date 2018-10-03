<template>
    <v-select
      class="v-select"
      :options="data"
      v-model="info"
      :label="label"
    ></v-select>
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
    }
  },
  data () {
    return {
      value: 0,
      label: 'name',
      info: {}
    }
  },
  methods: {
    onChange (value) {
      console.log('onChange', this)
      console.log('value', value)
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
        console.log('info.id', info.id)
        this.onChange(info.id)
        // this.$emit('on-change', info.id)
      }
    }
  }
}
</script>

<style scoped>
  .v-select{
    /*border: 1px solid #dcdee2;*/
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
