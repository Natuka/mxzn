<template>
  <div>
    <van-cell title="服务工程师" @click="hanleEngineer">
      <span>请选择</span>
    </van-cell>
    <van-cell v-if="engineers.length">
      <van-tag class="mx-tag" v-for="(engineer, index) in engineers" :key="'key-' + engineer.id">
        <div style="display: flex;">
          <span>{{engineer.staff_name}}</span>
          <span class="mx-del" @click="remove(index)">x</span>
        </div>
      </van-tag>
    </van-cell>
  </div>
</template>

<script>
export default {
  name: "mx-engineer",
  data() {
    return {};
  },
  computed: {
    engineers() {
      return this.$store.getters.engineers;
    }
  },
  methods: {
    hanleEngineer() {
      this.$router.push("/select/engineer");
    },
    remove(index) {
      this.$store.commit("removeEngineer", index);
    }
  }
};
</script>

<style scoped>
.mx-del {
  display: inline-block;
  height: 100%;
  background-color: #e3342f;
  padding: 2px 5px;
  margin-left: 10px;
  float: right;
}
.mx-tag {
  margin-right: 0.4rem;
}
</style>
