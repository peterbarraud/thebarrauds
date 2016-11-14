/*globals $:false */
'use strict';

/**
 * @ngdoc function
 * @name thecorrespondentApp.controller:AboutCtrl
 * @description
 * # AboutCtrl
 * Controller of the thecorrespondentApp
 */
angular.module('thebarraudsApp')
  .controller('FragmentCtrl', ['$scope','serverFactory', function($scope,serverFactory) {
    $scope.pagedata = null;
    $scope.openpagepropertiesmodal = function(){
      console.log($scope.pagedata);
      $scope.pagepropertiesdir.openpagepropertiesmodal();
    };
    // itemtype,scope,callback
    $scope.newfragment = function(){
      // reset fragment type
      $scope.fragmenttype = null;
      serverFactory.getitems('fragmenttype',$scope,'openaddfragmentsModal');
    };
    $scope.openaddfragmentsModal = function(data){
      $scope.fragmenttypes = data;
      $("#addfragmentsModal").modal('show');
    };

  }]);
