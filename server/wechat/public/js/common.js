function toJson(data) {
    console.log('data', data)
    if (typeof data === 'object' && data !== null) {
        return data
    }

    try {
        return new Function('return ' + data)()
    } catch (e) {
        return {}
    }
}

function ApiRequest(path, params, method) {
    if (!(this instanceof ApiRequest)) {
        return new ApiRequest(path, params, method)
    }

    this.method = method || 'get'
    this.path = path
    this.params = params

    this.successFns = []
    this.failFns = []
    this.alwaysFns = []
    // 执行
    this.do()
}


ApiRequest.post = function (path, params) {
    return ApiRequest(path, params, 'post')
}

ApiRequest.prototype.doThen = function (data, message) {
    var len = this.successFns.length
    var i = 0
    for (;i < len; i++) {
        this.successFns[i](data, message)
    }
}

ApiRequest.prototype.doFail = function (data, message) {
    var len = this.failFns.length
    var i = 0
    for (;i < len; i++) {
        this.failFns[i](data, message)
    }
}

ApiRequest.prototype.doAlways = function () {
    var len = this.alwaysFns.length
    var i = 0
    for (;i < len; i++) {
        this.failFns[i]()
    }
}

ApiRequest.prototype.do = function () {
    var self = this
    $[this.method](this.path, this.params).done(function (data) {
        data = toJson(data)
        if (data.code == 0) {
            self.doThen(data.data, data.message)
        } else {
            self.doFail(data.data, data.message)
        }
    }).fail(function (e) {
        self.doFail(e, e.message)
    }).always(function () {

    })
}

ApiRequest.prototype.done = function (fn) {
    this.successFns.push(fn)
    return this
}

ApiRequest.prototype.then = function (successFn, failFn) {
    this.successFns.push(successFn)
    this.failFns.push(failFn)
    return this
}

ApiRequest.prototype.fail = function (fn) {
    this.failFns.push(fn)
    return this
}

ApiRequest.prototype.always = function (fn) {
    this.alwaysFns.push(fn)
    return this
}

$.ajaxSetup({
    // contentType:"application/x-www-form-urlencoded;charset=utf-8",
    // complete:function(XMLHttpRequest,textStatus){
    // },
    statusCode: {
        404: function() {
            $.alert('数据获取/输入失败，没有此服务。');
        },
        504: function() {
            $.alert('数据获取/输入失败，服务器没有响应。');
        },
        500: function() {
            $.alert('服务器有误。');
        }
    }
});
