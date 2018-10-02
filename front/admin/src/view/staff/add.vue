<template>
  <custom-modal
    ref="ref"
    width="1000px"
    title="人事档案新增"
    @on-submit="onSubmit"
    @on-cancel="onCancel"
    class="mxcs-two-column"
  >
    <div>
      <Form :model="data"
            ref="addForm"
            :rules="rules"
            :label-width="90">
        <FormItem label="组织/公司" prop="org_id">
          <Select v-model="data.org_id">
            <Option value="beijing">New York</Option>
            <Option value="shanghai">London</Option>
            <Option value="shenzhen">Sydney</Option>
          </Select>
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
          <DatePicker type="date" placeholder="生日" v-model="data.birthday"></DatePicker>
        </FormItem>
        <FormItem label="部门" prop="dep_id">
          <Select v-model="data.dep_id">
            <Option value="beijing">New York</Option>
            <Option value="shanghai">London</Option>
            <Option value="shenzhen">Sydney</Option>
          </Select>
        </FormItem>
        <FormItem label="职位" prop="post">
          <Select v-model="data.post">
            <Option
              :key="info.id"
              v-for="(info) in select.post"
              :value="info.id"
              v-text="info.name"
            />
          </Select>
        </FormItem>
        <FormItem label="职务" prop="job">

          <Select v-model="data.job">
            <Option
              :key="info.id"
              v-for="(info) in select.job"
              :value="info.id"
              v-text="info.name"
            />
          </Select>
        </FormItem>
        <FormItem label="毕业院校" prop="graduated_school">
          <Input v-model="data.graduated_school" placeholder="毕业院校"></Input>
        </FormItem>
        <FormItem label="学历">
          <Select v-model="data.education">
            <Option
              :key="info.id"
              v-for="(info) in select.education"
              :value="info.id"
              v-text="info.name"
            />
          </Select>
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
          <DatePicker type="date" placeholder="入职日期" v-model="data.entry_date"></DatePicker>
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
          <DatePicker type="date" placeholder="离职日期" v-model="data.leave_date"></DatePicker>
        </FormItem>
        <FormItem label="所在省">
          <!--<Input v-model="data.province_id" placeholder="所在省"></Input>-->
          <Select v-model="data.province_id" @on-change="provinceChange">
            <Option
              :key="info.id"
              v-for="(info) in provinces"
              :value="info.id"

            >{{info.areaname}}
            </Option>
          </Select>
        </FormItem>
        <FormItem label="所在市">
          <!--<Input v-model="data.city_id" placeholder="所在市"></Input>-->
          <Select v-model="data.city_id" @on-change="cityChange">
            <Option
              :key="info.id"
              v-for="(info) in cities"
              :value="info.id"

            >{{info.areaname}}
            </Option>
          </Select>
        </FormItem>
        <FormItem label="所在县">
          <!--<Input v-model="data.district_id" placeholder="所在县"></Input>-->
          <Select v-model="data.district_id">
            <Option
              :key="info.id"
              v-for="(info) in counties"
              :value="info.id"

            >{{info.areaname}}
            </Option>
          </Select>
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

import {addStaff} from '../../api/staff'

import * as staffConst from '../../constants/staff'

export default {
  name: 'staff-add',
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
        post: '',
        job: '',
        graduated_school: '',
        education: '',
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
      educationList: staffConst.EDUCATION_LIST,
      select: {
        job: [],
        post: [],
        education: []
      }
    }
  },
  methods: {
    onSubmit (e) {
      this.$refs.addForm.validate(async (valid) => {
        if (valid) {
          try {
            let data = await addStaff(this.data)
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

      let [provinces, cities, counties] = await this.getAllByFirstProvinceId()
      this.data.province_id = 0
      this.data.city_id = 0
      this.data.district_id = 0

      this.forceLock(() => {
        this.data.province_id = provinces[0].id
        this.data.city_id = cities[0].id
        this.data.district_id = counties[0].id
      })
      return true
    },
    async provinceChange (provinceId) {
      const fn = async () => {
        let [cities, counties] = await this.getAllByProvinceId(provinceId)
        this.data.city_id = 0
        this.data.district_id = 0

        this.forceLock(() => {
          this.data.city_id = cities[0].id
          this.data.district_id = counties[0].id
        })
      }

      this.wrapLock(fn)
    },
    async cityChange (cityId) {
      const fn = async () => {
        let [counties] = await this.getAllByCityId(cityId)
        this.data.district_id = 0

        this.forceLock(() => {
          this.data.district_id = counties[0].id
        })
      }

      this.wrapLock(fn)
    }
  }
}
</script>
