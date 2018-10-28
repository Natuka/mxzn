<template>
    <div>
        <van-nav-bar
            title="转派"
            left-text="返回"
            right-text=""
            left-arrow
            @click-left="onClickLeft"
            @click-right="onClickRight"
        />
        <div>改变</div>
    </div>
</template>

<script>
import backMixin from '../../mixins/back'
export default {
    mixins: [backMixin],
    methods: {
        onClickRight () {}
    }
}
</script>

<style scoped>

</style>
