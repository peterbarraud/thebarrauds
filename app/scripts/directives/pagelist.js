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
      link: function(scope/*, elem, attrs*/) {
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
        };


      }
    };
  });
