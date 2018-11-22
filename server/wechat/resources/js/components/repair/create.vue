<template>
    <div>
        <van-nav-bar
            title="服务单提交"
            left-text="返回"
            right-text="按钮"
            left-arrow
            @click-left="onClickLeft"
            @click-right="onClickRight"
        />
        <van-cell-group>
            <van-cell title="服务类别" >
                <select name="">
                    <option 
                        :key="key"
                        v-for="(value, key) in orderTypes"
                        :value="key"
                        v-text="value"
                    ></option>
                </select>
            </van-cell>
            <van-cell title="紧急程度" >
                <select name="">
                    <option 
                        :key="key"
                        v-for="(value, key) in orderDegree"
                        :value="key"
                        v-text="value"
                    ></option>
                </select>
            </van-cell>
            <van-cell title="客户名称" value="小米"/>

            <!-- <van-cell title="服务级别"  value="GD-12173237-2323"/> -->
            <van-cell title="地址"  value="GD-12173237-2323"/>
            <van-field
                v-model="data.customer.address"
                label="地址"
                type="textarea"
                placeholder="地址"
                rows="3"
                :autosize="{ maxHeight: 100, minHeight: 50 }"
            />

            <!-- <van-cell title="服务类别" is-link value="GD-12173237-2323"/>
            <van-cell title="受理方式" is-link value="GD-12173237-2323"/>
            <van-cell title="受理时间" is-link value="GD-12173237-2323"/>
            <van-cell title="受理人" is-link value="GD-12173237-2323">
                <span class="mx-text-danger" slot="title">受理人</span>
            </van-cell>
            <van-cell title="服务号" is-link value="GD-12173237-2323">
                <span class="mx-text-danger" slot="title">客户名称</span>
            </van-cell>
            <van-cell title="报修人" is-link value="GD-12173237-2323"/>
            <van-cell title="报修电话" is-link value="GD-12173237-2323"/>
            <van-cell title="联系地址" is-link value="GD-12173237-2323"/>
            <van-cell title="所属区域" is-link value="GD-12173237-2323"/>
            <van-cell title="技术员" is-link value="GD-12173237-2323"/> -->
        </van-cell-group>

        <van-collapse v-model="equipment" class="mt-20">
            <van-collapse-item title="机器信息" name="equipment">
                <van-cell-group>
                    <van-cell title="设备编号"  :value="data.equipment.number"/>
                    <van-cell title="型号规格" :value="data.equipment.model"/>
                    <van-cell title="合同编号" :value="data.equipment.contract_number"/>
                    <van-cell title="类别" :value="data.equipment.type"/>
                    <van-cell title="安装时间" :value="data.equipment.installation_date"/>
                </van-cell-group>

            </van-collapse-item>
        </van-collapse>

        <van-collapse v-model="fault" class="mt-20">
            <van-collapse-item title="故障信息" name="fault">
               <van-cell-group>
                    <van-field
                        v-model="data.fault.desc"
                        label="故障描述"
                        type="textarea"
                        placeholder="故障描述"
                        rows="3"
                        autosize="{ maxHeight: 100, minHeight: 50 }"
                    />
                    <van-field 
                         label="故障代码"
                        v-model="data.fault.code" placeholder="故障代码" />
                    <van-cell title="故障类型" >
                        <select v-model="data.fault.type">
                            <option 
                                :key="key"
                                v-for="(value, key) in orderDegree"
                                :value="key"
                                v-text="value"
                            ></option>
                        </select>
                    </van-cell>
                    <van-cell title="故障频率" >
                        <select v-model="data.fault.sequence">
                            <option 
                                :key="key"
                                v-for="(value, key) in sequenceType"
                                :value="key"
                                v-text="value"
                            ></option>
                        </select>
                    </van-cell>
                    <van-cell title="线路是否破损">
                        <select v-model="data.fault.is_line_broken">
                            <option 
                                :key="key"
                                v-for="(value, key) in lineBroken"
                                :value="key"
                                v-text="value"
                            ></option>
                        </select>
                    </van-cell>
                    <van-cell title="部品是否损坏" >
                        <select v-model="data.fault.is_part_broken">
                            <option 
                                :key="key"
                                v-for="(value, key) in partBroken"
                                :value="key"
                                v-text="value"
                            ></option>
                        </select>
                    </van-cell>
                    <van-cell title="故障附件" >
                        <van-uploader :after-read="onRead" accept="image/gif, image/jpeg" multiple>
                            <van-icon name="photograph" />
                        </van-uploader>
                    </van-cell>
                </van-cell-group>

            </van-collapse-item>
        </van-collapse>


        <van-button @click="onSubmit" type="primary" size="large">提交</van-button>

        <!-- <mx-actions ref="action" :data="data" :from="$route.fullPath"></mx-actions> -->

    </div>

