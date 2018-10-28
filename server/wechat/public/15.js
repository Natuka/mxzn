webpackJsonp([15],{

/***/ 170:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(209)
}
var normalizeComponent = __webpack_require__(61)
/* script */
var __vue_script__ = __webpack_require__(211)
/* template */
var __vue_template__ = __webpack_require__(213)
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = "data-v-25b03636"
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __vue_script__,
  __vue_template__,
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "resources/js/components/repair/list.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-25b03636", Component.options)
  } else {
    hotAPI.reload("data-v-25b03636", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 176:
/***/ (function(module, exports, __webpack_require__) {

/*
  MIT License http://www.opensource.org/licenses/mit-license.php
  Author Tobias Koppers @sokra
  Modified by Evan You @yyx990803
*/

var hasDocument = typeof document !== 'undefined'

if (typeof DEBUG !== 'undefined' && DEBUG) {
  if (!hasDocument) {
    throw new Error(
    'vue-style-loader cannot be used in a non-browser environment. ' +
    "Use { target: 'node' } in your Webpack config to indicate a server-rendering environment."
  ) }
}

var listToStyles = __webpack_require__(177)

/*
type StyleObject = {
  id: number;
  parts: Array<StyleObjectPart>
}

type StyleObjectPart = {
  css: string;
  media: string;
  sourceMap: ?string
}
*/

var stylesInDom = {/*
  [id: number]: {
    id: number,
    refs: number,
    parts: Array<(obj?: StyleObjectPart) => void>
  }
*/}

var head = hasDocument && (document.head || document.getElementsByTagName('head')[0])
var singletonElement = null
var singletonCounter = 0
var isProduction = false
var noop = function () {}
var options = null
var ssrIdKey = 'data-vue-ssr-id'

// Force single-tag solution on IE6-9, which has a hard limit on the # of <style>
// tags it will allow on a page
var isOldIE = typeof navigator !== 'undefined' && /msie [6-9]\b/.test(navigator.userAgent.toLowerCase())

module.exports = function (parentId, list, _isProduction, _options) {
  isProduction = _isProduction

  options = _options || {}

  var styles = listToStyles(parentId, list)
  addStylesToDom(styles)

  return function update (newList) {
    var mayRemove = []
    for (var i = 0; i < styles.length; i++) {
      var item = styles[i]
      var domStyle = stylesInDom[item.id]
      domStyle.refs--
      mayRemove.push(domStyle)
    }
    if (newList) {
      styles = listToStyles(parentId, newList)
      addStylesToDom(styles)
    } else {
      styles = []
    }
    for (var i = 0; i < mayRemove.length; i++) {
      var domStyle = mayRemove[i]
      if (domStyle.refs === 0) {
        for (var j = 0; j < domStyle.parts.length; j++) {
          domStyle.parts[j]()
        }
        delete stylesInDom[domStyle.id]
      }
    }
  }
}

function addStylesToDom (styles /* Array<StyleObject> */) {
  for (var i = 0; i < styles.length; i++) {
    var item = styles[i]
    var domStyle = stylesInDom[item.id]
    if (domStyle) {
      domStyle.refs++
      for (var j = 0; j < domStyle.parts.length; j++) {
        domStyle.parts[j](item.parts[j])
      }
      for (; j < item.parts.length; j++) {
        domStyle.parts.push(addStyle(item.parts[j]))
      }
      if (domStyle.parts.length > item.parts.length) {
        domStyle.parts.length = item.parts.length
      }
    } else {
      var parts = []
      for (var j = 0; j < item.parts.length; j++) {
        parts.push(addStyle(item.parts[j]))
      }
      stylesInDom[item.id] = { id: item.id, refs: 1, parts: parts }
    }
  }
}

function createStyleElement () {
  var styleElement = document.createElement('style')
  styleElement.type = 'text/css'
  head.appendChild(styleElement)
  return styleElement
}

function addStyle (obj /* StyleObjectPart */) {
  var update, remove
  var styleElement = document.querySelector('style[' + ssrIdKey + '~="' + obj.id + '"]')

  if (styleElement) {
    if (isProduction) {
      // has SSR styles and in production mode.
      // simply do nothing.
      return noop
    } else {
      // has SSR styles but in dev mode.
      // for some reason Chrome can't handle source map in server-rendered
      // style tags - source maps in <style> only works if the style tag is
      // created and inserted dynamically. So we remove the server rendered
      // styles and inject new ones.
      styleElement.parentNode.removeChild(styleElement)
    }
  }

  if (isOldIE) {
    // use singleton mode for IE9.
    var styleIndex = singletonCounter++
    styleElement = singletonElement || (singletonElement = createStyleElement())
    update = applyToSingletonTag.bind(null, styleElement, styleIndex, false)
    remove = applyToSingletonTag.bind(null, styleElement, styleIndex, true)
  } else {
    // use multi-style-tag mode in all other cases
    styleElement = createStyleElement()
    update = applyToTag.bind(null, styleElement)
    remove = function () {
      styleElement.parentNode.removeChild(styleElement)
    }
  }

  update(obj)

  return function updateStyle (newObj /* StyleObjectPart */) {
    if (newObj) {
      if (newObj.css === obj.css &&
          newObj.media === obj.media &&
          newObj.sourceMap === obj.sourceMap) {
        return
      }
      update(obj = newObj)
    } else {
      remove()
    }
  }
}

var replaceText = (function () {
  var textStore = []

  return function (index, replacement) {
    textStore[index] = replacement
    return textStore.filter(Boolean).join('\n')
  }
})()

function applyToSingletonTag (styleElement, index, remove, obj) {
  var css = remove ? '' : obj.css

  if (styleElement.styleSheet) {
    styleElement.styleSheet.cssText = replaceText(index, css)
  } else {
    var cssNode = document.createTextNode(css)
    var childNodes = styleElement.childNodes
    if (childNodes[index]) styleElement.removeChild(childNodes[index])
    if (childNodes.length) {
      styleElement.insertBefore(cssNode, childNodes[index])
    } else {
      styleElement.appendChild(cssNode)
    }
  }
}

function applyToTag (styleElement, obj) {
  var css = obj.css
  var media = obj.media
  var sourceMap = obj.sourceMap

  if (media) {
    styleElement.setAttribute('media', media)
  }
  if (options.ssrId) {
    styleElement.setAttribute(ssrIdKey, obj.id)
  }

  if (sourceMap) {
    // https://developer.chrome.com/devtools/docs/javascript-debugging
    // this makes source maps inside style tags work properly in Chrome
    css += '\n/*# sourceURL=' + sourceMap.sources[0] + ' */'
    // http://stackoverflow.com/a/26603875
    css += '\n/*# sourceMappingURL=data:application/json;base64,' + btoa(unescape(encodeURIComponent(JSON.stringify(sourceMap)))) + ' */'
  }

  if (styleElement.styleSheet) {
    styleElement.styleSheet.cssText = css
  } else {
    while (styleElement.firstChild) {
      styleElement.removeChild(styleElement.firstChild)
    }
    styleElement.appendChild(document.createTextNode(css))
  }
}


/***/ }),

/***/ 177:
/***/ (function(module, exports) {

/**
 * Translates the list format produced by css-loader into something
 * easier to manipulate.
 */
module.exports = function listToStyles (parentId, list) {
  var styles = []
  var newStyles = {}
  for (var i = 0; i < list.length; i++) {
    var item = list[i]
    var id = item[0]
    var css = item[1]
    var media = item[2]
    var sourceMap = item[3]
    var part = {
      id: parentId + ':' + i,
      css: css,
      media: media,
      sourceMap: sourceMap
    }
    if (!newStyles[id]) {
      styles.push(newStyles[id] = { id: id, parts: [part] })
    } else {
      newStyles[id].parts.push(part)
    }
  }
  return styles
}


/***/ }),

/***/ 179:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(180)
}
var normalizeComponent = __webpack_require__(61)
/* script */
var __vue_script__ = __webpack_require__(182)
/* template */
var __vue_template__ = __webpack_require__(183)
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = "data-v-58f5f7fc"
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __vue_script__,
  __vue_template__,
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "resources/js/components/actions.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-58f5f7fc", Component.options)
  } else {
    hotAPI.reload("data-v-58f5f7fc", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 180:
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(181);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(176)("7d120787", content, false, {});
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../node_modules/css-loader/index.js!../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-58f5f7fc\",\"scoped\":true,\"hasInlineConfig\":true}!../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./actions.vue", function() {
     var newContent = require("!!../../../node_modules/css-loader/index.js!../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-58f5f7fc\",\"scoped\":true,\"hasInlineConfig\":true}!../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./actions.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),

/***/ 181:
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(60)(false);
// imports


// module
exports.push([module.i, "\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n", ""]);

// exports


/***/ }),

/***/ 182:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
//
//
//
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = ({
    name: "mx-actions",
    props: {
        data: {
            type: Object,
            default: function _default() {
                return {};
            }
        },
        from: {
            type: String,
            default: ''
        }
    },
    data: function data() {
        return {
            show: false,
            actions: [{
                name: '转派',
                type: 1,
                method: 'jump',
                path: '/repair/change'
            }, {
                name: '完工',
                type: 2,
                method: 'confirm',
                path: ''
            }, {
                name: '修改',
                type: 3,
                method: 'jump',
                path: '/repair/edit'
            }, {
                name: '取消',
                type: 4,
                method: 'jump',
                path: '/repair/cancel'
            }, {
                name: '配件耗材',
                type: 5,
                method: 'jump',
                path: '/repair/equipment'
            }, {
                name: '服务项目',
                type: 6,
                method: 'jump',
                path: '/repair/service'
            }, {
                name: '签到记录',
                type: 7,
                method: 'jump',
                path: '/repair/attendance'
            }, {
                name: '操作日志',
                type: 8,
                method: 'jump',
                path: '/repair/log'
            }, {
                name: '催单记录',
                type: 9,
                method: 'jump',
                path: '/repair/followup'
            }]
        };
    },

    methods: {
        onSelect: function onSelect(action) {
            this[action.method](action);
        },
        jump: function jump(action) {
            this.$router.push({
                path: action.path,
                query: {
                    from: this.from
                }
            });
        },
        popup: function popup(action) {},
        confirm: function confirm() {
            var _this = this;

            this.$dialog.confirm({
                title: '提示',
                message: '确认完工？'
            }).then(function () {
                _this.$toast('确定');
            }).catch(function () {
                _this.$toast('取消了');
            });
        },
        open: function open() {
            this.show = true;
        }
    }

});

/***/ }),

