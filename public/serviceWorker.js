/*
 * ATTENTION: An "eval-source-map" devtool has been used.
 * This devtool is neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file with attached SourceMaps in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/js/serviceWorker.js":
/*!***************************************!*\
  !*** ./resources/js/serviceWorker.js ***!
  \***************************************/
/***/ (() => {

eval("function _typeof(obj) { \"@babel/helpers - typeof\"; return _typeof = \"function\" == typeof Symbol && \"symbol\" == typeof Symbol.iterator ? function (obj) { return typeof obj; } : function (obj) { return obj && \"function\" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? \"symbol\" : typeof obj; }, _typeof(obj); }\n\nfunction _regeneratorRuntime() { \"use strict\"; /*! regenerator-runtime -- Copyright (c) 2014-present, Facebook, Inc. -- license (MIT): https://github.com/facebook/regenerator/blob/main/LICENSE */ _regeneratorRuntime = function _regeneratorRuntime() { return exports; }; var exports = {}, Op = Object.prototype, hasOwn = Op.hasOwnProperty, $Symbol = \"function\" == typeof Symbol ? Symbol : {}, iteratorSymbol = $Symbol.iterator || \"@@iterator\", asyncIteratorSymbol = $Symbol.asyncIterator || \"@@asyncIterator\", toStringTagSymbol = $Symbol.toStringTag || \"@@toStringTag\"; function define(obj, key, value) { return Object.defineProperty(obj, key, { value: value, enumerable: !0, configurable: !0, writable: !0 }), obj[key]; } try { define({}, \"\"); } catch (err) { define = function define(obj, key, value) { return obj[key] = value; }; } function wrap(innerFn, outerFn, self, tryLocsList) { var protoGenerator = outerFn && outerFn.prototype instanceof Generator ? outerFn : Generator, generator = Object.create(protoGenerator.prototype), context = new Context(tryLocsList || []); return generator._invoke = function (innerFn, self, context) { var state = \"suspendedStart\"; return function (method, arg) { if (\"executing\" === state) throw new Error(\"Generator is already running\"); if (\"completed\" === state) { if (\"throw\" === method) throw arg; return doneResult(); } for (context.method = method, context.arg = arg;;) { var delegate = context.delegate; if (delegate) { var delegateResult = maybeInvokeDelegate(delegate, context); if (delegateResult) { if (delegateResult === ContinueSentinel) continue; return delegateResult; } } if (\"next\" === context.method) context.sent = context._sent = context.arg;else if (\"throw\" === context.method) { if (\"suspendedStart\" === state) throw state = \"completed\", context.arg; context.dispatchException(context.arg); } else \"return\" === context.method && context.abrupt(\"return\", context.arg); state = \"executing\"; var record = tryCatch(innerFn, self, context); if (\"normal\" === record.type) { if (state = context.done ? \"completed\" : \"suspendedYield\", record.arg === ContinueSentinel) continue; return { value: record.arg, done: context.done }; } \"throw\" === record.type && (state = \"completed\", context.method = \"throw\", context.arg = record.arg); } }; }(innerFn, self, context), generator; } function tryCatch(fn, obj, arg) { try { return { type: \"normal\", arg: fn.call(obj, arg) }; } catch (err) { return { type: \"throw\", arg: err }; } } exports.wrap = wrap; var ContinueSentinel = {}; function Generator() {} function GeneratorFunction() {} function GeneratorFunctionPrototype() {} var IteratorPrototype = {}; define(IteratorPrototype, iteratorSymbol, function () { return this; }); var getProto = Object.getPrototypeOf, NativeIteratorPrototype = getProto && getProto(getProto(values([]))); NativeIteratorPrototype && NativeIteratorPrototype !== Op && hasOwn.call(NativeIteratorPrototype, iteratorSymbol) && (IteratorPrototype = NativeIteratorPrototype); var Gp = GeneratorFunctionPrototype.prototype = Generator.prototype = Object.create(IteratorPrototype); function defineIteratorMethods(prototype) { [\"next\", \"throw\", \"return\"].forEach(function (method) { define(prototype, method, function (arg) { return this._invoke(method, arg); }); }); } function AsyncIterator(generator, PromiseImpl) { function invoke(method, arg, resolve, reject) { var record = tryCatch(generator[method], generator, arg); if (\"throw\" !== record.type) { var result = record.arg, value = result.value; return value && \"object\" == _typeof(value) && hasOwn.call(value, \"__await\") ? PromiseImpl.resolve(value.__await).then(function (value) { invoke(\"next\", value, resolve, reject); }, function (err) { invoke(\"throw\", err, resolve, reject); }) : PromiseImpl.resolve(value).then(function (unwrapped) { result.value = unwrapped, resolve(result); }, function (error) { return invoke(\"throw\", error, resolve, reject); }); } reject(record.arg); } var previousPromise; this._invoke = function (method, arg) { function callInvokeWithMethodAndArg() { return new PromiseImpl(function (resolve, reject) { invoke(method, arg, resolve, reject); }); } return previousPromise = previousPromise ? previousPromise.then(callInvokeWithMethodAndArg, callInvokeWithMethodAndArg) : callInvokeWithMethodAndArg(); }; } function maybeInvokeDelegate(delegate, context) { var method = delegate.iterator[context.method]; if (undefined === method) { if (context.delegate = null, \"throw\" === context.method) { if (delegate.iterator[\"return\"] && (context.method = \"return\", context.arg = undefined, maybeInvokeDelegate(delegate, context), \"throw\" === context.method)) return ContinueSentinel; context.method = \"throw\", context.arg = new TypeError(\"The iterator does not provide a 'throw' method\"); } return ContinueSentinel; } var record = tryCatch(method, delegate.iterator, context.arg); if (\"throw\" === record.type) return context.method = \"throw\", context.arg = record.arg, context.delegate = null, ContinueSentinel; var info = record.arg; return info ? info.done ? (context[delegate.resultName] = info.value, context.next = delegate.nextLoc, \"return\" !== context.method && (context.method = \"next\", context.arg = undefined), context.delegate = null, ContinueSentinel) : info : (context.method = \"throw\", context.arg = new TypeError(\"iterator result is not an object\"), context.delegate = null, ContinueSentinel); } function pushTryEntry(locs) { var entry = { tryLoc: locs[0] }; 1 in locs && (entry.catchLoc = locs[1]), 2 in locs && (entry.finallyLoc = locs[2], entry.afterLoc = locs[3]), this.tryEntries.push(entry); } function resetTryEntry(entry) { var record = entry.completion || {}; record.type = \"normal\", delete record.arg, entry.completion = record; } function Context(tryLocsList) { this.tryEntries = [{ tryLoc: \"root\" }], tryLocsList.forEach(pushTryEntry, this), this.reset(!0); } function values(iterable) { if (iterable) { var iteratorMethod = iterable[iteratorSymbol]; if (iteratorMethod) return iteratorMethod.call(iterable); if (\"function\" == typeof iterable.next) return iterable; if (!isNaN(iterable.length)) { var i = -1, next = function next() { for (; ++i < iterable.length;) { if (hasOwn.call(iterable, i)) return next.value = iterable[i], next.done = !1, next; } return next.value = undefined, next.done = !0, next; }; return next.next = next; } } return { next: doneResult }; } function doneResult() { return { value: undefined, done: !0 }; } return GeneratorFunction.prototype = GeneratorFunctionPrototype, define(Gp, \"constructor\", GeneratorFunctionPrototype), define(GeneratorFunctionPrototype, \"constructor\", GeneratorFunction), GeneratorFunction.displayName = define(GeneratorFunctionPrototype, toStringTagSymbol, \"GeneratorFunction\"), exports.isGeneratorFunction = function (genFun) { var ctor = \"function\" == typeof genFun && genFun.constructor; return !!ctor && (ctor === GeneratorFunction || \"GeneratorFunction\" === (ctor.displayName || ctor.name)); }, exports.mark = function (genFun) { return Object.setPrototypeOf ? Object.setPrototypeOf(genFun, GeneratorFunctionPrototype) : (genFun.__proto__ = GeneratorFunctionPrototype, define(genFun, toStringTagSymbol, \"GeneratorFunction\")), genFun.prototype = Object.create(Gp), genFun; }, exports.awrap = function (arg) { return { __await: arg }; }, defineIteratorMethods(AsyncIterator.prototype), define(AsyncIterator.prototype, asyncIteratorSymbol, function () { return this; }), exports.AsyncIterator = AsyncIterator, exports.async = function (innerFn, outerFn, self, tryLocsList, PromiseImpl) { void 0 === PromiseImpl && (PromiseImpl = Promise); var iter = new AsyncIterator(wrap(innerFn, outerFn, self, tryLocsList), PromiseImpl); return exports.isGeneratorFunction(outerFn) ? iter : iter.next().then(function (result) { return result.done ? result.value : iter.next(); }); }, defineIteratorMethods(Gp), define(Gp, toStringTagSymbol, \"Generator\"), define(Gp, iteratorSymbol, function () { return this; }), define(Gp, \"toString\", function () { return \"[object Generator]\"; }), exports.keys = function (object) { var keys = []; for (var key in object) { keys.push(key); } return keys.reverse(), function next() { for (; keys.length;) { var key = keys.pop(); if (key in object) return next.value = key, next.done = !1, next; } return next.done = !0, next; }; }, exports.values = values, Context.prototype = { constructor: Context, reset: function reset(skipTempReset) { if (this.prev = 0, this.next = 0, this.sent = this._sent = undefined, this.done = !1, this.delegate = null, this.method = \"next\", this.arg = undefined, this.tryEntries.forEach(resetTryEntry), !skipTempReset) for (var name in this) { \"t\" === name.charAt(0) && hasOwn.call(this, name) && !isNaN(+name.slice(1)) && (this[name] = undefined); } }, stop: function stop() { this.done = !0; var rootRecord = this.tryEntries[0].completion; if (\"throw\" === rootRecord.type) throw rootRecord.arg; return this.rval; }, dispatchException: function dispatchException(exception) { if (this.done) throw exception; var context = this; function handle(loc, caught) { return record.type = \"throw\", record.arg = exception, context.next = loc, caught && (context.method = \"next\", context.arg = undefined), !!caught; } for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i], record = entry.completion; if (\"root\" === entry.tryLoc) return handle(\"end\"); if (entry.tryLoc <= this.prev) { var hasCatch = hasOwn.call(entry, \"catchLoc\"), hasFinally = hasOwn.call(entry, \"finallyLoc\"); if (hasCatch && hasFinally) { if (this.prev < entry.catchLoc) return handle(entry.catchLoc, !0); if (this.prev < entry.finallyLoc) return handle(entry.finallyLoc); } else if (hasCatch) { if (this.prev < entry.catchLoc) return handle(entry.catchLoc, !0); } else { if (!hasFinally) throw new Error(\"try statement without catch or finally\"); if (this.prev < entry.finallyLoc) return handle(entry.finallyLoc); } } } }, abrupt: function abrupt(type, arg) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.tryLoc <= this.prev && hasOwn.call(entry, \"finallyLoc\") && this.prev < entry.finallyLoc) { var finallyEntry = entry; break; } } finallyEntry && (\"break\" === type || \"continue\" === type) && finallyEntry.tryLoc <= arg && arg <= finallyEntry.finallyLoc && (finallyEntry = null); var record = finallyEntry ? finallyEntry.completion : {}; return record.type = type, record.arg = arg, finallyEntry ? (this.method = \"next\", this.next = finallyEntry.finallyLoc, ContinueSentinel) : this.complete(record); }, complete: function complete(record, afterLoc) { if (\"throw\" === record.type) throw record.arg; return \"break\" === record.type || \"continue\" === record.type ? this.next = record.arg : \"return\" === record.type ? (this.rval = this.arg = record.arg, this.method = \"return\", this.next = \"end\") : \"normal\" === record.type && afterLoc && (this.next = afterLoc), ContinueSentinel; }, finish: function finish(finallyLoc) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.finallyLoc === finallyLoc) return this.complete(entry.completion, entry.afterLoc), resetTryEntry(entry), ContinueSentinel; } }, \"catch\": function _catch(tryLoc) { for (var i = this.tryEntries.length - 1; i >= 0; --i) { var entry = this.tryEntries[i]; if (entry.tryLoc === tryLoc) { var record = entry.completion; if (\"throw\" === record.type) { var thrown = record.arg; resetTryEntry(entry); } return thrown; } } throw new Error(\"illegal catch attempt\"); }, delegateYield: function delegateYield(iterable, resultName, nextLoc) { return this.delegate = { iterator: values(iterable), resultName: resultName, nextLoc: nextLoc }, \"next\" === this.method && (this.arg = undefined), ContinueSentinel; } }, exports; }\n\nfunction _createForOfIteratorHelper(o, allowArrayLike) { var it = typeof Symbol !== \"undefined\" && o[Symbol.iterator] || o[\"@@iterator\"]; if (!it) { if (Array.isArray(o) || (it = _unsupportedIterableToArray(o)) || allowArrayLike && o && typeof o.length === \"number\") { if (it) o = it; var i = 0; var F = function F() {}; return { s: F, n: function n() { if (i >= o.length) return { done: true }; return { done: false, value: o[i++] }; }, e: function e(_e) { throw _e; }, f: F }; } throw new TypeError(\"Invalid attempt to iterate non-iterable instance.\\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.\"); } var normalCompletion = true, didErr = false, err; return { s: function s() { it = it.call(o); }, n: function n() { var step = it.next(); normalCompletion = step.done; return step; }, e: function e(_e2) { didErr = true; err = _e2; }, f: function f() { try { if (!normalCompletion && it[\"return\"] != null) it[\"return\"](); } finally { if (didErr) throw err; } } }; }\n\nfunction _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === \"string\") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === \"Object\" && o.constructor) n = o.constructor.name; if (n === \"Map\" || n === \"Set\") return Array.from(o); if (n === \"Arguments\" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }\n\nfunction _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }\n\nfunction asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }\n\nfunction _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, \"next\", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, \"throw\", err); } _next(undefined); }); }; }\n\nvar cacheName = 'spentra-pwa-v1';\nvar appShellFiles = [];\nvar contentToCache = appShellFiles; // Install Service Worker\n\nself.addEventListener('install', function (e) {\n  // console.log(\"===== Installed =====\");\n  self.skipWaiting();\n}); // Fetch Asset\n\nself.addEventListener('fetch', function (e) {// console.log(\"===== Fetch =====\");\n}); // Push Notification\n\nself.addEventListener('push', function (e) {\n  // console.log('===== SW Push Add Event Listener =====');\n  // console.log(e);\n  // console.log(e.data);\n  if (!(self.Notification && self.Notification.permission === 'granted')) {\n    //notifications aren't supported or permission not granted!\n    return;\n  }\n\n  if (e.data) {\n    var _msg$data;\n\n    var msg = e.data.json();\n    console.log(msg);\n    e.waitUntil(self.registration.showNotification(msg.title, {\n      body: msg.body,\n      icon: msg.icon,\n      actions: msg.actions,\n      data: (_msg$data = msg.data) !== null && _msg$data !== void 0 ? _msg$data : null\n    }));\n  }\n});\nself.addEventListener('notificationclick', function (event) {\n  event.notification.close();\n  console.log(\"Notification is clicked\"); // console.log(event);\n  // clients.openWindow(`${baseUrl}/${event.action}`);\n\n  event.waitUntil(_asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee() {\n    var actionTarget, _actionUrl, allClients, _iterator, _step, client, url, _allClients, _iterator2, _step2, _client, _url, splitUrl, splitTargetUrl;\n\n    return _regeneratorRuntime().wrap(function _callee$(_context) {\n      while (1) {\n        switch (_context.prev = _context.next) {\n          case 0:\n            actionTarget = event.action;\n\n            if (!(actionTarget !== '')) {\n              _context.next = 29;\n              break;\n            }\n\n            _actionUrl = new URL(actionTarget);\n            console.log(_actionUrl);\n            _context.next = 6;\n            return clients.matchAll({\n              includeUncontrolled: true\n            });\n\n          case 6:\n            allClients = _context.sent;\n            // Let's see if we already have a chat window open:\n            _iterator = _createForOfIteratorHelper(allClients);\n            _context.prev = 8;\n\n            _iterator.s();\n\n          case 10:\n            if ((_step = _iterator.n()).done) {\n              _context.next = 18;\n              break;\n            }\n\n            client = _step.value;\n            url = new URL(client.url);\n            console.log(url);\n\n            if (!(url.pathname === _actionUrl.pathname)) {\n              _context.next = 16;\n              break;\n            }\n\n            return _context.abrupt(\"return\", client.focus());\n\n          case 16:\n            _context.next = 10;\n            break;\n\n          case 18:\n            _context.next = 23;\n            break;\n\n          case 20:\n            _context.prev = 20;\n            _context.t0 = _context[\"catch\"](8);\n\n            _iterator.e(_context.t0);\n\n          case 23:\n            _context.prev = 23;\n\n            _iterator.f();\n\n            return _context.finish(23);\n\n          case 26:\n            clients.openWindow(_actionUrl.pathname);\n            _context.next = 60;\n            break;\n\n          case 29:\n            if (!event.notification.data) {\n              _context.next = 60;\n              break;\n            }\n\n            if (!event.notification.data.url) {\n              _context.next = 60;\n              break;\n            }\n\n            actionUrl = new URL(event.notification.data.url);\n            _context.next = 34;\n            return clients.matchAll({\n              includeUncontrolled: true\n            });\n\n          case 34:\n            _allClients = _context.sent;\n            // Let's see if we already have a chat window open:\n            _iterator2 = _createForOfIteratorHelper(_allClients);\n            _context.prev = 36;\n\n            _iterator2.s();\n\n          case 38:\n            if ((_step2 = _iterator2.n()).done) {\n              _context.next = 51;\n              break;\n            }\n\n            _client = _step2.value;\n            _url = new URL(_client.url);\n\n            if (!(_url.pathname === actionUrl.pathname)) {\n              _context.next = 45;\n              break;\n            }\n\n            return _context.abrupt(\"return\", _client.focus());\n\n          case 45:\n            splitUrl = _url.pathname.split('/');\n            splitTargetUrl = actionUrl.pathname.split('/');\n\n            if (!(splitUrl[1] === splitTargetUrl[1])) {\n              _context.next = 49;\n              break;\n            }\n\n            return _context.abrupt(\"return\", _client.navigate(actionUrl.pathname).then(function (client) {\n              return client.focus();\n            }));\n\n          case 49:\n            _context.next = 38;\n            break;\n\n          case 51:\n            _context.next = 56;\n            break;\n\n          case 53:\n            _context.prev = 53;\n            _context.t1 = _context[\"catch\"](36);\n\n            _iterator2.e(_context.t1);\n\n          case 56:\n            _context.prev = 56;\n\n            _iterator2.f();\n\n            return _context.finish(56);\n\n          case 59:\n            clients.openWindow(actionUrl.pathname);\n\n          case 60:\n          case \"end\":\n            return _context.stop();\n        }\n      }\n    }, _callee, null, [[8, 20, 23, 26], [36, 53, 56, 59]]);\n  }))());\n}, false);//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiLi9yZXNvdXJjZXMvanMvc2VydmljZVdvcmtlci5qcy5qcyIsIm5hbWVzIjpbImNhY2hlTmFtZSIsImFwcFNoZWxsRmlsZXMiLCJjb250ZW50VG9DYWNoZSIsInNlbGYiLCJhZGRFdmVudExpc3RlbmVyIiwiZSIsInNraXBXYWl0aW5nIiwiTm90aWZpY2F0aW9uIiwicGVybWlzc2lvbiIsImRhdGEiLCJtc2ciLCJqc29uIiwiY29uc29sZSIsImxvZyIsIndhaXRVbnRpbCIsInJlZ2lzdHJhdGlvbiIsInNob3dOb3RpZmljYXRpb24iLCJ0aXRsZSIsImJvZHkiLCJpY29uIiwiYWN0aW9ucyIsImV2ZW50Iiwibm90aWZpY2F0aW9uIiwiY2xvc2UiLCJhY3Rpb25UYXJnZXQiLCJhY3Rpb24iLCJhY3Rpb25VcmwiLCJVUkwiLCJjbGllbnRzIiwibWF0Y2hBbGwiLCJpbmNsdWRlVW5jb250cm9sbGVkIiwiYWxsQ2xpZW50cyIsImNsaWVudCIsInVybCIsInBhdGhuYW1lIiwiZm9jdXMiLCJvcGVuV2luZG93Iiwic3BsaXRVcmwiLCJzcGxpdCIsInNwbGl0VGFyZ2V0VXJsIiwibmF2aWdhdGUiLCJ0aGVuIl0sInNvdXJjZVJvb3QiOiIiLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvanMvc2VydmljZVdvcmtlci5qcz9iZjY1Il0sInNvdXJjZXNDb250ZW50IjpbImNvbnN0IGNhY2hlTmFtZSA9ICdzcGVudHJhLXB3YS12MSc7XG5jb25zdCBhcHBTaGVsbEZpbGVzID0gW107XG5jb25zdCBjb250ZW50VG9DYWNoZSA9IGFwcFNoZWxsRmlsZXM7XG5cbi8vIEluc3RhbGwgU2VydmljZSBXb3JrZXJcbnNlbGYuYWRkRXZlbnRMaXN0ZW5lcignaW5zdGFsbCcsIChlKSA9PiB7XG4gICAgLy8gY29uc29sZS5sb2coXCI9PT09PSBJbnN0YWxsZWQgPT09PT1cIik7XG4gICAgc2VsZi5za2lwV2FpdGluZygpO1xufSk7XG5cbi8vIEZldGNoIEFzc2V0XG5zZWxmLmFkZEV2ZW50TGlzdGVuZXIoJ2ZldGNoJywgKGUpID0+IHtcbiAgICAvLyBjb25zb2xlLmxvZyhcIj09PT09IEZldGNoID09PT09XCIpO1xufSk7XG5cbi8vIFB1c2ggTm90aWZpY2F0aW9uXG5zZWxmLmFkZEV2ZW50TGlzdGVuZXIoJ3B1c2gnLCAoZSkgPT4ge1xuICAgIC8vIGNvbnNvbGUubG9nKCc9PT09PSBTVyBQdXNoIEFkZCBFdmVudCBMaXN0ZW5lciA9PT09PScpO1xuICAgIC8vIGNvbnNvbGUubG9nKGUpO1xuICAgIC8vIGNvbnNvbGUubG9nKGUuZGF0YSk7XG4gICAgaWYgKCEoc2VsZi5Ob3RpZmljYXRpb24gJiYgc2VsZi5Ob3RpZmljYXRpb24ucGVybWlzc2lvbiA9PT0gJ2dyYW50ZWQnKSkge1xuICAgICAgICAvL25vdGlmaWNhdGlvbnMgYXJlbid0IHN1cHBvcnRlZCBvciBwZXJtaXNzaW9uIG5vdCBncmFudGVkIVxuICAgICAgICByZXR1cm47XG4gICAgfVxuXG4gICAgaWYgKGUuZGF0YSkge1xuICAgICAgICB2YXIgbXNnID0gZS5kYXRhLmpzb24oKTtcbiAgICAgICAgY29uc29sZS5sb2cobXNnKTtcbiAgICAgICAgZS53YWl0VW50aWwoc2VsZi5yZWdpc3RyYXRpb24uc2hvd05vdGlmaWNhdGlvbihtc2cudGl0bGUsIHtcbiAgICAgICAgICAgIGJvZHk6IG1zZy5ib2R5LFxuICAgICAgICAgICAgaWNvbjogbXNnLmljb24sXG4gICAgICAgICAgICBhY3Rpb25zOiBtc2cuYWN0aW9ucyxcbiAgICAgICAgICAgIGRhdGE6IG1zZy5kYXRhID8/IG51bGxcbiAgICAgICAgfSkpO1xuICAgIH1cbn0pOyBcbnNlbGYuYWRkRXZlbnRMaXN0ZW5lcignbm90aWZpY2F0aW9uY2xpY2snLCBmdW5jdGlvbihldmVudCkge1xuICAgIGV2ZW50Lm5vdGlmaWNhdGlvbi5jbG9zZSgpO1xuICAgIGNvbnNvbGUubG9nKFwiTm90aWZpY2F0aW9uIGlzIGNsaWNrZWRcIik7XG4gICAgLy8gY29uc29sZS5sb2coZXZlbnQpO1xuICAgIC8vIGNsaWVudHMub3BlbldpbmRvdyhgJHtiYXNlVXJsfS8ke2V2ZW50LmFjdGlvbn1gKTtcblxuICAgIGV2ZW50LndhaXRVbnRpbCgoYXN5bmMgKCkgPT4ge1xuICAgICAgICBsZXQgYWN0aW9uVGFyZ2V0ID0gZXZlbnQuYWN0aW9uO1xuXG4gICAgICAgIGlmKGFjdGlvblRhcmdldCAhPT0gJycpe1xuICAgICAgICAgICAgbGV0IGFjdGlvblVybCA9IG5ldyBVUkwoYWN0aW9uVGFyZ2V0KTtcbiAgICAgICAgICAgIGNvbnNvbGUubG9nKGFjdGlvblVybCk7XG4gICAgICAgICAgICBjb25zdCBhbGxDbGllbnRzID0gYXdhaXQgY2xpZW50cy5tYXRjaEFsbCh7XG4gICAgICAgICAgICAgICAgaW5jbHVkZVVuY29udHJvbGxlZDogdHJ1ZVxuICAgICAgICAgICAgfSk7XG5cbiAgICAgICAgICAgIC8vIExldCdzIHNlZSBpZiB3ZSBhbHJlYWR5IGhhdmUgYSBjaGF0IHdpbmRvdyBvcGVuOlxuICAgICAgICAgICAgZm9yIChjb25zdCBjbGllbnQgb2YgYWxsQ2xpZW50cykge1xuICAgICAgICAgICAgICAgIGNvbnN0IHVybCA9IG5ldyBVUkwoY2xpZW50LnVybCk7XG4gICAgICAgICAgICAgICAgY29uc29sZS5sb2codXJsKTtcbiAgICAgICAgXG4gICAgICAgICAgICAgICAgaWYodXJsLnBhdGhuYW1lID09PSBhY3Rpb25VcmwucGF0aG5hbWUpe1xuICAgICAgICAgICAgICAgICAgICByZXR1cm4gY2xpZW50LmZvY3VzKCk7XG4gICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICBjbGllbnRzLm9wZW5XaW5kb3coYWN0aW9uVXJsLnBhdGhuYW1lKTtcbiAgICAgICAgfSBlbHNlIGlmKGV2ZW50Lm5vdGlmaWNhdGlvbi5kYXRhKXtcbiAgICAgICAgICAgIGlmKGV2ZW50Lm5vdGlmaWNhdGlvbi5kYXRhLnVybCl7XG4gICAgICAgICAgICAgICAgYWN0aW9uVXJsID0gbmV3IFVSTChldmVudC5ub3RpZmljYXRpb24uZGF0YS51cmwpO1xuICAgICAgICAgICAgICAgIGNvbnN0IGFsbENsaWVudHMgPSBhd2FpdCBjbGllbnRzLm1hdGNoQWxsKHtcbiAgICAgICAgICAgICAgICAgICAgaW5jbHVkZVVuY29udHJvbGxlZDogdHJ1ZVxuICAgICAgICAgICAgICAgIH0pO1xuICAgIFxuICAgICAgICAgICAgICAgIC8vIExldCdzIHNlZSBpZiB3ZSBhbHJlYWR5IGhhdmUgYSBjaGF0IHdpbmRvdyBvcGVuOlxuICAgICAgICAgICAgICAgIGZvciAoY29uc3QgY2xpZW50IG9mIGFsbENsaWVudHMpIHtcbiAgICAgICAgICAgICAgICAgICAgY29uc3QgdXJsID0gbmV3IFVSTChjbGllbnQudXJsKTtcbiAgICAgICAgICAgICAgICAgICAgaWYodXJsLnBhdGhuYW1lID09PSBhY3Rpb25VcmwucGF0aG5hbWUpe1xuICAgICAgICAgICAgICAgICAgICAgICAgcmV0dXJuIGNsaWVudC5mb2N1cygpO1xuICAgICAgICAgICAgICAgICAgICB9IGVsc2Uge1xuICAgICAgICAgICAgICAgICAgICAgICAgbGV0IHNwbGl0VXJsID0gKHVybC5wYXRobmFtZSkuc3BsaXQoJy8nKTtcbiAgICAgICAgICAgICAgICAgICAgICAgIGxldCBzcGxpdFRhcmdldFVybCA9IChhY3Rpb25VcmwucGF0aG5hbWUpLnNwbGl0KCcvJyk7XG5cbiAgICAgICAgICAgICAgICAgICAgICAgIGlmKHNwbGl0VXJsWzFdID09PSBzcGxpdFRhcmdldFVybFsxXSl7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgcmV0dXJuIGNsaWVudC5uYXZpZ2F0ZShhY3Rpb25VcmwucGF0aG5hbWUpLnRoZW4oY2xpZW50ID0+IGNsaWVudC5mb2N1cygpKTtcbiAgICAgICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgIH1cbiAgICBcbiAgICAgICAgICAgICAgICBjbGllbnRzLm9wZW5XaW5kb3coYWN0aW9uVXJsLnBhdGhuYW1lKTtcbiAgICAgICAgICAgIH1cbiAgICAgICAgfVxuICAgIH0pKCkpO1xufSwgZmFsc2UpOyJdLCJtYXBwaW5ncyI6Ijs7K0NBQ0Esb0o7Ozs7Ozs7Ozs7OztBQURBLElBQU1BLFNBQVMsR0FBRyxnQkFBbEI7QUFDQSxJQUFNQyxhQUFhLEdBQUcsRUFBdEI7QUFDQSxJQUFNQyxjQUFjLEdBQUdELGFBQXZCLEMsQ0FFQTs7QUFDQUUsSUFBSSxDQUFDQyxnQkFBTCxDQUFzQixTQUF0QixFQUFpQyxVQUFDQyxDQUFELEVBQU87RUFDcEM7RUFDQUYsSUFBSSxDQUFDRyxXQUFMO0FBQ0gsQ0FIRCxFLENBS0E7O0FBQ0FILElBQUksQ0FBQ0MsZ0JBQUwsQ0FBc0IsT0FBdEIsRUFBK0IsVUFBQ0MsQ0FBRCxFQUFPLENBQ2xDO0FBQ0gsQ0FGRCxFLENBSUE7O0FBQ0FGLElBQUksQ0FBQ0MsZ0JBQUwsQ0FBc0IsTUFBdEIsRUFBOEIsVUFBQ0MsQ0FBRCxFQUFPO0VBQ2pDO0VBQ0E7RUFDQTtFQUNBLElBQUksRUFBRUYsSUFBSSxDQUFDSSxZQUFMLElBQXFCSixJQUFJLENBQUNJLFlBQUwsQ0FBa0JDLFVBQWxCLEtBQWlDLFNBQXhELENBQUosRUFBd0U7SUFDcEU7SUFDQTtFQUNIOztFQUVELElBQUlILENBQUMsQ0FBQ0ksSUFBTixFQUFZO0lBQUE7O0lBQ1IsSUFBSUMsR0FBRyxHQUFHTCxDQUFDLENBQUNJLElBQUYsQ0FBT0UsSUFBUCxFQUFWO0lBQ0FDLE9BQU8sQ0FBQ0MsR0FBUixDQUFZSCxHQUFaO0lBQ0FMLENBQUMsQ0FBQ1MsU0FBRixDQUFZWCxJQUFJLENBQUNZLFlBQUwsQ0FBa0JDLGdCQUFsQixDQUFtQ04sR0FBRyxDQUFDTyxLQUF2QyxFQUE4QztNQUN0REMsSUFBSSxFQUFFUixHQUFHLENBQUNRLElBRDRDO01BRXREQyxJQUFJLEVBQUVULEdBQUcsQ0FBQ1MsSUFGNEM7TUFHdERDLE9BQU8sRUFBRVYsR0FBRyxD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\n//# sourceURL=webpack-internal:///./resources/js/serviceWorker.js\n");

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval-source-map devtool is used.
/******/ 	var __webpack_exports__ = {};
/******/ 	__webpack_modules__["./resources/js/serviceWorker.js"]();
/******/ 	
/******/ })()
;