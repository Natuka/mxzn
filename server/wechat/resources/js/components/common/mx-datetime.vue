<template>
  <van-popup v-model="show" position="bottom">
    <van-datetime-picker
      :min-date="minDate"
      :max-date="maxDate"
      v-model="currentDate"
      show-toolbar
      @change="handleChange"
      @confirm="onConfirm"
      @cancel="onCancel"
    />
  </van-popup>
</template>

<script>
import dayjs from "dayjs";
export default {
  name: "mx-datetime",
  props: {
    minDate: {
      type: Date,
      default() {
        return new Date(1900, 1, 1);
      }
    },
    maxDate: {
      type: Date,
      default() {
        return new Date(2100, 1, 1);
      }
    },
    columns: {
      type: Array,
      default() {
        return [];
      }
    },
    onChange: {
      type: Function,
      default() {}
    }
  },
  data() {
    return {
      show: false,
      currentDate: ""
    };
  },
  methods: {
    handleChange(picker, value, index) {},
    onConfirm(value, index) {
      this.onChange(dayjs(value).format("YYYY-MM-DD HH:mm:ss"), value);
      this.close();
    },
    onCancel() {
      console.log("on cancel");
      this.close();
    },
    open() {
      this.show = true;
    },
    close() {
      this.show = false;
      console.log("this.show", this.show);
    }
  }
};
</script>

<style scoped>
</style>
