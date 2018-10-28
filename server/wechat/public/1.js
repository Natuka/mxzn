webpackJsonp([1],{

/***/ 197:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(241)
}
var normalizeComponent = __webpack_require__(68)
/* script */
var __vue_script__ = __webpack_require__(243)
/* template */
var __vue_template__ = __webpack_require__(245)
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

/***/ 203:
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

var listToStyles = __webpack_require__(204)

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

/***/ 204:
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

/***/ 207:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(208)
}
var normalizeComponent = __webpack_require__(68)
/* script */
var __vue_script__ = __webpack_require__(210)
/* template */
var __vue_template__ = __webpack_require__(211)
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

/***/ 208:
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(209);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(203)("7d120787", content, false, {});
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

/***/ 209:
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(14)(false);
// imports


// module
exports.push([module.i, "\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n", ""]);

// exports


/***/ }),

/***/ 210:
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
            this.$store.dispatch('setServiceOrder', this.data);
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

/***/ 211:
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

/***/ 212:
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

/***/ 241:
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(242);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(203)("2e66fafe", content, false, {});
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

/***/ 242:
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(14)(false);
// imports


// module
exports.push([module.i, "\n.text-right[data-v-25b03636]{\n    text-align: right;\n}\n", ""]);

// exports


/***/ }),

/***/ 243:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_babel_runtime_regenerator__ = __webpack_require__(69);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_babel_runtime_regenerator___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_babel_runtime_regenerator__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__const_repair__ = __webpack_require__(244);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__actions__ = __webpack_require__(207);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__actions___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_2__actions__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__mixins_action__ = __webpack_require__(212);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__mixins_service_info__ = __webpack_require__(268);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5__api__ = __webpack_require__(58);


function _toConsumableArray(arr) { if (Array.isArray(arr)) { for (var i = 0, arr2 = Array(arr.length); i < arr.length; i++) { arr2[i] = arr[i]; } return arr2; } else { return Array.from(arr); } }

