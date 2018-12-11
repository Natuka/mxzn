import { getApi } from '../util/axios'

export function fetchMachineInfo(code) {
    return getApi(`/machine/${code}/info`)
}
