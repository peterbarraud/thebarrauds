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
        savefragment: '&',
      },
      templateUrl: 'views/richText.html',

      link: function(scope, elem, attrs) {
        var fragmenthtml = $compile( attrs.pagefragmenthtml )( scope );
        scope.tinymceModel = attrs.pagefragmenthtml;

        scope.tinymceOptions = {
            plugins: 'link image code',
            toolbar: 'undo redo | bold italic | alignleft aligncenter alignright | code'
        };
        scope.save = function(){
          scope.savefragment({fragmenthtml:scope.tinymceModel});
        }
      }
    };
  });
