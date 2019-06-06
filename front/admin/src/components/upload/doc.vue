<template>
  <div>
    <table border="0" cellpadding="0" cellspacing="0">
      <tbody>
      <tr>
        <td v-if="list.length">
          <Button v-for="(info, index) in list" class="uploaded-file">
            <a v-bind:href="getThisUrl(info)" target="_blank">
              <img v-if="info.type === '1xxx'" data-v-f5c47720="" width="100" v-bind:src="getThisUrl(info)" v-bind:alt="info.source_name">
              <span v-else>{{info.source_name}}</span>
            </a>
            <Icon type="md-close-circle" size="20" title="删除" @click="remove(index, info)"/>
          </Button>
        </td>
        <td class="upload">
          <Upload
            ref="upload"
            :action="url"
            :headers="headers"
            name="file"
            :show-upload-list="false"
            :on-success="handleSuccess"
            :on-error="handleError"
          >
            <Button icon="ios-cloud-upload-outline">选择附件</Button>
          </Upload>
        </td>
      </tr>
      </tbody>
    </table>
  </div>
</template>

<script>

import config from '@/config/index'
import {withHeaders} from '@/libs/api.request'

const baseUrl = process.env.NODE_ENV === 'development' ? config.baseUrl.dev : config.baseUrl.pro

export default {
  name: 'mx-upload-doc',
  props: {
    multi: {
      type: Boolean,
      default: false
    }
  },
  data () {
    return {
      // url: `${baseUrl}/file/image`,
      url: `${baseUrl}/file/doc`,
      list: []
    }
  },
  computed: {
    headers () {
      return withHeaders({})
    }
  },
  methods: {
    handleSuccess ({data, code, message}, file) {
      this.removeAll()
      console.log(data, code, message)
      if (code === 1) {
        return this.$Notice.error(message)
      }
      // 删除
      if (!this.multi) {
        this.list = []
      }
      this.list.push({
        ...data
      })

      this.$emit('on-change', this.list)
    },
    handleError () {
    },
    removeAll () {
      while (this.$refs.upload.fileList.length) {
        this.$refs.upload.fileList.splice(0, 1)
      }
    },
    remove (index) {
      this.list.splice(index, 1)
      this.$emit('on-change', this.list)
    },
    getThisUrl (info) {
      let linkUrl = 'https://mp.mxhj.net/fileBack/image/?id='
      if (+info.up_from === 1) {
        linkUrl = 'https://api.mxhj.net/fileBack/image/?id='
      }
      linkUrl = linkUrl + info.id + '&amp;time=' + info.created_at + '&amp;filename=' + info.name + '&amp;source_name' + info.source_name
      return linkUrl
    },
    initData (list = []) {
      this.list = list
    }
  }
}
</script>

<style scoped>
  .uploaded-file {
    margin-right: 20px;
  }

  .upload {
    margin-left: 20px;
  }
</style>
