import {getApi} from "../util/axios";

export function getWXConfig() {
    var url = location.href.split('#')[0]
    return getApi('config', {url: url})
}