/***/ 183:
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("van-actionsheet", {
    attrs: { actions: _vm.actions, "cancel-text": "取消" },
    on: { select: _vm.onSelect },
    model: {
      value: _vm.show,
      callback: function($$v) {
        _vm.show = $$v
      },
      expression: "show"
    }
  })
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-58f5f7fc", module.exports)
  }
}

/***/ }),

/***/ 184:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony default export */ __webpack_exports__["a"] = ({
    computed: {
        from: function from() {
            return this.$route.fullPath;
        }
    },
    methods: {
        // 文档
        onDocument: function onDocument(item) {
            this.$router.push({
                path: '/repair/document',
                query: {
                    from: this.from
                }
            });
        },

        // 处理
        onAttendance: function onAttendance(item) {
            this.$router.push({
                path: '/repair/attendance',
                query: {
                    from: this.from
                }
            });
        },

        // 处理
        onAction: function onAction(item) {
            this.$router.push({
                path: '/repair/action',
                query: {
                    from: this.from
                }
            });
        }
    }
});

/***/ }),

/***/ 209:
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(210);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(176)("2e66fafe", content, false, {});
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../node_modules/css-loader/index.js!../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-25b03636\",\"scoped\":true,\"hasInlineConfig\":true}!../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./list.vue", function() {
     var newContent = require("!!../../../../node_modules/css-loader/index.js!../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-25b03636\",\"scoped\":true,\"hasInlineConfig\":true}!../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./list.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),

/***/ 210:
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(60)(false);
// imports


// module
exports.push([module.i, "\n.text-right[data-v-25b03636]{\n    text-align: right;\n}\n", ""]);

// exports


/***/ }),