function _asyncToGenerator(fn) { return function () { var gen = fn.apply(this, arguments); return new Promise(function (resolve, reject) { function step(key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { return Promise.resolve(value).then(function (value) { step("next", value); }, function (err) { step("throw", err); }); } } return step("next"); }); }; }

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
    components: _defineProperty({}, __WEBPACK_IMPORTED_MODULE_2__actions___default.a.name, __WEBPACK_IMPORTED_MODULE_2__actions___default.a),
    mixins: [__WEBPACK_IMPORTED_MODULE_3__mixins_action__["a" /* default */], __WEBPACK_IMPORTED_MODULE_4__mixins_service_info__["a" /* default */]],
    data: function data() {
        return {
            active: 2,
            list: [],
            loading: false,
            finished: false,
            menus: __WEBPACK_IMPORTED_MODULE_1__const_repair__["b" /* list */],
            isLoading: false,
            value: '',
            data: {},
            page: 1,
            isRefresh: false
        };
    },

    methods: {
        onClickLeft: function onClickLeft() {
            this.$toast('返回');
        },
        onClickRight: function onClickRight() {
            this.$toast('按钮');
        },
        onRefresh: function () {
            var _ref = _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0_babel_runtime_regenerator___default.a.mark(function _callee() {
                return __WEBPACK_IMPORTED_MODULE_0_babel_runtime_regenerator___default.a.wrap(function _callee$(_context) {
                    while (1) {
                        switch (_context.prev = _context.next) {
                            case 0:
                                this.isRefresh = true;
                                _context.next = 3;
                                return this.loadData();

                            case 3:
                                _context.next = 5;
                                return this.onLoad();

                            case 5:
                            case 'end':
                                return _context.stop();
                        }
                    }
                }, _callee, this);
            }));

            function onRefresh() {
                return _ref.apply(this, arguments);
            }

            return onRefresh;
        }(),
        setOrderInfo: function () {
            var _ref2 = _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0_babel_runtime_regenerator___default.a.mark(function _callee2(info) {
                return __WEBPACK_IMPORTED_MODULE_0_babel_runtime_regenerator___default.a.wrap(function _callee2$(_context2) {
                    while (1) {
                        switch (_context2.prev = _context2.next) {
                            case 0:
                                this.$store.dispatch('setServiceOrder', info);
                                this.$router.push('/repair/info');

                            case 2:
                            case 'end':
                                return _context2.stop();
                        }
                    }
                }, _callee2, this);
            }));

            function setOrderInfo(_x) {
                return _ref2.apply(this, arguments);
            }

            return setOrderInfo;
        }(),
        loadData: function () {
            var _ref3 = _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0_babel_runtime_regenerator___default.a.mark(function _callee3() {
                var dataWrap, _dataWrap$data, _ref4, data, current_page, last_page, per_page;

                return __WEBPACK_IMPORTED_MODULE_0_babel_runtime_regenerator___default.a.wrap(function _callee3$(_context3) {
                    while (1) {
                        switch (_context3.prev = _context3.next) {
                            case 0:
                                dataWrap = this.menus[this.active];

                                if (this.isRefresh) {
                                    dataWrap.loading = true;
                                    dataWrap.finished = false;
                                    dataWrap.page = 1;
                                } else {
                                    dataWrap.finished = false;
                                }

                                _context3.prev = 2;
                                _context3.next = 5;
                                return Object(__WEBPACK_IMPORTED_MODULE_5__api__["repairList"])({ page: dataWrap.page, type: dataWrap.type });

                            case 5:
                                _ref4 = _context3.sent;
                                data = _ref4.data;
                                current_page = _ref4.current_page;
                                last_page = _ref4.last_page;
                                per_page = _ref4.per_page;

                                if (this.isRefresh) {
                                    dataWrap.data = [];
                                }

                                dataWrap.page++;
                                (_dataWrap$data = dataWrap.data).push.apply(_dataWrap$data, _toConsumableArray(data));
                                if (!data.length || data.length < per_page) {
                                    dataWrap.finished = true;
                                }
                                _context3.next = 18;
                                break;

                            case 16:
                                _context3.prev = 16;
                                _context3.t0 = _context3['catch'](2);

                            case 18:
                                _context3.prev = 18;

                                this.loading = false;
                                return _context3.finish(18);

                            case 21:
                            case 'end':
                                return _context3.stop();
                        }
                    }
                }, _callee3, this, [[2, 16, 18, 21]]);
            }));

            function loadData() {
                return _ref3.apply(this, arguments);
            }

            return loadData;
        }(),
        onLoad: function () {
            var _ref5 = _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0_babel_runtime_regenerator___default.a.mark(function _callee4() {
                return __WEBPACK_IMPORTED_MODULE_0_babel_runtime_regenerator___default.a.wrap(function _callee4$(_context4) {
                    while (1) {
                        switch (_context4.prev = _context4.next) {
                            case 0:
                                this.isRefresh = false;
                                _context4.next = 3;
                                return this.loadData();

                            case 3:
                            case 'end':
                                return _context4.stop();
                        }
                    }
                }, _callee4, this);
            }));

            function onLoad() {
                return _ref5.apply(this, arguments);
            }

            return onLoad;
        }(),
        onSearch: function onSearch() {},
        onClick: function onClick(item) {
            this.data = item;
            this.$refs['action'].open();
        }
    }
});

/***/ }),

/***/ 244:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "b", function() { return list; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return ORDER_STATUS; });
var list = [{
    name: '全部',
    type: 0,
    data: [],
    page: 1,
    finished: false,
    loading: false
}, {
    name: '待处理',
    type: 1,
    data: [],
    page: 1,
    finished: false,
    loading: false
}, {
    name: '处理中',
    type: 2,
    data: [],
    page: 1,
    finished: false,
    loading: false
}, {
    name: '待结算',
    type: 3,
    data: [],
    page: 1,
    finished: false,
    loading: false
}, {
    name: '已完成',
    type: 4,
    data: [],
    page: 1,
    finished: false,
    loading: false
}];

