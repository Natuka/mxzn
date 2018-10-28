export default {
    methods: {
        onClickLeft () {
            const from = this.$route.query.from
            if (from) {
                this.$router.push(from)
                return
            }
            this.$router.back()
        }
    }
}
