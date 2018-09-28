<template>
  <custom-modal
    ref="ref"
    width="1000px"
    title="客户管理-新增"
    @on-submit="onSubmit"
    @on-cancel="onCancel"
    class="mxcs-two-column"
  >
    <div>
      <Form :model="data"
            ref="addForm"
            :rules="rules"
            :label-width="80">
        <FormItem label="编号" prop="number">
          <Input v-model="data.number" placeholder="编号" disabled></Input>
        </FormItem>
        <FormItem label="姓名" prop="name">
          <Input v-model="data.name" placeholder="姓名"></Input>
        </FormItem>
        <FormItem label="简称" prop="name_short">
          <Input v-model="data.name_short" placeholder="简称"></Input>
        </FormItem>
        <FormItem label="客户类别">
          <Select v-model="data.type">
            <Option
              v-for="(type, index) in typeList"
              :key="index"
              :value="index"
            >{{type}}
            </Option>
          </Select>
        </FormItem>

        <FormItem label="所属行业">
          <Select v-model="data.industry">
            <Option
              v-for="(type, index) in industryList"
              :key="index"
              :value="index"
            >{{type}}
            </Option>
          </Select>
        </FormItem>

        <FormItem label="客户级别">
          <Select v-model="data.level">
            <Option
              v-for="(type, index) in levelList"
              :key="index"
              :value="index"
            >{{type}}
            </Option>
          </Select>
        </FormItem>

        <FormItem label="跟进状态">
          <Select v-model="data.follow_up_status">
            <Option
              v-for="(type, index) in followUpStatusList"
              :key="index"
              :value="index"
            >{{type}}
            </Option>
          </Select>
        </FormItem>

        <FormItem label="客户来源">
          <Select v-model="data.source">
            <Option
              v-for="(type, index) in sourceList"
              :key="index"
              :value="index"
            >{{type}}
            </Option>
          </Select>
        </FormItem>

        <FormItem label="人员规模">
          <Select v-model="data.staff_scale">
            <Option
              v-for="(type, index) in staffScaleList"
              :key="index"
              :value="index"
            >{{type}}
            </Option>
          </Select>
        </FormItem>

        <FormItem label="购买力">
          <Select v-model="data.purchasing_power">
            <Option
              v-for="(type, index) in purchasingPowerList"
              :key="index"
              :value="index"
            >{{type}}
            </Option>
          </Select>
        </FormItem>

        <FormItem label="下次跟进时间">
          <DatePicker type="datetime" v-model="data.follow_up_nexttime"></DatePicker>
        </FormItem>

        <FormItem label="最近联系时间">
          <DatePicker type="datetime" v-model="data.contact_lasttime"></DatePicker>
        </FormItem>

        <FormItem label="省" prop="province_id">
          <Input v-model="data.province_id" placeholder="省"></Input>
        </FormItem>

        <FormItem label="市" prop="city_id">
          <Input v-model="data.city_id" placeholder="简称"></Input>
        </FormItem>

        <FormItem label="区" prop="district_county_id">
          <Input v-model="data.district_county_id" placeholder="简称"></Input>
        </FormItem>

        <FormItem label="地址" prop="address">
          <Input v-model="data.address" placeholder="地址"></Input>
        </FormItem>

        <FormItem label="电话" prop="tel">
          <Input v-model="data.tel" placeholder="电话"></Input>
        </FormItem>

        <FormItem label="传真" prop="fax">
          <Input v-model="data.fax" placeholder="传真"></Input>
        </FormItem>

        <FormItem label="邮政编码" prop="zip_code">
          <Input v-model="data.zip_code" placeholder="邮政编码"></Input>
        </FormItem>

        <FormItem label="统一信用码" prop="ent_code">
          <Input v-model="data.ent_code" placeholder="统一信用码"></Input>
        </FormItem>

        <FormItem label="银行" prop="bank">
          <Input v-model="data.bank" placeholder="银行"></Input>
        </FormItem>

        <FormItem label="银行账号" prop="account">
          <Input v-model="data.account" placeholder="银行账号"></Input>
        </FormItem>

        <FormItem label="信用额度" prop="credit_line">
          <Input v-model="data.credit_line" placeholder="信用额度"></Input>
        </FormItem>

        <FormItem label="结算方式">
          <Select v-model="data.settle_mode">
            <Option
              v-for="(type, index) in settleModeList"
              :key="index"
              :value="index"
            >{{type}}
            </Option>
          </Select>
        </FormItem>

        <FormItem label="结算类别">
          <Select v-model="data.settle_type">
            <Option
              v-for="(type, index) in settleTypeList"
              :key="index"
              :value="index"
            >{{type}}
            </Option>
          </Select>
        </FormItem>

        <FormItem label="备注" prop="remark">
          <Input type="textarea" v-model="data.remark" placeholder="信用额度"></Input>
        </FormItem>

        <FormItem label="黑名单">
          <Select v-model="data.black_list">
            <Option
              v-for="(type, index) in blackList"
              :key="index"
              :value="index"
            >{{type}}
            </Option>
          </Select>
        </FormItem>

        <FormItem label="单据状态">
          <Select v-model="data.status">
            <Option
              v-for="(type, index) in statusList"
              :key="index"
              :value="index"
            >{{type}}
            </Option>
          </Select>
        </FormItem>

        <FormItem label="同步时间">
          <DatePicker type="datetime" v-model="data.syn_datetime"></DatePicker>
        </FormItem>
      </Form>
    </div>
  </custom-modal>