var ORDER_STATUS = '制单中,已受理,待派单,处理中,已取消,已关闭,无法处理'.split(',');

/***/ }),

/***/ 245:
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
                      attrs: { finished: menu.finished },
                      on: { load: _vm.onLoad },
                      model: {
                        value: menu.loading,
                        callback: function($$v) {
                          _vm.$set(menu, "loading", $$v)
                        },
                        expression: "menu.loading"
                      }
                    },
                    _vm._l(menu.data, function(item, key) {
                      return _c(
                        "van-panel",
                        {
                          key: key,
                          attrs: {
                            title: _vm.getServiceTitle(item),
                            status: _vm.getServiceStatus(item)
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
                                    ]),
                                    _vm._v(" "),
                                    _c("span", [
                                      _vm._v(_vm._s(_vm.getServiceAddr(item)))
                                    ])
                                  ]),
                                  _vm._v(" "),
                                  _c("van-col", { attrs: { span: 12 } }, [
                                    _c("span", { staticClass: "mx-label" }, [
                                      _vm._v("区域")
                                    ]),
                                    _vm._v(" "),
                                    _c("span", [
                                      _vm._v(_vm._s(_vm.getServiceArea(item)))
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
                                    ]),
                                    _vm._v(" "),
                                    _c("span", [
                                      _vm._v(
                                        _vm._s(
                                          _vm.getServiceEquipmentName(item)
                                        )
                                      )
                                    ])
                                  ]),
                                  _vm._v(" "),
                                  _c("van-col", { attrs: { span: 12 } }, [
                                    _c("span", { staticClass: "mx-label" }, [
                                      _vm._v("序列号")
                                    ]),
                                    _vm._v(
                                      "\n                                    " +
                                        _vm._s(
                                          _vm.getServiceEquipmentSerializeNo(
                                            item
                                          )
                                        ) +
                                        "\n                                "
                                    )
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
                                    ]),
                                    _vm._v(" "),
                                    _c("span", [
                                      _vm._v(
                                        _vm._s(_vm.getServiceFaultDesc(item))
                                      )
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
                                    ]),
                                    _vm._v(" "),
                                    _c("span", [
                                      _vm._v(
                                        _vm._s(_vm.getServiceEngineer(item))
                                      )
                                    ])
                                  ]),
                                  _vm._v(" "),
                                  _c("van-col", { attrs: { span: 12 } }, [
                                    _c("span", { staticClass: "mx-label" }, [
                                      _vm._v("预约时间")
                                    ]),
                                    _vm._v(" "),
                                    _c("span", [
                                      _vm._v(
                                        _vm._s(_vm.getServicePlanOoutAt(item))
                                      )
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
                                      [
                                        _vm._v(
                                          "\n                                        " +
                                            _vm._s(
                                              _vm.getServicePartFee(item)
                                            ) +
                                            "\n                                    "
                                        )
                                      ]
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
                                      [
                                        _vm._v(
                                          "\n                                        " +
                                            _vm._s(_vm.getServiceFee(item)) +
                                            "\n                                    "
                                        )
                                      ]
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
                                      [
                                        _vm._v(
                                          "\n                                        " +
                                            _vm._s(
                                              _vm.getServiceExtraFee(item)
                                            ) +
                                            "\n                                    "
                                        )
                                      ]
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
                                      [
                                        _vm._v(
                                          "\n                                        " +
                                            _vm._s(
                                              _vm.getServiceFeeTotal(item)
                                            ) +
                                            "\n                                    "
                                        )
                                      ]
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

/***/ }),

/***/ 268:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__const_repair__ = __webpack_require__(244);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_dayjs__ = __webpack_require__(269);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_dayjs___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_dayjs__);


// 制单中 0, 已受理 1,待派单 2,处理中 3,已取消 4,已关闭 5,无法处理 6



/* harmony default export */ __webpack_exports__["a"] = ({
    methods: {
        getServiceStatus: function getServiceStatus(info) {
            switch (info.status) {
                case 0:
                    return '';
                case 1:
                    return '正在派单中';
                case 2:
                    return '已受理';
                case 3:
                    var fromAt = __WEBPACK_IMPORTED_MODULE_1_dayjs___default()(info.receive_at);

                    var diffDay = __WEBPACK_IMPORTED_MODULE_1_dayjs___default()().diff(fromAt, 'days');
                    var today = __WEBPACK_IMPORTED_MODULE_1_dayjs___default()(__WEBPACK_IMPORTED_MODULE_1_dayjs___default()().format('YYYY-MM-DD 00:00:00'));
                    var diffHour = __WEBPACK_IMPORTED_MODULE_1_dayjs___default()().diff(today, 'hours');

                    if (!diffDay) {
                        return '\u5DF2\u5904\u7406' + diffHour + '\u5C0F\u65F6';
                    }

                    return '\u5DF2\u5904\u7406' + diffDay + '\u5929' + diffHour + '\u5C0F\u65F6';
                case 4:
                    return '已取消';
                case 5:
                    return '已关闭';
                case 6:
                default:

            }
            return '';
        },
        getServiceTitle: function getServiceTitle(info) {
            var text = __WEBPACK_IMPORTED_MODULE_0__const_repair__["a" /* ORDER_STATUS */][info.status];
            return '\u3010' + text + '\u3011\u5355\u53F7\uFF1A' + info.number;
        },
        getServiceAddr: function getServiceAddr(info) {
            return 'wwww';
        },
        getServiceArea: function getServiceArea() {
            return 'aaaa';
        },
        getServiceEquipmentName: function getServiceEquipmentName(info) {
            return '';
        },
        getServiceEquipmentSerializeNo: function getServiceEquipmentSerializeNo(info) {
            return '2222';
        },
        getServiceFaultDesc: function getServiceFaultDesc(info) {
            return '';
        },
        getServiceEngineer: function getServiceEngineer(info) {
            return '小于';
        },
        getServicePlanOoutAt: function getServicePlanOoutAt(info) {
            return 0;
        },
        getServicePartFee: function getServicePartFee(info) {
            return 0;
        },
        getServiceFee: function getServiceFee(info) {
            return 0;
        },
        getServiceExtraFee: function getServiceExtraFee(info) {
            return 0;
        },
        getServiceFeeTotal: function getServiceFeeTotal(info) {
            return 0;
        }
    }
});

/***/ }),

