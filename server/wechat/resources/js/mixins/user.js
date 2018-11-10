import dayjs from "dayjs";

export default {
    computed: {
        user () {
            return this.$store.getters.user
        },
        currentDatetime () {
            return dayjs().format('YYYY-MM-DD HH:mm:ss')
        }
    }
}
