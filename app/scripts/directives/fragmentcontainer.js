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
        var fragmenthtml = $compile( attrs.pagefragmenthtml )( scope );
        var modal_id = '';
        // alert(attrs.pagefragmentid);
        elem.append( fragmenthtml );
        serverFactory.getitem(attrs.pagefragmentid,'pagefragment',scope,'pagefragmentgot');

        scope.pagefragmentgot = function(data){
          var fragmenttype = $compile( '<' + data.fragmenttype[0].name + ' pagefragmenthtml="' + attrs.pagefragmenthtml + '" savefragment="savefragment(fragmenthtml)"></' + data.fragmenttype[0].name + '>' )( scope );
          modal_id = data.fragmenttype[0].name + '-modal';
          elem.append( fragmenttype );
        }

        scope.editFragment = function(){
          $('#' + modal_id).modal();
          // alert(0);
        };

        scope.savefragment = function(fragmenthtml){
          $('#' + modal_id).modal('hide');
          console.log(fragmenthtml);
        };

      }
    };
  });