/***/ 269:
/***/ (function(module, exports, __webpack_require__) {

!function(t,e){ true?module.exports=e():"function"==typeof define&&define.amd?define(e):t.dayjs=e()}(this,function(){"use strict";var t="millisecond",e="second",n="minute",r="hour",s="day",i="week",a="month",u="year",c=/^(\d{4})-?(\d{1,2})-?(\d{0,2})(.*?(\d{1,2}):(\d{1,2}):(\d{1,2}))?.?(\d{1,3})?$/,o=/\[.*?\]|Y{2,4}|M{1,4}|D{1,2}|d{1,4}|H{1,2}|h{1,2}|a|A|m{1,2}|s{1,2}|Z{1,2}|SSS/g,h={name:"en",weekdays:"Sunday_Monday_Tuesday_Wednesday_Thursday_Friday_Saturday".split("_"),months:"January_February_March_April_May_June_July_August_September_October_November_December".split("_")},d=function(t,e,n){var r=String(t);return!r||r.length>=e?t:""+Array(e+1-r.length).join(n)+t},f={padStart:d,padZoneStr:function(t){var e=Math.abs(t),n=Math.floor(e/60),r=e%60;return(t<=0?"+":"-")+d(n,2,"0")+":"+d(r,2,"0")},monthDiff:function(t,e){var n=12*(e.year()-t.year())+(e.month()-t.month()),r=t.clone().add(n,"months"),s=e-r<0,i=t.clone().add(n+(s?-1:1),"months");return Number(-(n+(e-r)/(s?r-i:i-r)))},absFloor:function(t){return t<0?Math.ceil(t)||0:Math.floor(t)},prettyUnit:function(c){return{M:a,y:u,w:i,d:s,h:r,m:n,s:e,ms:t}[c]||String(c||"").toLowerCase().replace(/s$/,"")},isUndefined:function(t){return void 0===t}},$="en",l={};l[$]=h;var m=function(t){return t instanceof D},y=function(t,e,n){var r;if(!t)return null;if("string"==typeof t)l[t]&&(r=t),e&&(l[t]=e,r=t);else{var s=t.name;l[s]=t,r=s}return n||($=r),r},M=function(t,e){if(m(t))return t.clone();var n=e||{};return n.date=t,new D(n)},S=function(t,e){return M(t,{locale:e.$L})},p=f;p.parseLocale=y,p.isDayjs=m,p.wrapper=S;var D=function(){function h(t){this.parse(t)}var d=h.prototype;return d.parse=function(t){var e,n;this.$d=null===(e=t.date)?new Date(NaN):p.isUndefined(e)?new Date:e instanceof Date?e:"string"==typeof e&&/.*[^Z]$/i.test(e)&&(n=e.match(c))?new Date(n[1],n[2]-1,n[3]||1,n[5]||0,n[6]||0,n[7]||0,n[8]||0):new Date(e),this.init(t)},d.init=function(t){this.$y=this.$d.getFullYear(),this.$M=this.$d.getMonth(),this.$D=this.$d.getDate(),this.$W=this.$d.getDay(),this.$H=this.$d.getHours(),this.$m=this.$d.getMinutes(),this.$s=this.$d.getSeconds(),this.$ms=this.$d.getMilliseconds(),this.$L=this.$L||y(t.locale,null,!0)||$},d.$utils=function(){return p},d.isValid=function(){return!("Invalid Date"===this.$d.toString())},d.$compare=function(t){return this.valueOf()-M(t).valueOf()},d.isSame=function(t){return 0===this.$compare(t)},d.isBefore=function(t){return this.$compare(t)<0},d.isAfter=function(t){return this.$compare(t)>0},d.year=function(){return this.$y},d.month=function(){return this.$M},d.day=function(){return this.$W},d.date=function(){return this.$D},d.hour=function(){return this.$H},d.minute=function(){return this.$m},d.second=function(){return this.$s},d.millisecond=function(){return this.$ms},d.unix=function(){return Math.floor(this.valueOf()/1e3)},d.valueOf=function(){return this.$d.getTime()},d.startOf=function(t,c){var o=this,h=!!p.isUndefined(c)||c,d=function(t,e){var n=S(new Date(o.$y,e,t),o);return h?n:n.endOf(s)},f=function(t,e){return S(o.toDate()[t].apply(o.toDate(),h?[0,0,0,0].slice(e):[23,59,59,999].slice(e)),o)};switch(p.prettyUnit(t)){case u:return h?d(1,0):d(31,11);case a:return h?d(1,this.$M):d(0,this.$M+1);case i:return d(h?this.$D-this.$W:this.$D+(6-this.$W),this.$M);case s:case"date":return f("setHours",0);case r:return f("setMinutes",1);case n:return f("setSeconds",2);case e:return f("setMilliseconds",3);default:return this.clone()}},d.endOf=function(t){return this.startOf(t,!1)},d.$set=function(i,c){switch(p.prettyUnit(i)){case s:this.$d.setDate(this.$D+(c-this.$W));break;case"date":this.$d.setDate(c);break;case a:this.$d.setMonth(c);break;case u:this.$d.setFullYear(c);break;case r:this.$d.setHours(c);break;case n:this.$d.setMinutes(c);break;case e:this.$d.setSeconds(c);break;case t:this.$d.setMilliseconds(c)}return this.init(),this},d.set=function(t,e){return this.clone().$set(t,e)},d.add=function(t,c){var o=this;t=Number(t);var h,d=p.prettyUnit(c),f=function(e,n){var r=o.set("date",1).set(e,n+t);return r.set("date",Math.min(o.$D,r.daysInMonth()))},$=function(e){var n=new Date(o.$d);return n.setDate(n.getDate()+e*t),S(n,o)};if(d===a)return f(a,this.$M);if(d===u)return f(u,this.$y);if(d===s)return $(1);if(d===i)return $(7);switch(d){case n:h=6e4;break;case r:h=36e5;break;case e:h=1e3;break;default:h=1}var l=this.valueOf()+t*h;return S(l,this)},d.subtract=function(t,e){return this.add(-1*t,e)},d.format=function(t){var e=this,n=t||"YYYY-MM-DDTHH:mm:ssZ",r=p.padZoneStr(this.$d.getTimezoneOffset()),s=this.$locale(),i=s.weekdays,a=s.months,u=function(t,e,n,r){return t&&t[e]||n[e].substr(0,r)};return n.replace(o,function(t){if(t.indexOf("[")>-1)return t.replace(/\[|\]/g,"");switch(t){case"YY":return String(e.$y).slice(-2);case"YYYY":return String(e.$y);case"M":return String(e.$M+1);case"MM":return p.padStart(e.$M+1,2,"0");case"MMM":return u(s.monthsShort,e.$M,a,3);case"MMMM":return a[e.$M];case"D":return String(e.$D);case"DD":return p.padStart(e.$D,2,"0");case"d":return String(e.$W);case"dd":return u(s.weekdaysMin,e.$W,i,2);case"ddd":return u(s.weekdaysShort,e.$W,i,3);case"dddd":return i[e.$W];case"H":return String(e.$H);case"HH":return p.padStart(e.$H,2,"0");case"h":case"hh":return 0===e.$H?12:p.padStart(e.$H<13?e.$H:e.$H-12,"hh"===t?2:1,"0");case"a":return e.$H<12?"am":"pm";case"A":return e.$H<12?"AM":"PM";case"m":return String(e.$m);case"mm":return p.padStart(e.$m,2,"0");case"s":return String(e.$s);case"ss":return p.padStart(e.$s,2,"0");case"SSS":return p.padStart(e.$ms,3,"0");case"Z":return r;default:return r.replace(":","")}})},d.diff=function(t,c,o){var h=p.prettyUnit(c),d=M(t),f=this-d,$=p.monthDiff(this,d);switch(h){case u:$/=12;break;case a:break;case"quarter":$/=3;break;case i:$=f/6048e5;break;case s:$=f/864e5;break;case r:$=f/36e5;break;case n:$=f/6e4;break;case e:$=f/1e3;break;default:$=f}return o?$:p.absFloor($)},d.daysInMonth=function(){return this.endOf(a).$D},d.$locale=function(){return l[this.$L]},d.locale=function(t,e){var n=this.clone();return n.$L=y(t,e,!0),n},d.clone=function(){return S(this.toDate(),this)},d.toDate=function(){return new Date(this.$d)},d.toArray=function(){return[this.$y,this.$M,this.$D,this.$H,this.$m,this.$s,this.$ms]},d.toJSON=function(){return this.toISOString()},d.toISOString=function(){return this.toDate().toISOString()},d.toObject=function(){return{years:this.$y,months:this.$M,date:this.$D,hours:this.$H,minutes:this.$m,seconds:this.$s,milliseconds:this.$ms}},d.toString=function(){return this.$d.toUTCString()},h}();return M.extend=function(t,e){return t(e,D,M),M},M.locale=y,M.isDayjs=m,M.unix=function(t){return M(1e3*t)},M.en=l[$],M});


/***/ })

});