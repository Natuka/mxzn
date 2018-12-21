<template>
  <Form ref="search" :model="data" :rules="ruleInline" inline>
    <FormItem prop="schType">
      <Select v-model="data.schType" style="width:90px" placeholder="工单类型">
        <Option
          v-for="(type, index) in select.type"
          :key="index"
          :value="index"
        >{{type}}
        </Option>
      </Select>
    </FormItem>
    <FormItem prop="schDegree">
      <Select v-model="data.schDegree" style="width:90px" placeholder="紧急程度">
        <Option
          v-for="(type, index) in select.degree"
          v-if="index > 0"
          :key="index"
          :value="index"
        >{{type}}
        </Option>
      </Select>
    </FormItem>
    <FormItem prop="schField">
      <Select v-model="data.schField" style="width:90px" placeholder="栏位">
        <Option value="fuzzy_query" >模糊查询</Option>
        <Option value="customer_name">客户名称</Option>
        <Option value="feedback_staff">报修人员</Option>
        <Option value="receive_staff">受理人员</Option>
        <Option value="number">服务单号</Option>
        <Option value="engineer">工程师</Option>
        <Option value="fault_desc">故障描述</Option>
      </Select>
    </FormItem>
    <FormItem prop="schValue">
      <Input type="text" v-model="data.schValue" placeholder="请填写查询内容">
      </Input>
    </FormItem>
    与
    <FormItem prop="schField2">
      <Select v-model="data.schField2" style="width:90px" placeholder="栏位">
        <Option value="fuzzy_query" >模糊查询</Option>
        <Option value="customer_name">客户名称</Option>
        <Option value="feedback_staff">报修人员</Option>
        <Option value="receive_staff">受理人员</Option>
        <Option value="number">服务单号</Option>
        <Option value="engineer">工程师</Option>
        <Option value="fault_desc">故障描述</Option>
      </Select>
    </FormItem>
    <FormItem prop="schValue2">
      <Input type="text" v-model="data.schValue2" placeholder="请填写查询内容">
      </Input>
    </FormItem>
    与
    <FormItem prop="schField3">
      <Select v-model="data.schField3" style="width:90px" placeholder="栏位">
        <Option value="fuzzy_query" >模糊查询</Option>
        <Option value="customer_name">客户名称</Option>
        <Option value="feedback_staff">报修人员</Option>
        <Option value="receive_staff">受理人员</Option>
        <Option value="number">服务单号</Option>
        <Option value="engineer">工程师</Option>
        <Option value="fault_desc">故障描述</Option>
      </Select>
    </FormItem>
    <FormItem prop="schValue3">
      <Input type="text" v-model="data.schValue3" placeholder="请填写查询内容">
      </Input>
    </FormItem>
    <FormItem>
      <Button type="primary" @click="handleSubmit('search')" :loading="loading">查询</Button>
    </FormItem>
  </Form>
</template>

<script>
  import * as orderConst from '@/constants/order_flow'
  export default {
    name: 'dispose-search',
    data () {
      return {
        data: {
          schType: '0',
          schDegree: '0',
          schField: 'customer_name',
          schValue: '',
          schField2: 'feedback_staff',
          schValue2: '',
          schField3: 'fault_desc',
          schValue3: ''
        },
        select: {
          type: orderConst.ORDER_TYPE,
          degree: orderConst.ORDER_DEGREE
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
            this.$emit('on-search', this.data)
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
