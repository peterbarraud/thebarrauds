'use strict';

/**
 * @ngdoc directive
 * @name peterbdotin.directive:eventPod
 * @description
 * # eventPod
 */
angular.module('thebarraudsApp')
  .directive('richText', function ($compile,serverFactory,util) {
    return {
      restrict: 'E',
      replace:false,
      scope: {
        irichtext: '=',
      },
      templateUrl: 'views/richText.html',

      link: function(scope, elem, attrs) {
        var fragmenthtml = $compile( attrs.pagefragmenthtml )( scope );
        elem.append( fragmenthtml );
        // console.log(attrs.pagefragmenthtml);

      }
    };
  });