</template>

<script>
import backMixin from '../../mixins/back'
import Action from '../actions'
import actionMixin from '../../mixins/action'
import dayjs from 'dayjs'
const currentDate = dayjs().format('YYYY-MM-DD HH:mm:ss')
import {
  ORDER_TYPE,
  ORDER_STATUS,
  ORDER_DEGREE,
  SEQUENCE_TYPE,
  FAULT_TYPE,
  LINE_BROKEN,
  PART_BROKEN
} from '../../const/repair'

export default {
  name: 'mx-detail',
  components: {
    [Action.name]: Action
  },
  mixins: [backMixin, actionMixin],
  data() {
    return {
      equipment: ['equipment'],
      fault: ['fault'],
      activeNames: [1],
      data: {
        attach_ids: '',
        customer_id: 0,
        feedback_staff_id: 0,
        receive_staff_id: 0,
        confirm_staff_id: 0,
        emergency_degree: 0,
        number: '',
        mobile: '',
        feedback_at: '',
        receive_at: currentDate,
        confirm_at: '',
        plan_out_at: '',
        plan_finish_at: '',
        is_out: 0,
        is_charge: 0, // 是否服务收费
        is_quote: 0, // 是否报价
        settle_status: 0,
        status: 0,
        source: 0,
        type: 3, // 维修工单
        level: 0,
        address: '',
        remark: '',
        engineers: [],
        engineer_ids: [], // 工程师列表
        machine_id: 0,
        customer: {
          id: 0,
          erp_cust_id: 0,
          number: '',
          name_short: '',
          industry: '',
          name: '',
          address: '',
          type: 0,
          level: 0,
          follow_up_status: 0,
          source: 0,
          staff_scale: 0,
          purchasing_power: 0
        },
        equipment: {
          type: 0,
          model: '',
          installation_staff: '',
          technology_staff: '',
          number: '',
          sets: '',
          main_no: '',
          control_box_no: '',
          welding_machine_no: '',
          welding_machine_model: '',
          axis1_no: '',
          axis2_no: '',
          axis3_no: '',
          axis4_no: '',
          axis5_no: '',
          axis6_no: '',
          code_chinese: '',
          identification_code: '',
          manufacture_date: '',
          purchase_date: '',
          installation_date: '',
          acceptance_date: '',
          warranty_date: '',
          maintenance_times: '',
          remark: '',
          contract_number: '',
          name: '',
          code_id: 0
        },
        fault: {
          type: 0, // 故障类型
          sequence: 0, // 故障频率
          is_line_broken: 0, // 线路是否破损
          is_part_broken: 0, // 部品是否损坏
          desc: '',
          code: '', // 故障代码
          file: '', // 故障附件
          remark: '' // 备注
        }
      },
      orderTypes: ORDER_TYPE,
      orderStatus: ORDER_STATUS,
      orderDegree: ORDER_DEGREE,
      faultType: FAULT_TYPE,
      sequenceType: SEQUENCE_TYPE,
      lineBroken: LINE_BROKEN,
      partBroken: PART_BROKEN
    }
  },
  methods: {
    onClickLeft() {
      Toast('返回')
    },
    onClickRight() {
      Toast('按钮')
    },
    onMore(item) {
      this.data = item
      this.$refs['action'].open()
    },
    onSubmit() {
      console.log('on submit')
      this.$toast.success('submited')
    },
    onRead() {
      console.log('upload')
    }
  }
}
</script>

<style scoped>
</style>
