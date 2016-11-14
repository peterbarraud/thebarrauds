'use strict';

/**
 * @ngdoc directive
 * @name peterbdotin.directive:eventPod
 * @description
 * # eventPod
 */
angular.module('thebarraudsApp')
  .directive('pageList', function (serverFactory) {
    return {
      restrict: 'E',
      scope: {
        pagedata: '=',
      },
      replace:true,
      templateUrl: 'views/pageList.html',
      // uncomment next line and remove following if you need the args
      // link: function(scope, elem, attrs) {
      link: function(scope) {
        serverFactory.getpagelist(scope,'managepagelist');
        scope.managepagelist = function(data){
          scope.pages = data;
        };
        scope.pageselect = function(page){
          console.log(page);
          scope.pagedata = page;
        };


      }
    };
  });
