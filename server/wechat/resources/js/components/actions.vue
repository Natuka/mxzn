<template>
    <van-actionsheet
        v-model="show"
        :actions="actions"
        @select="onSelect"
        cancel-text="取消"
    />
</template>

<script>
export default {
    name: "mx-actions",
    props: {
        data: {
            type: Object,
            default() {
                return {}
            }
        },
        from: {
            type: String,
            default: ''
        }
    },
    data() {
        return {
            show: false,
            actions: [
                {
                    name: '转派',
                    type: 1,
                    method: 'jump',
                    path: '/repair/change'
                },
                {
                    name: '完工',
                    type: 2,
                    method: 'confirm',
                    path: ''
                },
                {
                    name: '修改',
                    type: 3,
                    method: 'jump',
                    path: '/repair/edit'
                },
                {
                    name: '取消',
                    type: 4,
                    method: 'jump',
                    path: '/repair/cancel'
                },
                {
                    name: '配件耗材',
                    type: 5,
                    method: 'jump',
                    path: '/repair/equipment'
                },
                {
                    name: '服务项目',
                    type: 6,
                    method: 'jump',
                    path: '/repair/service'
                },
                {
                    name: '签到记录',
                    type: 7,
                    method: 'jump',
                    path: '/repair/attendance'
                },
                {
                    name: '操作日志',
                    type: 8,
                    method: 'jump',
                    path: '/repair/log'
                },
                {
                    name: '催单记录',
                    type: 9,
                    method: 'jump',
                    path: '/repair/followup'
                }
            ]
        }
    },
    methods: {
        onSelect(action) {
            this[action.method](action)
        },
        jump (action) {
            this.$store.dispatch('setServiceOrder', this.data)
            this.$router.push({
                path: action.path,
                query: {
                    from: this.from
                }
            })
        },
        popup (action) {

        },
        confirm () {
            this.$dialog.confirm({
                title: '提示',
                message: '确认完工？'
            }).then(() => {
                this.$toast('确定')
            }).catch(() => {
                this.$toast('取消了')
            })
        },
        open () {
            this.show = true
        }
    }

}
</script>

<style scoped>

</style>
