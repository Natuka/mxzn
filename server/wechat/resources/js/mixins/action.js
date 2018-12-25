export default {
    computed: {
        from() {
            return this.$route.fullPath
        }
    },
    methods: {
        // 文档
        onDocument(item) {
            this.$router.push({
                path: '/repair/document',
                query: {
                    from: this.from
                }
            })
        },
        // 处理
        onAttendance(item) {
            this.$router.push({
                path: '/repair/attendance',
                query: {
                    from: this.from
                }
            })
        },
        // 处理
        onAction(item) {
            this.$router.push({
                path: '/repair/action',
                query: {
                    from: this.$route.fullPath,
                    type: this.type === void 0 ? 0 : this.type
                }
            })
        }
    }
}
