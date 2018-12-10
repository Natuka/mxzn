import Vue from 'vue'
import MxSelect from './components/common/mx-select'
import MxDatetime from './components/common/mx-datetime'
import MxDatetimepicker from './components/common/mx-datetimepicker'
import MxUpload from './components/common/mx-upload'
import MxEngineer from './components/common/mx-engineer'
// import MxUpload from './components/common/upload'

import VueUploadComponent from 'vue-upload-component'

Vue.component(MxDatetimepicker.name, MxDatetimepicker)
Vue.component(MxDatetime.name, MxDatetime)
Vue.component(MxSelect.name, MxSelect)
Vue.component(MxUpload.name, MxUpload)
Vue.component(MxEngineer.name, MxEngineer)

Vue.component('file-upload', VueUploadComponent)
