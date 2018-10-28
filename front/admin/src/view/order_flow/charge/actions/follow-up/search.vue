<template>
  <Form ref="search" :model="data" :rules="ruleInline" inline>
    <FormItem prop="user">
      <Input type="text" v-model="data.user" placeholder="Username">
      </Input>
    </FormItem>
    <FormItem prop="password">
      <Input type="text" v-model="data.password" placeholder="Password">
      </Input>
    </FormItem>
    <FormItem>
      <Button type="primary" @click="handleSubmit('search')" :loading="loading">查询</Button>
    </FormItem>
  </Form>
</template>

<script>
export default {
  name: 'followup-search',
  data () {
    return {
      data: {
        user: '',
        password: ''
      },
      ruleInline: {
        user: [
          {
            required: true,
            message: 'Please fill in the user name',
            trigger: 'blur'
          }
        ],
        password: [
          {
            required: true,
            message: 'Please fill in the password.',
            trigger: 'blur'
          },
          {
            type: 'string',
            min: 6,
            message: 'The password length cannot be less than 6 bits',
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
          this.$emit('on-search', this.data)
        } else {
          this.$Message.error('Fail!')
        }
      })
    },
    closeLoading () {
      this.loading = false
    }
  }
}
</script>
