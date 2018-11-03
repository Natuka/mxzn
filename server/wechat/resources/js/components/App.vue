<template>
    <div>
        <router-view></router-view>
    </div>
</template>

<script>
export default {
    data() {
        return {
            count: 0,
            isLoading: false
        }
    },

    methods: {
        onRefresh() {
            setTimeout(() => {
                this.$toast('刷新成功');
                this.isLoading = false;
                this.count++;
            }, 500);
        }
    },
    // 加载微信，在这边进行初始化
    async mounted() {
        let data = await this.$api.getWXConfig()
        console.log('data', data)
        let res = await this.$wx.configAsync(data)
        console.log('res', res)
        this.$store.dispatch('init')
    }
}
</script>