</template>

<script>

import ModalMixin from '@/mixins/modal'

import {addCustomer} from '../../api/customer'

import * as customerConst from '../../constants/customer'

export default {
  name: 'customer-add',
  mixins: [ModalMixin],
  data () {
    return {
      data: {
        erp_cust_id: 0, // ERP 客户ID
        name: '', // 客户名称
        number: '', // 客户编号
        name_short: '',
        account: '',
        bank: '',
        ent_code: '', // 企业统一信用码
        salesman_id: 0, // 业务员
        zip_code: '', // 邮政编码
        fax: '', // 传真
        tel: '', // 手机
        address: '', // 地址
        province_id: 0,
        city_id: 0,
        district_county_id: 0,
        type: 1,
        industry: 0, // 所属行业, 0 其他
        level: 0,
        follow_up_status: 0, // 跟进状态
        source: 0,
        staff_scale: 0,
        purchasing_power: 0,
        settle_mode: 0,
        settle_type: 0,
        black_list: 0,
        status: 0,
        remark: '',
        follow_up_nexttime: '',
        contact_lasttime: '',
        syn_datetime: ''
      },
      rules: {
        name: [
          {required: true, message: '名称不能为空', trigger: 'blur'}
        ],
        name_short: [
          {required: true, message: '简称不能为空', trigger: 'blur'}
        ]
      },
      industryList: customerConst.INDUSTRY_LIST,
      typeList: customerConst.TYPE_LIST,
      levelList: customerConst.LEVEL_LIST,
      followUpStatusList: customerConst.FOLLOW_UP_STATUS_LIST,
      sourceList: customerConst.SOURCE_LIST,
      staffScaleList: customerConst.STAFF_SCALE_LIST,
      purchasingPowerList: customerConst.PURCHASING_POWER_LIST,
      settleModeList: customerConst.SETTLE_MODE_LIST,
      settleTypeList: customerConst.SETTLE_TYPE_LIST,
      blackList: customerConst.BLACK_LIST,
      statusList: customerConst.STATUS_LIST
    }
  },
  methods: {
    onSubmit (e) {
      this.$refs.addForm.validate(async (valid) => {
        if (valid) {
          try {
            let data = await addCustomer(this.data)
            console.log('data', data)
            this.withRefresh(e)
          } catch (e) {
            this.closeLoading()
          }
        } else {
          this.closeLoading()
        }
      })
    },
    onCancel (e) {
      e()
    }
  }
}
</script>
