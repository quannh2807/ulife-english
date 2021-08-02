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

/***/ "./resources/js/app.js":
/*!*****************************!*\
  !*** ./resources/js/app.js ***!
  \*****************************/
/***/ (() => {

eval("$(document).ready(function () {\n  /*** add active class and stay opened when selected ***/\n  var url = window.location; // for sidebar menu entirely but not cover treeview\n\n  $('ul.nav-sidebar a').filter(function () {\n    if (this.href) {\n      return this.href === url || url.href.indexOf(this.href) === 0;\n    }\n  }).addClass('active'); // for the treeview\n\n  $('ul.nav-treeview a').filter(function () {\n    if (this.href) {\n      return this.href === url || url.href.indexOf(this.href) === 0;\n    }\n  }).parentsUntil(\".nav-sidebar > .nav-treeview\").addClass('menu-open').prev('a').addClass('active');\n});//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvanMvYXBwLmpzPzZkNDAiXSwibmFtZXMiOlsiJCIsImRvY3VtZW50IiwicmVhZHkiLCJ1cmwiLCJ3aW5kb3ciLCJsb2NhdGlvbiIsImZpbHRlciIsImhyZWYiLCJpbmRleE9mIiwiYWRkQ2xhc3MiLCJwYXJlbnRzVW50aWwiLCJwcmV2Il0sIm1hcHBpbmdzIjoiQUFBQUEsQ0FBQyxDQUFDQyxRQUFELENBQUQsQ0FBWUMsS0FBWixDQUFrQixZQUFNO0FBQ3BCO0FBQ0EsTUFBSUMsR0FBRyxHQUFHQyxNQUFNLENBQUNDLFFBQWpCLENBRm9CLENBSXBCOztBQUNBTCxFQUFBQSxDQUFDLENBQUMsa0JBQUQsQ0FBRCxDQUFzQk0sTUFBdEIsQ0FBNkIsWUFBWTtBQUNyQyxRQUFJLEtBQUtDLElBQVQsRUFBZTtBQUNYLGFBQU8sS0FBS0EsSUFBTCxLQUFjSixHQUFkLElBQXFCQSxHQUFHLENBQUNJLElBQUosQ0FBU0MsT0FBVCxDQUFpQixLQUFLRCxJQUF0QixNQUFnQyxDQUE1RDtBQUNIO0FBQ0osR0FKRCxFQUlHRSxRQUpILENBSVksUUFKWixFQUxvQixDQVdwQjs7QUFDQVQsRUFBQUEsQ0FBQyxDQUFDLG1CQUFELENBQUQsQ0FBdUJNLE1BQXZCLENBQThCLFlBQVk7QUFDdEMsUUFBSSxLQUFLQyxJQUFULEVBQWU7QUFDWCxhQUFPLEtBQUtBLElBQUwsS0FBY0osR0FBZCxJQUFxQkEsR0FBRyxDQUFDSSxJQUFKLENBQVNDLE9BQVQsQ0FBaUIsS0FBS0QsSUFBdEIsTUFBZ0MsQ0FBNUQ7QUFDSDtBQUNKLEdBSkQsRUFJR0csWUFKSCxDQUlnQiw4QkFKaEIsRUFJZ0RELFFBSmhELENBSXlELFdBSnpELEVBSXNFRSxJQUp0RSxDQUkyRSxHQUozRSxFQUlnRkYsUUFKaEYsQ0FJeUYsUUFKekY7QUFLSCxDQWpCRCIsInNvdXJjZXNDb250ZW50IjpbIiQoZG9jdW1lbnQpLnJlYWR5KCgpID0+IHtcclxuICAgIC8qKiogYWRkIGFjdGl2ZSBjbGFzcyBhbmQgc3RheSBvcGVuZWQgd2hlbiBzZWxlY3RlZCAqKiovXHJcbiAgICB2YXIgdXJsID0gd2luZG93LmxvY2F0aW9uO1xyXG5cclxuICAgIC8vIGZvciBzaWRlYmFyIG1lbnUgZW50aXJlbHkgYnV0IG5vdCBjb3ZlciB0cmVldmlld1xyXG4gICAgJCgndWwubmF2LXNpZGViYXIgYScpLmZpbHRlcihmdW5jdGlvbiAoKSB7XHJcbiAgICAgICAgaWYgKHRoaXMuaHJlZikge1xyXG4gICAgICAgICAgICByZXR1cm4gdGhpcy5ocmVmID09PSB1cmwgfHwgdXJsLmhyZWYuaW5kZXhPZih0aGlzLmhyZWYpID09PSAwO1xyXG4gICAgICAgIH1cclxuICAgIH0pLmFkZENsYXNzKCdhY3RpdmUnKTtcclxuXHJcbiAgICAvLyBmb3IgdGhlIHRyZWV2aWV3XHJcbiAgICAkKCd1bC5uYXYtdHJlZXZpZXcgYScpLmZpbHRlcihmdW5jdGlvbiAoKSB7XHJcbiAgICAgICAgaWYgKHRoaXMuaHJlZikge1xyXG4gICAgICAgICAgICByZXR1cm4gdGhpcy5ocmVmID09PSB1cmwgfHwgdXJsLmhyZWYuaW5kZXhPZih0aGlzLmhyZWYpID09PSAwO1xyXG4gICAgICAgIH1cclxuICAgIH0pLnBhcmVudHNVbnRpbChcIi5uYXYtc2lkZWJhciA+IC5uYXYtdHJlZXZpZXdcIikuYWRkQ2xhc3MoJ21lbnUtb3BlbicpLnByZXYoJ2EnKS5hZGRDbGFzcygnYWN0aXZlJyk7XHJcbn0pO1xyXG4iXSwiZmlsZSI6Ii4vcmVzb3VyY2VzL2pzL2FwcC5qcy5qcyIsInNvdXJjZVJvb3QiOiIifQ==\n//# sourceURL=webpack-internal:///./resources/js/app.js\n");

/***/ }),

