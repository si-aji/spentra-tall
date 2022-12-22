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

/***/ "./resources/js/sw.js":
/*!****************************!*\
  !*** ./resources/js/sw.js ***!
  \****************************/
/***/ (() => {

eval("var cacheName = 'spentra-pwa-v1';\nvar appShellFiles = [];\nvar contentToCache = appShellFiles; // Install Service Worker\n\nself.addEventListener('install', function (e) {}); // Fetch Asset\n\nself.addEventListener('fetch', function (e) {}); // Push Notification\n\nself.addEventListener('push', function (e) {\n  console.log('======= SW Push Add Event Listener =======');\n\n  if (!(self.Notification && self.Notification.permission === 'granted')) {\n    //notifications aren't supported or permission not granted!\n    return;\n  }\n\n  if (e.data) {\n    var msg = e.data.json();\n    console.log(msg);\n    e.waitUntil(self.registration.showNotification(msg.title, {\n      body: msg.body,\n      icon: msg.icon,\n      actions: msg.actions\n    }));\n  }\n});//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiLi9yZXNvdXJjZXMvanMvc3cuanMuanMiLCJuYW1lcyI6WyJjYWNoZU5hbWUiLCJhcHBTaGVsbEZpbGVzIiwiY29udGVudFRvQ2FjaGUiLCJzZWxmIiwiYWRkRXZlbnRMaXN0ZW5lciIsImUiLCJjb25zb2xlIiwibG9nIiwiTm90aWZpY2F0aW9uIiwicGVybWlzc2lvbiIsImRhdGEiLCJtc2ciLCJqc29uIiwid2FpdFVudGlsIiwicmVnaXN0cmF0aW9uIiwic2hvd05vdGlmaWNhdGlvbiIsInRpdGxlIiwiYm9keSIsImljb24iLCJhY3Rpb25zIl0sInNvdXJjZVJvb3QiOiIiLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvanMvc3cuanM/NDcyOSJdLCJzb3VyY2VzQ29udGVudCI6WyJjb25zdCBjYWNoZU5hbWUgPSAnc3BlbnRyYS1wd2EtdjEnO1xuY29uc3QgYXBwU2hlbGxGaWxlcyA9IFtdO1xuY29uc3QgY29udGVudFRvQ2FjaGUgPSBhcHBTaGVsbEZpbGVzO1xuXG4vLyBJbnN0YWxsIFNlcnZpY2UgV29ya2VyXG5zZWxmLmFkZEV2ZW50TGlzdGVuZXIoJ2luc3RhbGwnLCAoZSkgPT4ge1xufSk7XG5cbi8vIEZldGNoIEFzc2V0XG5zZWxmLmFkZEV2ZW50TGlzdGVuZXIoJ2ZldGNoJywgKGUpID0+IHtcbn0pO1xuXG4vLyBQdXNoIE5vdGlmaWNhdGlvblxuc2VsZi5hZGRFdmVudExpc3RlbmVyKCdwdXNoJywgKGUpID0+IHtcbiAgICBjb25zb2xlLmxvZygnPT09PT09PSBTVyBQdXNoIEFkZCBFdmVudCBMaXN0ZW5lciA9PT09PT09Jyk7XG4gICAgaWYgKCEoc2VsZi5Ob3RpZmljYXRpb24gJiYgc2VsZi5Ob3RpZmljYXRpb24ucGVybWlzc2lvbiA9PT0gJ2dyYW50ZWQnKSkge1xuICAgICAgICAvL25vdGlmaWNhdGlvbnMgYXJlbid0IHN1cHBvcnRlZCBvciBwZXJtaXNzaW9uIG5vdCBncmFudGVkIVxuICAgICAgICByZXR1cm47XG4gICAgfVxuXG4gICAgaWYgKGUuZGF0YSkge1xuICAgICAgICB2YXIgbXNnID0gZS5kYXRhLmpzb24oKTtcbiAgICAgICAgY29uc29sZS5sb2cobXNnKVxuICAgICAgICBlLndhaXRVbnRpbChzZWxmLnJlZ2lzdHJhdGlvbi5zaG93Tm90aWZpY2F0aW9uKG1zZy50aXRsZSwge1xuICAgICAgICAgICAgYm9keTogbXNnLmJvZHksXG4gICAgICAgICAgICBpY29uOiBtc2cuaWNvbixcbiAgICAgICAgICAgIGFjdGlvbnM6IG1zZy5hY3Rpb25zXG4gICAgICAgIH0pKTtcbiAgICB9XG59KTsgIl0sIm1hcHBpbmdzIjoiQUFBQSxJQUFNQSxTQUFTLEdBQUcsZ0JBQWxCO0FBQ0EsSUFBTUMsYUFBYSxHQUFHLEVBQXRCO0FBQ0EsSUFBTUMsY0FBYyxHQUFHRCxhQUF2QixDLENBRUE7O0FBQ0FFLElBQUksQ0FBQ0MsZ0JBQUwsQ0FBc0IsU0FBdEIsRUFBaUMsVUFBQ0MsQ0FBRCxFQUFPLENBQ3ZDLENBREQsRSxDQUdBOztBQUNBRixJQUFJLENBQUNDLGdCQUFMLENBQXNCLE9BQXRCLEVBQStCLFVBQUNDLENBQUQsRUFBTyxDQUNyQyxDQURELEUsQ0FHQTs7QUFDQUYsSUFBSSxDQUFDQyxnQkFBTCxDQUFzQixNQUF0QixFQUE4QixVQUFDQyxDQUFELEVBQU87RUFDakNDLE9BQU8sQ0FBQ0MsR0FBUixDQUFZLDRDQUFaOztFQUNBLElBQUksRUFBRUosSUFBSSxDQUFDSyxZQUFMLElBQXFCTCxJQUFJLENBQUNLLFlBQUwsQ0FBa0JDLFVBQWxCLEtBQWlDLFNBQXhELENBQUosRUFBd0U7SUFDcEU7SUFDQTtFQUNIOztFQUVELElBQUlKLENBQUMsQ0FBQ0ssSUFBTixFQUFZO0lBQ1IsSUFBSUMsR0FBRyxHQUFHTixDQUFDLENBQUNLLElBQUYsQ0FBT0UsSUFBUCxFQUFWO0lBQ0FOLE9BQU8sQ0FBQ0MsR0FBUixDQUFZSSxHQUFaO0lBQ0FOLENBQUMsQ0FBQ1EsU0FBRixDQUFZVixJQUFJLENBQUNXLFlBQUwsQ0FBa0JDLGdCQUFsQixDQUFtQ0osR0FBRyxDQUFDSyxLQUF2QyxFQUE4QztNQUN0REMsSUFBSSxFQUFFTixHQUFHLENBQUNNLElBRDRDO01BRXREQyxJQUFJLEVBQUVQLEdBQUcsQ0FBQ08sSUFGNEM7TUFHdERDLE9BQU8sRUFBRVIsR0FBRyxDQUFDUTtJQUh5QyxDQUE5QyxDQUFaO0VBS0g7QUFDSixDQWhCRCJ9\n//# sourceURL=webpack-internal:///./resources/js/sw.js\n");

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval-source-map devtool is used.
/******/ 	var __webpack_exports__ = {};
/******/ 	__webpack_modules__["./resources/js/sw.js"]();
/******/ 	
/******/ })()
;