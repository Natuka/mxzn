<template>
  <Form ref="search" :model="data" :rules="ruleInline" inline>
    <FormItem prop="name">
      <Input type="text" v-model="data.name" placeholder="请填写名称">
      </Input>
    </FormItem>
    <FormItem>
      <Button type="primary" @click="handleSubmit('search')" :loading="loading">查询</Button>
    </FormItem>
  </Form>
</template>

<script>
export default {
  name: 'job-search',
  data () {
    return {
      data: {
        name: ''
      },
      ruleInline: {
        name: [
          {
            required: true,
            message: '请填写名称',
            trigger: 'blur'
          }
        ]
      },
      loading: false
    }
  },
  methods: {
    async handleSubmit (name) {
      this.$refs[name].validate(valid => {
        if (valid) {
          this.loading = true
          this.$emit('on-search', JSON.parse(JSON.stringify(this.data)))
        } else {
          // this.$Message.error('查询失败')
        }
      })
    },
    closeLoading () {
      this.loading = false
    }
  }
}
</script>
