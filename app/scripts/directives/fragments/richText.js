'use strict';

/**
 * @ngdoc directive
 * @name peterbdotin.directive:eventPod
 * @description
 * # eventPod
 */
angular.module('thebarraudsApp')
  .directive('richtextDisplay', function (serverFactory,util) {
    return {
      restrict: 'E',
      replace:true,
      templateUrl: 'views/fragments/richtextDisplay.html',
      link: function(scope, elem, attrs) {

      }
    };
  });