/***/ 211:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__const_repair__ = __webpack_require__(212);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__actions__ = __webpack_require__(179);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__actions___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1__actions__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__mixins_action__ = __webpack_require__(184);
function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//






/* harmony default export */ __webpack_exports__["default"] = ({
    name: "mx-repair-list",
    components: _defineProperty({}, __WEBPACK_IMPORTED_MODULE_1__actions___default.a.name, __WEBPACK_IMPORTED_MODULE_1__actions___default.a),
    mixins: [__WEBPACK_IMPORTED_MODULE_2__mixins_action__["a" /* default */]],
    data: function data() {
        return {
            active: 2,
            list: [],
            loading: false,
            finished: false,
            menus: __WEBPACK_IMPORTED_MODULE_0__const_repair__["a" /* list */],
            isLoading: false,
            value: '',
            data: {}
        };
    },

    methods: {
        onClickLeft: function onClickLeft() {
            this.$toast('返回');
        },
        onClickRight: function onClickRight() {
            this.$toast('按钮');
        },
        onRefresh: function onRefresh() {
            var _this = this;

            this.onLoad();
            setTimeout(function () {
                _this.$toast('刷新成功');
                _this.isLoading = false;
                _this.count++;
            }, 500);
        },
        onLoad: function onLoad() {
            var _this2 = this;

            // 异步更新数据
            setTimeout(function () {
                var data = _this2.menus[_this2.active].data;
                for (var i = 0; i < 10; i++) {
                    data.push({
                        index: data.length + 1
                    });
                }
                // 加载状态结束
                _this2.loading = false;

                // 数据全部加载完成
                if (data.length >= 40) {
                    _this2.finished = true;
                }
            }, 500);
        },
        onSearch: function onSearch() {},
        onClick: function onClick(item) {
            this.data = item;
            this.$refs['action'].open();
        }
    }
});

