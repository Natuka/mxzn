<template>
  <div>
    <div class="logo-wrap">
      <img class="logo" src="../../assets/logo.jpg" alt>
    </div>

    <van-cell-group class="login">
      <van-field v-model="phone" label="手机号" placeholder="请输入手机号"/>

      <van-field v-model="sms" center clearable label="短信验证码" placeholder="请输入短信验证码">
        <van-button slot="button" size="small" type="primary">发送验证码</van-button>
      </van-field>
    </van-cell-group>

    <br>
    <br>
    <van-button :loading="loading" size="large" type="primary" @click="onLogin">登录</van-button>
  </div>
</template>

<script>
export default {
  name: "mx-login",
  data() {
    return {
      phone: "",
      sms: "",
      loading: false
    };
  },
  methods: {
    onSendSms() {},
    onLogin() {
      this.loading = true;
      setTimeout(async () => {
        try {
          let data = await this.$api.login(this.phone, this.sms);
          await this.$store.dispatch("setUser", data);
          this.$router.push("/repair/list");
        } catch (e) {
        } finally {
          this.loading = false;
        }
      }, 1000);
    }
  },
  mounted() {
    this.$docTitle("登录");
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
