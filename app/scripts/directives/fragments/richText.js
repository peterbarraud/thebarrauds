'use strict';

/**
 * @ngdoc directive
 * @name peterbdotin.directive:eventPod
 * @description
 * # eventPod
 */
angular.module('thebarraudsApp')
  .directive('richText', function (serverFactory,util) {
    return {
      restrict: 'E',
      replace:true,
      templateUrl: 'views/fragments/richText.html',
      link: function(scope, elem, attrs) {

      }
    };
  });
