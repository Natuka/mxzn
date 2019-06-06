<template>
  <custom-modal
    ref="ref"
    width="1000px"
    title="知识-新增"
    @on-submit="onSubmit"
    @on-cancel="onCancel"
    class="mxcs-three-column"
  >
    <div>
      <Form :model="data"
            ref="addForm"
            :rules="rules"
            :label-width="100">

        <FormItem label="主题:" prop="subject_name">
          <Input v-model="data.subject_name" placeholder="主题"></Input>
        </FormItem>

        <FormItem label="类别:" prop="type">
          <Select v-model="data.type">
            <Option
              v-for="(type, index) in typeList"
              :key="index"
              :value="index"
            >{{type}}
            </Option>
          </Select>
        </FormItem>

        <FormItem label="子类别:" prop="type1">
          <Select v-model="data.type1">
            <Option
              v-for="(type, index) in type1List"
              :key="index"
              :value="index"
            >{{type}}
            </Option>
          </Select>
        </FormItem>

        <FormItem label="标签:" prop="label">
          <Input v-model="data.label" placeholder="标签"></Input>
        </FormItem>

        <FormItem label="下载量:" prop="downloads">
          <Input v-model="data.downloads" placeholder="下载量"></Input>
        </FormItem>

        <FormItem label="附件名">
          <Input v-model="data.attach_file" type="textarea" :autosize="{minRows: 2,maxRows: 5}"
                 placeholder="附件名..." readonly="true"></Input>
        </FormItem>

        <FormItem label="主要内容" style="width: 98%">
          <Input v-model="data.text" type="textarea" :autosize="{minRows: 2,maxRows: 5}"
                 placeholder="主要内容..."></Input>
        </FormItem>

        <FormItem label="附件" prop="data.attach_ids" style="width: 99%">
          <mx-upload-doc
            ref="attach"
            :multi="true"
            @on-change="handleDocChange"
          ></mx-upload-doc>
        </FormItem>

        <FormItem label="备注" style="width: 66%">
          <Input v-model="data.remark" type="textarea" :autosize="{minRows: 2,maxRows: 3}"
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
  import uploadDoc from '@/components/upload/doc'

  import {addKnowledge} from '../../api/knowledge'

  import * as knowledgeConst from '../../constants/knowledge'
  import {getDocList} from '@/api/upload/doc'

  export default {
    name: 'knowledge-add',
    mixins: [ModalMixin, AreaMixin],
    components: {
      [uploadDoc.name]: uploadDoc
    },
    data () {
      return {
        data: {
          attach_ids: '',
          attach: '',
          subject_name: '',
          type: 0,
          type1: 0,
          downloads: 0,
          label: '',
          text: '',
          remark: '',
          attach_file: ''
        },
        rules: {
          subject_name: [
            {required: true, message: '主题不能为空', trigger: 'blur'}
          ],
          label: [
            {required: true, message: '标签不能为空', trigger: 'blur'}
          ]
        },
        typeList: knowledgeConst.TYPE_LIST,
        type1List: knowledgeConst.TYPE1_LIST
      }
    },
    // 数据初始化
    created () {
      this.initData = {...this.data}
      // console.log('initData4563', this.initData)
    },
    methods: {
      onSubmit (e) {
        this.$refs.addForm.validate(async (valid) => {
          if (valid) {
            try {
              let data = await addKnowledge(this.data)
              console.log('data', data)
              this.data = {...this.initData}
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
        return true
      },
      async afterOpen () {
        let data = this.data

        if (data.attach_ids) {
          try {
            let {data: attachDos} = await getDocList(data.attach_ids.split(','))
            this.$refs.attach.initData(attachDos)
          } catch (e) {
            console.log('get attach ids fail', e)
          }
        } else {
          this.$refs.attach.initData([])
        }
      },
      async handleDocChange (files) {
        this.data.attach_ids = files.map(file => file.id).join(',')
      }
    }
  }
</script>
