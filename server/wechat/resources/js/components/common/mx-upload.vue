<template>
  <div>
    <file-upload
      ref="upload"
      post-action="/file/doc"
      :size="1024 * 1024 * 5"
      :maximum="10"
      @input-file="inputFile"
      :input-id="inputId"
      style="display: block;text-align: inherit;"
    >
      <van-cell :title="title" :value="nameText"></van-cell>
    </file-upload>
    <van-cell>
      <van-tag class="mx-tag" v-for="(file, index) in files" :key="'key-' + file.id">
        <div style="display: flex">
          <span>{{file.name}}</span>
          <span class="mx-del" @click="remove(index)">x</span>
        </div>
      </van-tag>
    </van-cell>
  </div>
</template>

<script>
const maxSize = 1024 * 1024 * 5;
export default {
  name: "mx-upload",
  props: {
    title: {
      type: String,
      default: "文件上传"
    },
    list: {
      type: Array,
      default() {
        return [];
      }
    }
  },
  computed: {
    nameText() {
      if (!this.files.length) {
        return "请选择";
      }

      return "已选择" + this.files.length + "张";
    }
  },
  data() {
    return {
      name: "",
      files: [],
      inputId: "file-" + Date.now()
    };
  },
  methods: {
    setFiles(files) {
      this.files = files;
    },
    remove(index) {
      this.files.splice(index, 1);
      this.sync();
    },
    sync() {
      this.$emit("on-change", this.files);
    },
    inputFile(newFile, oldFile) {
      if (newFile && !oldFile) {
        // 添加文件
        console.log("newFile", newFile);
      }

      if (newFile && oldFile) {
        // 更新文件

        // 开始上传
        if (newFile.active !== oldFile.active) {
          console.log("Start upload", newFile.active, newFile);

          // 限定最小字节
          if (newFile.size >= 0 && newFile.size < maxSize) {
            // , {error: 'size'}
            newFile = this.$refs.upload.update(newFile);
          }
        }

        // 上传进度
        if (newFile.progress !== oldFile.progress) {
          console.log("progress", newFile.progress, newFile);
        }

        // 上传错误
        if (newFile.error !== oldFile.error) {
          console.log("error", newFile.error, newFile);
        }

        // 上传成功
        if (newFile.success !== oldFile.success) {
          console.log("success", newFile.success, newFile);

          console.log("newFile.response", newFile.response);

          if (newFile.response.code === 0) {
            this.name = newFile.name;
            this.files.push(newFile.response.data);
            this.sync();
          }
        }
      }

      if (!newFile && oldFile) {
        // 删除文件
        // 自动删除 服务器上的文件
        if (oldFile.success && oldFile.response.id) {
          // $.ajax({
          //   type: 'DELETE',
          //   url: '/file/delete?id=' + oldFile.response.id,
          // });
        }
      }

      // 自动上传
      if (
        Boolean(newFile) !== Boolean(oldFile) ||
        oldFile.error !== newFile.error
      ) {
        if (!this.$refs.upload.active) {
          this.$refs.upload.active = true;
        }
      }
    }
  },
  mounted() {
    this.files = this.list;
  }
};
</script>

<style scoped>
.mx-del {
  display: inline-block;
  height: 100%;
  background-color: #e3342f;
  padding: 2px 5px;
  margin-left: 10px;
  float: right;
}
.mx-tag {
  margin-right: 0.4rem;
}
</style>
