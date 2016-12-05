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
        var pagefragment = null;
        // alert(attrs.pagefragmentid);
        scope.boonga = attrs.pagefragmenthtml;
        // elem.append( attrs.pagefragmenthtml );
        serverFactory.getitem(attrs.pagefragmentid,'pagefragment',scope,'pagefragmentgot');

        scope.pagefragmentgot = function(data){
          pagefragment = data;
          var fragmenttype = $compile( '<' + pagefragment.fragmenttype[0].name + ' pagefragmenthtml="' + attrs.pagefragmenthtml + '" savefragment="savefragment(fragmenthtml)"></' + pagefragment.fragmenttype[0].name + '>' )( scope );
          modal_id = pagefragment.fragmenttype[0].name + '-modal';
          elem.append( fragmenttype );
        }

        scope.editFragment = function(){
          $('#' + modal_id).modal();
          // alert(0);
        };

        scope.savefragment = function(fragmenthtml){
          $('#' + modal_id).modal('hide');
          pagefragment.html = fragmenthtml;
          serverFactory.saveitemdetails(scope,pagefragment,"pagefragment","itemDetailsSaved");
        };

        scope.itemDetailsSaved = function(data){
          scope.boonga = data.html;
          console.log(data);
        }

      }
    };
  });
