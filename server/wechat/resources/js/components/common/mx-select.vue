<template>
    <van-popup v-model="show" position="bottom">
        <van-picker
            show-toolbar
            :columns="columns"
            @change="handleChange"
            @confirm="onConfirm"
            @cancel="onCancel"
        />
    </van-popup>
</template>

<script>
    export default {
        name: "mx-select",
        props: {
            columns: {
                type: Array,
                default() {
                    return []
                }
            },
            onChange: {
                type: Function,
                default() {
                }
            }
        },
        data() {
            return {
                show: false
            }
        },
        methods: {
            handleChange(picker, value, index) {

            },
            onConfirm(value, index) {
                this.onChange(value, index)
                this.close()
            },
            onCancel() {
                this.close()
            },
            open() {
                this.show = true
            },
            close() {
                this.show = false
            }
        }
    }
</script>

<style scoped>

</style>
