<template>
  <div>
    <Row :gutter="20">
      <i-col span="12">
        <Card title="" shadow>
          <img class="qq-group-img" :src="qqFans" alt="">
          <p class="qq-group-intro"></p>
        </Card>
      </i-col>
    </Row>
  </div>
</template>

<script>
import qqFans from '@/assets/images/qq-fance.jpg'
export default {
  name: 'join_page',
  data () {
    return {
      qqFans
    }
  }
}
</script>

<style>
.qq-group-img{
  display: block;
  margin: 0 auto;
  width: 240px;
}
.qq-group-intro{
  padding: 20px;
  font-size: 16px;
}
</style>
