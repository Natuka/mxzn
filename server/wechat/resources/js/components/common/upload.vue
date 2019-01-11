<template>
    <file-upload
        ref="upload"
        post-action="/file/doc"
        :size="1024 * 1024 * 10"
        :maximum="10"
        @input-file="inputFile"
        style="display: block"

    >
        <van-cell :title="title" :value="name"></van-cell>
    </file-upload>
</template>

<script>
    const maxSize = 1024 * 1024 * 10;
    export default {
        name: 'mx-upload',
        props: {
            title: {
                type: String,
                default: '文件上传'
            }
        },
        data() {
            return {
                name: ''
            }
        },
        methods: {
            inputFile(newFile, oldFile) {
                if (newFile && !oldFile) {
                    // 添加文件
                    console.log('newFile', newFile)
                }

                if (newFile && oldFile) {
                    // 更新文件

                    // 开始上传
                    if (newFile.active !== oldFile.active) {
                        console.log('Start uploadyureq', maxSize, newFile.active, newFile)

                        // 限定最小字节
                        if (newFile.size >= 0 && newFile.size < maxSize) {
                            // , {error: 'size'}
                            newFile = this.$refs.upload.update(newFile)
                        }
                    }

                    // 上传进度
                    if (newFile.progress !== oldFile.progress) {
                        console.log('progress', newFile.progress, newFile)
                    }

                    // 上传错误
                    if (newFile.error !== oldFile.error) {
                        console.log('error', newFile.error, newFile)
                    }

                    // 上传成功
                    if (newFile.success !== oldFile.success) {
                        console.log('success', newFile.success, newFile)
                        this.name = newFile.name
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
                if (Boolean(newFile) !== Boolean(oldFile) || oldFile.error !== newFile.error) {
                    if (!this.$refs.upload.active) {
                        this.$refs.upload.active = true
                    }
                }
            }
        }
    };
</script>
