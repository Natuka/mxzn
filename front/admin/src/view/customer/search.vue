<template>
  <Form ref="search" :model="data" :rules="ruleInline" inline>
    <FormItem prop="schField">
      <Select v-model="data.schField" style="width:90px" placeholder="栏位">
        <Option value="fuzzy_query" >模糊查询</Option>
        <Option value="number">客户编号</Option>
        <Option value="name">公司名称</Option>
        <Option value="name_short">公司简称</Option>
      </Select>
    </FormItem>
    <FormItem prop="schValue">
      <Input type="text" v-model="data.schValue" placeholder="请填写查询内容">
      </Input>
    </FormItem>
    <FormItem>
      <Button type="primary" @click="handleSubmit('search')" :loading="loading">查询</Button>
    </FormItem>
  </Form>
</template>

<script>
export default {
  name: 'customer-search',
  data () {
    return {
      data: {
        schField: 'fuzzy_query',
        schValue: ''
      },
      ruleInline: {
        schValue: [
          {
            required: false,
            message: '请填写查询内容',
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
