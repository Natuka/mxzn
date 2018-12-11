<template>
  <div>
    <div class="logo-wrap">
      <img class="logo" src="../../assets/logo.jpg" alt>
    </div>

    <van-cell-group class="login">
      <van-field v-model="mobile" label="手机号" placeholder="请输入手机号"/>

      <!-- <van-field
                v-model="sms"
                center
                clearable
                label="短信验证码"
                placeholder="请输入短信验证码"
            >
                <van-button slot="button" size="small" type="primary">发送验证码</van-button>
      </van-field>-->
    </van-cell-group>

    <br>
    <br>
    <van-button :loading="loading" size="large" type="primary" @click="onLogin">绑定</van-button>
  </div>
</template>

<script>
export default {
  name: "mx-bind",
  data() {
    return {
      mobile: "",
      sms: "",
      loading: false
    };
  },
  methods: {
    onSendSms() {},
    async onLogin() {
      if (!this.mobile) {
        alert("请输入手机号");
        return;
      }

      if (!/^1\d{10}$/.test(this.mobile)) {
        alert("手机号格式不正确");
        return;
      }

      this.loading = true;
      try {
        await this.$api.bindMobile(this.mobile);
        this.$router.push(this.$route.query.redirect || "/repair/list");
        this.loading = false;
      } catch (e) {
        this.loading = false;
      }
    }
  }
};
</script>

<style scoped>
.logo-wrap {
  text-align: center;
  padding-top: 100px;
}
.logo {
  width: 80%;
  /*margin-top: 100px;*/
  /*margin-bottom: 100px;*/
}
.login {
  margin-top: 20%;
}
</style>
