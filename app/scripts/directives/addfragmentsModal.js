'use strict';

/**
 * @ngdoc directive
 * @name peterbdotin.directive:eventPod
 * @description
 * # eventPod
 */
angular.module('thebarraudsApp')
  .directive('addfragmentsModal', function (serverFactory,util) {
    return {
      restrict: 'E',
      replace:true,
      scope: {
        fragmenttypes: '=',
        fragmenttype: '=',
        closeaddfragmentsmodal: '&',
      },
      templateUrl: 'views/addfragmentsModal.html',
      link: function(scope, elem, attrs) {
        scope.addnewfragment = function(){
          if (scope.fragmenttype === null){
            scope.err_msg = "Please select a Fragment";
          }
          else{
            scope.closeaddfragmentsmodal();
          }
        };
        scope.selectFragmentType = function(fragmentname){
          scope.fragmenttype = fragmentname;
        };

      }
    };
  });