/***/ "./resources/sass/app.scss":
/*!*********************************!*\
  !*** ./resources/sass/app.scss ***!
  \*********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n// extracted by mini-css-extract-plugin\n//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvc2Fzcy9hcHAuc2Nzcz80NzVmIl0sIm5hbWVzIjpbXSwibWFwcGluZ3MiOiI7QUFBQSIsImZpbGUiOiIuL3Jlc291cmNlcy9zYXNzL2FwcC5zY3NzLmpzIiwic291cmNlc0NvbnRlbnQiOlsiLy8gZXh0cmFjdGVkIGJ5IG1pbmktY3NzLWV4dHJhY3QtcGx1Z2luXG5leHBvcnQge307Il0sInNvdXJjZVJvb3QiOiIifQ==\n//# sourceURL=webpack-internal:///./resources/sass/app.scss\n");

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = __webpack_modules__;
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/chunk loaded */
/******/ 	(() => {
/******/ 		var deferred = [];
/******/ 		__webpack_require__.O = (result, chunkIds, fn, priority) => {
/******/ 			if(chunkIds) {
/******/ 				priority = priority || 0;
/******/ 				for(var i = deferred.length; i > 0 && deferred[i - 1][2] > priority; i--) deferred[i] = deferred[i - 1];
/******/ 				deferred[i] = [chunkIds, fn, priority];
/******/ 				return;
/******/ 			}
/******/ 			var notFulfilled = Infinity;
/******/ 			for (var i = 0; i < deferred.length; i++) {
/******/ 				var [chunkIds, fn, priority] = deferred[i];
/******/ 				var fulfilled = true;
/******/ 				for (var j = 0; j < chunkIds.length; j++) {
/******/ 					if ((priority & 1 === 0 || notFulfilled >= priority) && Object.keys(__webpack_require__.O).every((key) => (__webpack_require__.O[key](chunkIds[j])))) {
/******/ 						chunkIds.splice(j--, 1);
/******/ 					} else {
/******/ 						fulfilled = false;
/******/ 						if(priority < notFulfilled) notFulfilled = priority;
/******/ 					}
/******/ 				}
/******/ 				if(fulfilled) {
/******/ 					deferred.splice(i--, 1)
/******/ 					result = fn();
/******/ 				}
/******/ 			}
/******/ 			return result;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/jsonp chunk loading */
/******/ 	(() => {
/******/ 		// no baseURI
/******/ 		
/******/ 		// object to store loaded and loading chunks
/******/ 		// undefined = chunk not loaded, null = chunk preloaded/prefetched
/******/ 		// [resolve, reject, Promise] = chunk loading, 0 = chunk loaded
/******/ 		var installedChunks = {
/******/ 			"/js/app": 0,
/******/ 			"css/app": 0
/******/ 		};
/******/ 		
/******/ 		// no chunk on demand loading
/******/ 		
/******/ 		// no prefetching
/******/ 		
/******/ 		// no preloaded
/******/ 		
/******/ 		// no HMR
/******/ 		
/******/ 		// no HMR manifest
/******/ 		
/******/ 		__webpack_require__.O.j = (chunkId) => (installedChunks[chunkId] === 0);
/******/ 		
/******/ 		// install a JSONP callback for chunk loading
/******/ 		var webpackJsonpCallback = (parentChunkLoadingFunction, data) => {
/******/ 			var [chunkIds, moreModules, runtime] = data;
/******/ 			// add "moreModules" to the modules object,
/******/ 			// then flag all "chunkIds" as loaded and fire callback
/******/ 			var moduleId, chunkId, i = 0;
/******/ 			for(moduleId in moreModules) {
/******/ 				if(__webpack_require__.o(moreModules, moduleId)) {
/******/ 					__webpack_require__.m[moduleId] = moreModules[moduleId];
/******/ 				}
/******/ 			}
/******/ 			if(runtime) var result = runtime(__webpack_require__);
/******/ 			if(parentChunkLoadingFunction) parentChunkLoadingFunction(data);
/******/ 			for(;i < chunkIds.length; i++) {
/******/ 				chunkId = chunkIds[i];
/******/ 				if(__webpack_require__.o(installedChunks, chunkId) && installedChunks[chunkId]) {
/******/ 					installedChunks[chunkId][0]();
/******/ 				}
/******/ 				installedChunks[chunkIds[i]] = 0;
/******/ 			}
/******/ 			return __webpack_require__.O(result);
/******/ 		}
/******/ 		
/******/ 		var chunkLoadingGlobal = self["webpackChunk"] = self["webpackChunk"] || [];
/******/ 		chunkLoadingGlobal.forEach(webpackJsonpCallback.bind(null, 0));
/******/ 		chunkLoadingGlobal.push = webpackJsonpCallback.bind(null, chunkLoadingGlobal.push.bind(chunkLoadingGlobal));
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module depends on other loaded chunks and execution need to be delayed
/******/ 	__webpack_require__.O(undefined, ["css/app"], () => (__webpack_require__("./resources/js/app.js")))
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["css/app"], () => (__webpack_require__("./resources/sass/app.scss")))
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;