'use strict';

/**
 * @ngdoc overview
 * @name thebarraudsApp
 * @description
 * # thebarraudsApp
 *
 * Main module of the application.
 */
angular
  .module('thebarraudsApp', [
    'ngAnimate',
    'ngCookies',
    'ngResource',
    'ngRoute',
    'ngSanitize',
    'ngTouch',
    'ui.tinymce',
  ])
  .config(function ($routeProvider) {
    $routeProvider
    .when('/', {
      templateUrl: 'views/login.html',
      controller: 'LoginCtrl'
    })
    .when('/fragments', {
      templateUrl: 'views/fragments.html',
      controller: 'FragmentCtrl'
    })
    .otherwise({
        redirectTo: '/'
      });
  });
