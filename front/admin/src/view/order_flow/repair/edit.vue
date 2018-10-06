<template>
  <custom-modal
    ref="ref"
    width="1000px"
    title="工單維護-修改"
    @on-submit="onSubmit"
    @on-cancel="onCancel"
    class="mxcs-two-column"
  >
    <div>
      <Form :model="data"
            ref="addForm"
            :rules="rules"
            :label-width="90"
      >
        <FormItem label="组织/公司" prop="org_id">
          <remote-select
            :init="data.org_id"
            :initData="init.organization"
            label="name"
            url="select/organization"
            :filter="(data) => data.name"
            :valueMap="(data) => data.id"
            @on-change="id => this.data.org_id = id"
          ></remote-select>

        </FormItem>
        <FormItem label="编号" prop="number">
          <Input v-model="data.number" placeholder="编号" disabled></Input>
        </FormItem>
        <FormItem label="姓名" prop="name">
          <Input v-model="data.name" placeholder="姓名"></Input>
        </FormItem>
        <FormItem label="性别">
          <RadioGroup v-model="data.sex">
            <Radio :label="1">
              <Icon type="md-male"></Icon>
              <span>男</span>
            </Radio>
            <Radio :label="0">
              <Icon type="md-female"></Icon>
              <span>女</span>
            </Radio>
          </RadioGroup>
        </FormItem>
        <FormItem label="出生日期" prop="birthday">
          <DatePicker
            type="date"
            placeholder="生日"
            v-model="data.birthday"
            @on-change="date => this.data.birthday = date"
          ></DatePicker>
        </FormItem>
        <FormItem label="部门" prop="dep_id">
          <static-select
            :data="select.department"
            :init="data.dep_id"
            @on-change="(value) => this.data.dep_id = value"
          ></static-select>
        </FormItem>
        <FormItem label="职位" prop="post">
          <static-select
            :data="select.post"
            :init="data.post"
            @on-change="(value) => this.data.post = value"
          ></static-select>
        </FormItem>
        <FormItem label="职务" prop="job">
          <static-select
            :init="data.job"
            label="name"
            :data="select.job"
            @on-change="(value) => this.data.job = value"
          ></static-select>

        </FormItem>
        <FormItem label="毕业院校" prop="graduated_school">
          <Input v-model="data.graduated_school" placeholder="毕业院校"></Input>
        </FormItem>
        <FormItem label="学历">
          <static-select
            :data="select.education"
            :init="data.education"
            @on-change="(value) => this.data.education = value"
          ></static-select>
        </FormItem>
        <FormItem label="技能专长" prop="skill_expertise">
          <Input v-model="data.skill_expertise" placeholder="技能专长"></Input>
        </FormItem>
        <FormItem label="兴趣爱好" prop="hobby">
          <Input v-model="data.hobby" placeholder="兴趣爱好"></Input>
        </FormItem>
        <FormItem label="手机" prop="mobile">
          <Input v-model="data.mobile" placeholder="手机"></Input>
        </FormItem>
        <FormItem label="邮箱" prop="email">
          <Input v-model="data.email" placeholder="邮箱"></Input>
        </FormItem>
        <FormItem label="入职日期" prop="entry_date">
          <DatePicker
            type="date"
            placeholder="入职日期"
            v-model="data.entry_date"
            @on-change="date => this.data.entry_date = date"
          ></DatePicker>
        </FormItem>
        <FormItem label="在职状态">
          <RadioGroup v-model="data.status">
            <Radio :label="1">
              <span>在职</span>
            </Radio>
            <Radio :label="0">
              <span>离职</span>
            </Radio>
          </RadioGroup>
        </FormItem>
        <FormItem label="离职日期" prop="leave_date">
          <DatePicker
            type="date"
            placeholder="离职日期"
            v-model="data.leave_date"
            @on-change="date => this.data.leave_date = date"
          ></DatePicker>
        </FormItem>
        <FormItem label="所在省">
          <static-select
            :init="data.province_id"
            label="areaname"
            :data="provinces"
            @on-change="provinceChange"
          ></static-select>
        </FormItem>
        <FormItem label="所在市">
          <static-select
            :init="data.city_id"
            label="areaname"
            :data="cities"
            @on-change="cityChange"
          ></static-select>
        </FormItem>
        <FormItem label="所在县">
          <static-select
            :init="data.district_id"
            label="areaname"
            :data="counties"
            @on-change="countyChange"
          ></static-select>
        </FormItem>
        <FormItem label="详细地址">
          <Input v-model="data.address" placeholder="详细地址"></Input>
        </FormItem>
        <FormItem label="备注">
          <Input v-model="data.remark" type="textarea" :autosize="{minRows: 2,maxRows: 5}"
                 placeholder="备注..."></Input>
        </FormItem>

        <FormItem label="建立人员">
          <Input v-model="data.created_by" placeholder="建立人员" disabled></Input>
        </FormItem>
        <FormItem label="建立日期">
          <Input v-model="data.created_at" placeholder="建立日期" disabled></Input>
        </FormItem>
        <FormItem label="最近修改人员">
          <Input v-model="data.updated_by" placeholder="最近修改人员" disabled></Input>
        </FormItem>
        <FormItem label="最近修改日期">
          <Input v-model="data.updated_at" placeholder="最近修改日期" disabled></Input>
        </FormItem>

      </Form>
    </div>
  </custom-modal>
