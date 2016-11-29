'use strict';

/**
 * @ngdoc directive
 * @name peterbdotin.directive:eventPod
 * @description
 * # eventPod
 */
angular.module('thebarraudsApp')
  .directive('fragmentContainer', function ($compile,serverFactory) {
    return {
      restrict: 'A',
      templateUrl: 'views/fragmentcontainer.html',
      link: function(scope, elem, attrs) {
        var el = $compile( "<b>poker</b>" )( scope );
        elem.append( el );
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
