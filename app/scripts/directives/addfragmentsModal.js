'use strict';

/**
 * @ngdoc directive
 * @name peterbdotin.directive:eventPod
 * @description
 * # eventPod
 */
angular.module('thebarraudsApp')
  .directive('addfragmentsModal', function (serverFactory/*,util*/) {
    return {
      restrict: 'E',
      replace:true,
      scope: {
        addfragmentsdir: '=',
        addfragmenttopage: '&',
      },
      templateUrl: 'views/addfragmentsModal.html',
      link: function(scope/*, elem, attrs*/) {
        scope.addfragmentsdir = {
          newfragment: function(){
            scope.fragmenttype = null;
            serverFactory.getitems('fragmenttype',scope,'openaddfragmentsModal');
          },
        };
        scope.openaddfragmentsModal = function(data){
          scope.fragmenttypes = data.Items;
          $("#addfragmentsModal").modal('show');
        };
        scope.selectFragmentType = function(fragmenttype){
          scope.selectedfragmenttype = fragmenttype;
        };
        scope.savechanges = function(){
          if (scope.selectedfragmenttype === null){
            scope.err_msg = "Please select a Fragment";
          }
          else{
            serverFactory.getitem(scope.selectedfragmenttype.id,'pagefragment',scope,'pagefragmentgot');
            // first save the page fragment and then save the fragment to page
            // serverFactory.saveitemdetails($scope,$scope.pagepropertiesdata,"pagefragment","pagefragmentsaved");
          }
        };
        scope.pagefragmentgot = function (data){
          var pagefragmentData = data;
          pagefragmentData.title = scope.selectedfragmenttype.title;
          pagefragmentData.fragmenttype.push(scope.selectedfragmenttype);
          serverFactory.saveitemdetails(scope,pagefragmentData,"pagefragment","pagefragmentsaved");
        }
        scope.pagefragmentsaved = function(data){
          scope.addfragmenttopage({selectedpagefragment:data});
          $("#addfragmentsModal").modal('hide');
        }
      }
    };
  });
