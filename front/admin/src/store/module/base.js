import {basePost, baseJob, baseEducation} from '../../api/select/base'

export default {
  state: {
    post: [], // 职务
    job: [], // 职位
    education: [] // 学历
  },
  getters: {
    post ({post}) {
      return post
    },
    job ({job}) {
      return job
    },
    education ({education}) {
      return education
    }
  },
  mutations: {
    setJob (state, job) {
      state.job = job
    },
    setPost (state, post) {
      state.post = post
    },
    setEducation (state, education) {
      state.education = education
    }
  },
  actions: {
    // 新增数据不在重复加载
    async getPost ({commit, state}) {
      if (state.post.length) {
        return Promise.resolve(state.post)
      }
      let {data} = await basePost()
      commit('setPost', data)
      return data
    },
    // 新增数据不在重复加载
    async getJob ({commit, state}) {
      if (state.job.length) {
        return Promise.resolve(state.job)
      }
      let {data} = await baseJob()
      commit('setJob', data)
      return data
    },
    // 新增数据不在重复加载
    async getEducation ({commit, state}) {
      if (state.education.length) {
        return Promise.resolve(state.education)
      }
      let {data} = await baseEducation()
      commit('setEducation', data)
      return data
    }
  }
}
