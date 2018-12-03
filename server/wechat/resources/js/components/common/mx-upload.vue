<template>
  <div>
    <van-uploader :after-read="onRead" accept="*/*, image/jpeg" multiple>
      <van-icon name="photograph"/>
    </van-uploader>
    <div>
      <van-row>
        <van-col span="6" :key="key" v-for="(el , key) in list" @click.native="handleView(el)">
          <img :src="el.content" alt class="image">
        </van-col>
      </van-row>
      <!-- <span :key="key" v-for="(el , key) in list" @click="handleView(el)" class="image-wap">
        <img :src="el.content" alt class="image">
      </span>-->
    </div>
  </div>
</template>

<script>
import { ImagePreview } from "vant";
export default {
  name: "mx-upload",
  data() {
    return {
      list: []
    };
  },
  methods: {
    onRead(file) {
      console.log("file", file);
      this.list.push(file);
    },
    handleView({ content }) {
      ImagePreview([content]);
    }
  }
};
</script>

<style scoped>
.image-wap {
  width: 80px;
  height: 80px;
  display: flex;
  border: 1px solid #ccc;
  margin-right: 20px;
}

.image {
  max-width: 80px;
  max-height: 80px;
}
</style>


