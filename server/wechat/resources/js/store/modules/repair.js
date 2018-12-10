import { repair } from '../../config/repair'

const state = {
    data: {
        ...repair
    },
    part: {},
    project: {},
    causeDocs: [],
    stepDocs: []
}

const getters = {
    causeDocs({ causeDocs }) {
        return causeDocs
    },
    stepDocs({ stepDocs }) {
        return stepDocs
    },
    repair({ data }) {
        return data
    },
    part({ part }) {
        return part
    },
    project({ project }) {
        return project
    },
    partName({ part }) {
        return part.name || ''
    },
    projectName({ project }) {
        return project.name || ''
    }
}

const actions = {}

const mutations = {
    reset(state) {
        state.data = { ...repair }
        state.project = {}
        state.part = {}
    },
    setPart(state, part) {
        state.part = part
    },
    setProject(state, project) {
        state.project = project
    },
    setProcessId(state, processId) {
        state.data.process_id = processId
    },
    setProcess(state, process) {
        state.data.process = process
    },
    setStaffId(state, staffId) {
        state.data.staff_id = staffId
    },
    setStaffName(state, staffName) {
        state.data.staff_name = staffName
    },
    setArrivedAt(state, date) {
        state.data.arrived_at = date
    },
    setCompleteAt(state, date) {
        state.data.complete_at = date
    },
    setCauseId(state, id) {
        state.data.cause_id = id
    },
    setCause(state, cause) {
        state.data.cause = cause
    },

    setStepResult(state, result) {
        state.data.step_result = result
    },
    // 下一步
    setNextStep(state, step) {
        state.data.next_step = step
    },

    setStepDocIds(state, docIds) {
        state.data.step_doc_ids = docIds
    },
    setCauseDocIds(state, docIds) {
        state.data.cause_doc_ids = docIds
    },
    setRemark(state, remark) {
        state.data.remark = remark
    },
    setCauseDocs(state, docs) {
        state.causeDocs = docs
    },
    setStepDocs(state, docs) {
        state.stepDocs = docs
    }
}

export default {
    state,
    getters,
    actions,
    mutations
}
