<template>
  <div>
    <van-cell :title="title" @click="$refs.date.open()">
      <span v-if="!date">请选择</span>
      <span v-else v-text="date"></span>
    </van-cell>
    <mx-datetime ref="date" :on-change="handleChange"/>
  </div>
</template>

<script>
export default {
  name: "mx-datetime-picker",
  props: {
    title: {
      type: String,
      default: ""
    },
    onChange: {
      type: Function,
      default() {}
    },
    value: {
      type: String,
      default: ""
    }
  },
  data() {
    return {
      show: false,
      date: ""
    };
  },
  methods: {
    handleChange(value) {
      this.date = value;
      this.$emit("on-change", value);
    },
    setDate(date) {
      this.date = date;
    }
  },
  watch: {
    value() {
      this.date = value;
    }
  }
};
</script>

<style scoped>
</style>
