/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!******************************!*\
  !*** ./resources/js/menu.js ***!
  \******************************/
$(document).ready(function () {
  $('#menu').click(function () {
    $('#sidenav')[0].style.width = "250px";
    $('#main')[0].style.marginLeft = "250px";
    $('#header')[0].style.marginLeft = "250px";
    $('#form')[0].style.marginLeft = "250px";
    $('body')[0].style.backgroundColor = "rgba(0,0,0,0.4)";
  });
  $('#closenav').click(function () {
    $('#sidenav')[0].style.width = "0";
    $('#main')[0].style.marginLeft = "0";
    $('#header')[0].style.marginLeft = "0";
    $('#form')[0].style.marginLeft = "0";
    $('body')[0].style.backgroundColor = "white";
  });
});
/******/ })()
;