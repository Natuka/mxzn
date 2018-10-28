import {getApi} from "../util/axios";

export function user () {
    return getApi('user/info')
}