</template>

<script>

import ModalMixin from '@/mixins/modal'
import AreaMixin from '@/mixins/area'

import {updateRepair} from '../../../api/order_flow/repair'
import {selectOrganization} from '../../../api/select/organization'
import {selectDepartment} from '../../../api/select/department'

import * as orderConst from '../../../constants/order_flow'

export default {
  name: 'repair-edit',
  mixins: [ModalMixin, AreaMixin],
  data () {
    return {
      data: {
        org_id: 0,
        number: '',
        name: '',
        sex: 1,
        birthday: '',
        dep_id: 0,
        post: 0,
        job: 0,
        graduated_school: '',
        education: 0,
        skill_expertise: '',
        hobby: '',
        mobile: '',
        email: '',
        entry_date: '',
        status: 1,
        leave_date: '',
        province_id: 0,
        city_id: 0,
        district_id: 0,
        address: '',
        remark: ''
      },
      rules: {
        name: [
          {required: true, message: '姓名不能为空', trigger: 'blur'}
        ]
      },
      educationList: orderConst.EDUCATION_LIST,
      select: {
        job: [],
        post: [],
        education: []
      },
      init: {
        organization: []
      }
    }
  },
  methods: {
    onSubmit (e) {
      this.$refs.addForm.validate(async (valid) => {
        if (valid) {
          try {
            let data = await updateRepair(this.data, this.data.id)
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
    },
    async beforeOpen () {
      let job = await this.$store.dispatch('getJob')
      let post = await this.$store.dispatch('getPost')
      let education = await this.$store.dispatch('getEducation')
      this.select.job = job
      this.select.post = post
      this.select.education = education

      return true
    },
    async afterOpen () {
      let data = this.data
      // 省份
      await this.getAllByIds(data.province_id, data.city_id, data.district_id)

      let {job, post, education} = this.data
      this.data.job = 0
      this.data.post = 0
      this.data.education = 0

      let organizations = await selectOrganization({id: data.org_id})
      this.init.organization = organizations.data

      await this.organizationChange(data.org_id)

      this.data.job = job
      this.data.post = post
      this.data.education = education
      return true
    },
    async organizationChange (id) {
      this.data.org_id = id
      if (!id) {
        return
      }
      let {data} = await selectDepartment(id)
      this.select.department = data || []
      if (data.length) {
        let info = data.find(info => +info.id === +this.data.dep_id)
        if (!info) {
          this.data.dep_id = data[0].id
        }
      }
    },
    async provinceChange (provinceId) {
      if (+this.data.province_id !== +provinceId) {
        this.data.province_id = provinceId
        let cities = await this.getCities(provinceId)
        if (!this.hasArea(cities, this.data.city_id)) {
          this.cityChange(cities[0].id)
        }
      }
    },
    async cityChange (cityId) {
      if (+cityId !== this.data.city_id) {
        this.data.city_id = cityId
        let counties = await this.getCountie(cityId)
        if (counties.length) {
          this.data.district_id = counties[0].id
        }
      }
    },
    async countyChange (countyId) {
      this.data.district_id = countyId
    }
  }
}
</script>
