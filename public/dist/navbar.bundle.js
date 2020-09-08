/******/ (function(modules) { // webpackBootstrap
/******/ 	// install a JSONP callback for chunk loading
/******/ 	function webpackJsonpCallback(data) {
/******/ 		var chunkIds = data[0];
/******/ 		var moreModules = data[1];
/******/ 		var executeModules = data[2];
/******/
/******/ 		// add "moreModules" to the modules object,
/******/ 		// then flag all "chunkIds" as loaded and fire callback
/******/ 		var moduleId, chunkId, i = 0, resolves = [];
/******/ 		for(;i < chunkIds.length; i++) {
/******/ 			chunkId = chunkIds[i];
/******/ 			if(Object.prototype.hasOwnProperty.call(installedChunks, chunkId) && installedChunks[chunkId]) {
/******/ 				resolves.push(installedChunks[chunkId][0]);
/******/ 			}
/******/ 			installedChunks[chunkId] = 0;
/******/ 		}
/******/ 		for(moduleId in moreModules) {
/******/ 			if(Object.prototype.hasOwnProperty.call(moreModules, moduleId)) {
/******/ 				modules[moduleId] = moreModules[moduleId];
/******/ 			}
/******/ 		}
/******/ 		if(parentJsonpFunction) parentJsonpFunction(data);
/******/
/******/ 		while(resolves.length) {
/******/ 			resolves.shift()();
/******/ 		}
/******/
/******/ 		// add entry modules from loaded chunk to deferred list
/******/ 		deferredModules.push.apply(deferredModules, executeModules || []);
/******/
/******/ 		// run deferred modules when all chunks ready
/******/ 		return checkDeferredModules();
/******/ 	};
/******/ 	function checkDeferredModules() {
/******/ 		var result;
/******/ 		for(var i = 0; i < deferredModules.length; i++) {
/******/ 			var deferredModule = deferredModules[i];
/******/ 			var fulfilled = true;
/******/ 			for(var j = 1; j < deferredModule.length; j++) {
/******/ 				var depId = deferredModule[j];
/******/ 				if(installedChunks[depId] !== 0) fulfilled = false;
/******/ 			}
/******/ 			if(fulfilled) {
/******/ 				deferredModules.splice(i--, 1);
/******/ 				result = __webpack_require__(__webpack_require__.s = deferredModule[0]);
/******/ 			}
/******/ 		}
/******/
/******/ 		return result;
/******/ 	}
/******/
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// object to store loaded and loading chunks
/******/ 	// undefined = chunk not loaded, null = chunk preloaded/prefetched
/******/ 	// Promise = chunk loading, 0 = chunk loaded
/******/ 	var installedChunks = {
/******/ 		"navbar": 0
/******/ 	};
/******/
/******/ 	var deferredModules = [];
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	var jsonpArray = window["webpackJsonp"] = window["webpackJsonp"] || [];
/******/ 	var oldJsonpFunction = jsonpArray.push.bind(jsonpArray);
/******/ 	jsonpArray.push = webpackJsonpCallback;
/******/ 	jsonpArray = jsonpArray.slice();
/******/ 	for(var i = 0; i < jsonpArray.length; i++) webpackJsonpCallback(jsonpArray[i]);
/******/ 	var parentJsonpFunction = oldJsonpFunction;
/******/
/******/
/******/ 	// add entry module to deferred list
/******/ 	deferredModules.push(["./assets/js/navbar.ts","vendors~navbar"]);
/******/ 	// run deferred modules when ready
/******/ 	return checkDeferredModules();
/******/ })
/************************************************************************/
/******/ ({

/***/ "./assets/js/components/navbar.ts":
/*!****************************************!*\
  !*** ./assets/js/components/navbar.ts ***!
  \****************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
eval("\nvar __importDefault = (this && this.__importDefault) || function (mod) {\n    return (mod && mod.__esModule) ? mod : { \"default\": mod };\n};\nObject.defineProperty(exports, \"__esModule\", { value: true });\nvar animejs_1 = __importDefault(__webpack_require__(/*! animejs */ \"./node_modules/animejs/lib/anime.es.js\"));\nvar Navbar = /** @class */ (function () {\n    function Navbar(navbar) {\n        var _this = this;\n        this.navbar = navbar;\n        this.responsiveOpen = false;\n        this.authInResponsive = false;\n        this.linksInResponsive = false;\n        this.breakpoints = [884, 700];\n        this.swapResponsiveIfNecessary = function () {\n            var width = window.innerWidth;\n            var _a = _this.breakpoints, first = _a[0], second = _a[1];\n            if (width < first && !_this.linksInResponsive) {\n                _this.linksInResponsive = true;\n                _this.responsive.appendChild(_this.links);\n            }\n            else if (_this.linksInResponsive && width > first) {\n                _this.linksInResponsive = false;\n                _this.navbar.insertBefore(_this.links, _this.search);\n            }\n            if (width < second && !_this.authInResponsive) {\n                _this.authInResponsive = true;\n                _this.responsive.appendChild(_this.authControls);\n            }\n            else if (_this.authInResponsive && width > second) {\n                _this.authInResponsive = false;\n                _this.navbar.insertBefore(_this.authControls, _this.burger);\n            }\n        };\n        this.toggleResponsive = function () {\n            if (_this.responsiveOpen) {\n                _this.responsiveOpen = false;\n                animejs_1.default({\n                    targets: _this.responsive,\n                    translateX: '0%',\n                    opacity: 0,\n                    duration: 200,\n                    easing: 'easeInOutQuad',\n                    complete: function () {\n                        _this.responsive.classList.toggle('--open');\n                    }\n                });\n            }\n            else {\n                _this.responsiveOpen = true;\n                animejs_1.default({\n                    targets: _this.responsive,\n                    translateX: '100%',\n                    opacity: 1,\n                    duration: 200,\n                    easing: 'easeInOutQuad',\n                    begin: function () {\n                        _this.responsive.classList.toggle('--open');\n                    }\n                });\n            }\n        };\n        this.setDom();\n        this.swapResponsiveIfNecessary();\n        this.setEventListeners();\n    }\n    Navbar.prototype.setDom = function () {\n        this.navbar = document.querySelector('.navbar-custom');\n        this.burger = this.navbar.querySelector('.burger');\n        this.responsive = this.navbar.querySelector('.navbar-responsive');\n        this.links = this.navbar.querySelector('.nav-links');\n        this.authControls = this.navbar.querySelector('.nav-auth-controls');\n        this.search = this.navbar.querySelector('.nav-search');\n    };\n    Navbar.prototype.setEventListeners = function () {\n        var _this = this;\n        window.addEventListener('resize', function () {\n            _this.swapResponsiveIfNecessary();\n        });\n        this.burger.addEventListener('click', function () {\n            _this.burger.classList.toggle('burger-close');\n            _this.toggleResponsive();\n        });\n    };\n    return Navbar;\n}());\nexports.default = Navbar;\n\n\n//# sourceURL=webpack:///./assets/js/components/navbar.ts?");

/***/ }),

/***/ "./assets/js/navbar.ts":
/*!*****************************!*\
  !*** ./assets/js/navbar.ts ***!
  \*****************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
eval("\nvar __importDefault = (this && this.__importDefault) || function (mod) {\n    return (mod && mod.__esModule) ? mod : { \"default\": mod };\n};\nObject.defineProperty(exports, \"__esModule\", { value: true });\nvar navbar_1 = __importDefault(__webpack_require__(/*! ./components/navbar */ \"./assets/js/components/navbar.ts\"));\nvar navbar = new navbar_1.default(document.querySelector('.navbar-custom'));\n\n\n//# sourceURL=webpack:///./assets/js/navbar.ts?");

/***/ })

/******/ });