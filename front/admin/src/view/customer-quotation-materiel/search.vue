<template>
  <Form ref="search" :model="data" :rules="ruleInline" inline>
    <FormItem prop="schField">
      <Select v-model="data.schField" style="width:90px" placeholder="栏位">
        <Option value="number">料号</Option>
        <Option value="name">品名</Option>
        <Option value="model">型号规格</Option>
        <Option value="billno">报价单号</Option>
        <Option value="cust_id">客户名称</Option>
        <Option value="contacts">联系人</Option>
        <Option value="mobile">手机</Option>
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
  name: 'quotation-materiel-search',
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
