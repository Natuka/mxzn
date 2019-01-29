export default {
    methods: {
        onClickLeft() {
            const from = this.$route.query.from
            if (from) {
                this.$router.push(from)
                return
            }
            this.$router.back()
        },
        onClickRight(id = 0) {
            // console.log('43214324', id)
            if (id) {
                this.$router.push({
                    path: '/repair/create',
                    query: {
                        id: id
                    }
                })
                return
            } else {
                // 提示设备ID找不到
                this.$router.back()
            }
        }
    }
}
