export default {
    computed: {
        from() {
            return this.$route.fullPath
        }
    },
    methods: {
        // 文档
        onDocument(item) {
            this.$store.commit('set_service_order', item)
            this.$router.push({
                path: '/repair/document',
                query: {
                    from: this.from
                }
            })
        },
        // 处理
        onAttendance(item) {
            this.$store.commit('set_service_order', item)
            this.$router.push({
                path: '/repair/attendance',
                query: {
                    from: this.from
                }
            })
        },
        // 处理
        onAction(item) {
            this.$store.commit('set_service_order', item)
            if (+item.type === 3) {
                this.$router.push({
                    path: '/repair/action',
                    query: {
                        from: this.$route.fullPath,
                        type: this.type === void 0 ? 0 : this.type
                    }
                })
            } else {
                this.$router.push({
                    path: '/repair/action2',
                    query: {
                        from: this.$route.fullPath,
                        type: this.type === void 0 ? 0 : this.type
                    }
                })
            }
        }
    }
}