/***/ }),

/***/ 212:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return list; });
var list = [{
    name: '全部',
    type: 0,
    data: []
}, {
    name: '待处理',
    type: 1,
    data: []
}, {
    name: '处理中',
    type: 2,
    data: []
}, {
    name: '待结算',
    type: 3,
    data: []
}, {
    name: '全部',
    type: 4,
    data: []
}];

/***/ }),

/***/ 213:
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    [
      _c("van-nav-bar", {
        attrs: {
          title: "标题",
          "left-text": "返回",
          "right-text": "按钮",
          "left-arrow": ""
        },
        on: { "click-left": _vm.onClickLeft, "click-right": _vm.onClickRight }
      }),
      _vm._v(" "),
      _c(
        "van-search",
        {
          attrs: { placeholder: "请输入搜索关键词", "show-action": "" },
          on: { search: _vm.onSearch },
          model: {
            value: _vm.value,
            callback: function($$v) {
              _vm.value = $$v
            },
            expression: "value"
          }
        },
        [
          _c(
            "div",
            {
              attrs: { slot: "action" },
              on: { click: _vm.onSearch },
              slot: "action"
            },
            [_vm._v("搜索")]
          )
        ]
      ),
      _vm._v(" "),
      _c(
        "van-tabs",
        {
          model: {
            value: _vm.active,
            callback: function($$v) {
              _vm.active = $$v
            },
            expression: "active"
          }
        },
        _vm._l(_vm.menus, function(menu) {
          return _c(
            "van-tab",
            { key: menu.type, attrs: { title: menu.name } },
            [
              _c(
                "van-pull-refresh",
                {
                  on: { refresh: _vm.onRefresh },
                  model: {
                    value: _vm.isLoading,
                    callback: function($$v) {
                      _vm.isLoading = $$v
                    },
                    expression: "isLoading"
                  }
                },
                [
                  _c(
                    "van-list",
                    {
                      attrs: { finished: _vm.finished },
                      on: { load: _vm.onLoad },
                      model: {
                        value: _vm.loading,
                        callback: function($$v) {
                          _vm.loading = $$v
                        },
                        expression: "loading"
                      }
                    },
                    _vm._l(menu.data, function(item, key) {
                      return _c(
                        "van-panel",
                        {
                          key: key,
                          attrs: {
                            title: "【处理中】单号：GD-2139238",
                            status: "已处理34天3小时"
                          }
                        },
                        [
                          _c(
                            "div",
                            {
                              staticClass: "pt-20 pr-20 pl-20 mx-flex",
                              attrs: { slot: "header" },
                              slot: "header"
                            },
                            [
                              _c(
                                "van-row",
                                {
                                  attrs: {
                                    type: "flex",
                                    justify: "space-between"
                                  }
                                },
                                [
                                  _c("span", { staticClass: "mx-flex-1" }, [
                                    _vm._v("【处理中】单号：GD-2139238")
                                  ]),
                                  _vm._v(" "),
                                  _c(
                                    "span",
                                    { staticClass: "mx-text-danger" },
                                    [_vm._v("已处理34天3小时")]
                                  )
                                ]
                              )
                            ],
                            1
                          ),
                          _vm._v(" "),
                          _c(
                            "div",
                            { staticClass: "p-20" },
                            [
                              _c(
                                "van-row",
                                {
                                  attrs: {
                                    type: "flex",
                                    justify: "space-between"
                                  }
                                },
                                [
                                  _c("van-col", { attrs: { span: 24 } }, [
                                    _c("span", { staticClass: "mx-label" }, [
                                      _vm._v("报修")
                                    ])
                                  ])
                                ],
                                1
                              ),
                              _vm._v(" "),
                              _c(
                                "van-row",
                                {
                                  attrs: {
                                    type: "flex",
                                    justify: "space-between"
                                  }
                                },
                                [
                                  _c("van-col", { attrs: { span: 12 } }, [
                                    _c("span", { staticClass: "mx-label" }, [
                                      _vm._v("地址")
                                    ])
                                  ]),
                                  _vm._v(" "),
                                  _c("van-col", { attrs: { span: 12 } }, [
                                    _c("span", { staticClass: "mx-label" }, [
                                      _vm._v("区域")
                                    ])
                                  ])
                                ],
                                1
                              ),
                              _vm._v(" "),
                              _c(
                                "van-row",
                                {
                                  attrs: {
                                    type: "flex",
                                    justify: "space-between"
                                  }
                                },
                                [
                                  _c("van-col", { attrs: { span: 12 } }, [
                                    _c("span", { staticClass: "mx-label" }, [
                                      _vm._v("机器")
                                    ])
                                  ]),
                                  _vm._v(" "),
                                  _c("van-col", { attrs: { span: 12 } }, [
                                    _c("span", { staticClass: "mx-label" }, [
                                      _vm._v("序列号")
                                    ])
                                  ])
                                ],
                                1
                              ),
                              _vm._v(" "),
                              _c(
                                "van-row",
                                {
                                  attrs: {
                                    type: "flex",
                                    justify: "space-between"
                                  }
                                },
                                [
                                  _c("van-col", { attrs: { span: 24 } }, [
                                    _c("span", { staticClass: "mx-label" }, [
                                      _vm._v("故障")
                                    ])
                                  ])
                                ],
                                1
                              ),
                              _vm._v(" "),
                              _c(
                                "van-row",
                                {
                                  attrs: {
                                    type: "flex",
                                    justify: "space-between"
                                  }
                                },
                                [
                                  _c("van-col", { attrs: { span: 12 } }, [
                                    _c("span", { staticClass: "mx-label" }, [
                                      _vm._v("技术员")
                                    ])
                                  ]),
                                  _vm._v(" "),
                                  _c("van-col", { attrs: { span: 12 } }, [
                                    _c("span", { staticClass: "mx-label" }, [
                                      _vm._v("预约时间")
                                    ])
                                  ])
                                ],
                                1
                              ),
                              _vm._v(" "),
                              _c(
                                "van-row",
                                {
                                  attrs: {
                                    type: "flex",
                                    justify: "space-between"
                                  }
                                },
                                [
                                  _c("van-col", { attrs: { span: 6 } }, [
                                    _c("span", { staticClass: "mx-label" }, [
                                      _vm._v("配件费")
                                    ]),
                                    _vm._v(" "),
                                    _c(
                                      "span",
                                      { staticClass: "mx-text-danger" },
                                      [_vm._v("0")]
                                    )
                                  ]),
                                  _vm._v(" "),
                                  _c("van-col", { attrs: { span: 6 } }, [
                                    _c("span", { staticClass: "mx-label" }, [
                                      _vm._v("服务费")
                                    ]),
                                    _vm._v(" "),
                                    _c(
                                      "span",
                                      { staticClass: "mx-text-danger" },
                                      [_vm._v("0")]
                                    )
                                  ]),
                                  _vm._v(" "),
                                  _c("van-col", { attrs: { span: 6 } }, [
                                    _c("span", { staticClass: "mx-label" }, [
                                      _vm._v("附加费")
                                    ]),
                                    _vm._v(" "),
                                    _c(
                                      "span",
                                      { staticClass: "mx-text-danger" },
                                      [_vm._v("0")]
                                    )
                                  ]),
                                  _vm._v(" "),
                                  _c("van-col", { attrs: { span: 6 } }, [
                                    _c("span", { staticClass: "mx-label" }, [
                                      _vm._v("合计")
                                    ]),
                                    _vm._v(" "),
                                    _c(
                                      "span",
                                      { staticClass: "mx-text-danger" },
                                      [_vm._v("0")]
                                    )
                                  ])
                                ],
                                1
                              )
                            ],
                            1
                          ),
                          _vm._v(" "),
                          _c(
                            "div",
                            {
                              staticClass: "text-right",
                              attrs: { slot: "footer" },
                              slot: "footer"
                            },
                            [
                              _c(
                                "van-button",
                                {
                                  attrs: { size: "small" },
                                  on: {
                                    click: function($event) {
                                      _vm.onAttendance(item)
                                    }
                                  }
                                },
                                [_vm._v("签到")]
                              ),
                              _vm._v(" "),
                              _c(
                                "van-button",
                                {
                                  attrs: { size: "small" },
                                  on: {
                                    click: function($event) {
                                      _vm.onAction(item)
                                    }
                                  }
                                },
                                [_vm._v("处理")]
                              ),
                              _vm._v(" "),
                              _c(
                                "van-button",
                                {
                                  attrs: { size: "small" },
                                  on: {
                                    click: function($event) {
                                      _vm.onDocument(item)
                                    }
                                  }
                                },
                                [_vm._v("附件")]
                              ),
                              _vm._v(" "),
                              _c(
                                "van-button",
                                {
                                  attrs: { size: "small", type: "danger" },
                                  on: {
                                    click: function($event) {
                                      _vm.onClick(item)
                                    }
                                  }
                                },
                                [_vm._v("更多")]
                              )
                            ],
                            1
                          )
                        ]
                      )
                    })
                  )
                ],
                1
              )
            ],
            1
          )
        })
      ),
      _vm._v(" "),
      _c("mx-actions", {
        ref: "action",
        attrs: { data: _vm.data, from: _vm.$route.fullPath }
      })
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-25b03636", module.exports)
  }
}

/***/ })

});