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
        listitemdata: '=',
        pagelistdirective: '=',
      },
      replace:true,
      templateUrl: 'views/pageList.html',
      // uncomment next line and remove following if you need the args
      // link: function(scope, elem, attrs) {
      link: function(scope) {
        serverFactory.getpagelist(scope,'managepagelist');
        scope.managepagelist = function(data){
          scope.pages = data.Items;
        };
        scope.pageselect = function(page){
          scope.listitemdata = page;
        };
        scope.pagelistdirective = {
          pagelistupdated: function(){
            serverFactory.getpagelist(scope,'managepagelist');
          },
        }


      }
    };
  });
