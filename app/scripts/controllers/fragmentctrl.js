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
    $scope.pagepropertiesdata = null;
    $scope.listitemdata = null;

    $scope.pageavailable = function(){
      if ($scope.pagepropertiesdata === null){
        return false;
      }
      else {
        if ($scope.pagepropertiesdata.id > 0){
          return true;
        }
        else {
          return false;
        }
      }
    };
    $scope.deletepage = function(){
      $("#deletePagePrompt").modal('show');
    };
    $scope.deletepageconfirmed = function(){
      serverFactory.deletepage($scope.pagepropertiesdata.id,$scope,'pagedeleted');
    };
    $scope.pagedeleted = function(){
      $("#deletePagePrompt").modal('hide');
      $scope.pagelistdirective.pagelistupdated();
    }
    // itemtype,scope,callback
    $scope.newfragment = function(){
      // reset fragment type
      $scope.fragmenttype = null;
      serverFactory.getitems('fragmenttype',$scope,'openaddfragmentsModal');
    };
    $scope.openaddfragmentsModal = function(data){
      $scope.fragmenttypes = data.Items;
      $("#addfragmentsModal").modal('show');
    };
    // this function is called after the page properties are changed in the page properties dialog
    $scope.pagepropertychanged = function(){
      $scope.pagelistdirective.pagelistupdated();
    };
    $scope.$watch('listitemdata', function(newValue, oldValue) {
      if (newValue != null){
        serverFactory.getitem(newValue.id,'page',$scope,'manageitemobject');
      }
    });
    $scope.manageitemobject = function(data){
      $scope.pagepropertiesdata = data;
    }

  }]);
